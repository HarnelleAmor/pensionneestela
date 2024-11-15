<?php

namespace App\Http\Controllers;

use App\Events\BookingCreated;
use App\Jobs\SendBookingEmail;
use App\Models\Booking;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use App\Models\BookingQueue;
use App\Models\Service;
use App\Models\Unit;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use RealRashid\SweetAlert\Facades\Alert;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Gate::allows('is-customer')) {
            $bookings = Booking::with(['services', 'unit'])
                ->where([
                    ['user_id', Auth::id()],
                    ['is_archived', false]
                ])
                ->get();
            return view('bookings.booking_history', compact('bookings'));
        } else {
            $bookings = Booking::with(['services', 'unit'])
                ->where('is_archived', false)
                ->latest('checkin_date')
                ->get();
            $units = Unit::all();
            return view('bookings.booking_index', compact('bookings', 'units'));
        }
    }

    public function getAllBookings()
    {
        Gate::authorize('is-manager');
        $bookings = Booking::with(['services', 'unit'])
            ->where('is_archived', false)
            ->latest('checkin_date')
            ->get();
        return response()->json($bookings);
    }

    /**
     * Receive's the unit and dates chosen by the user, and then proceeds to booking form.
     */
    public function postSelectedUnit(Request $request)
    {
        if ($request->has('makeNewBookForm')) {
            BookingQueue::where('user_id', Auth::id())->delete();
        } else {
            $has_booking_queue = BookingQueue::where('user_id', Auth::id())->exists();
            if ($has_booking_queue) {
                return redirect()->route('booking.formCreate')->with('queue_exists', 'There is an existing booking form.')->withInput($request->all());
            }
        }


        $request->validate([
            'unit_id' => 'required|exists:units,id',
            'checkin' => 'required|date|after_or_equal:today',
            'checkout' => 'required|date|after:checkin',
        ]);

        $booking = null;
        if (empty($request->session()->get('booking'))) {
            $booking = new Booking();
            $booking->fill([
                'user_id' => Auth::id(),
                'unit_id' => $request->unit_id,
                'checkin_date' => $request->checkin,
                'checkout_date' => $request->checkout
            ]);
            $request->session()->put('booking', $booking);
        } else {
            $booking = $request->session()->get('booking');
            $booking->fill([
                'user_id' => Auth::id(),
                'unit_id' => $request->unit_id,
                'checkin_date' => $request->checkin,
                'checkout_date' => $request->checkout
            ]);
            $request->session()->put('booking', $booking);
        }

        $checkin = $booking->checkin_date;
        $checkout = $booking->checkout_date;
        $last_queue_check = BookingQueue::where('unit_id', $booking->unit_id)
        ->where(function ($query) use ($checkin, $checkout) {
            $query->whereBetween('check_in', [$checkin, $checkout])
                ->orWhereBetween('check_out', [$checkin, $checkout])
                ->orWhere(function ($q) use ($checkin, $checkout) {
                    $q->where('check_in', '<=', $checkin)
                        ->where('check_out', '>=', $checkout);
                });
        })
        ->whereNot('user_id', Auth::id())
        ->exists();

        if ($last_queue_check) {
            Alert::error('Oops...', 'Look\'s like someone started booking the unit before you did. Try checking our other units. Thank you for your understanding :)');
            return back();
        } else {
            // add the unit and dates to the booking queue table
            BookingQueue::create([
                'user_id' => Auth::id(),
                'unit_id' => $request->unit_id,
                'check_in' => $request->checkin,
                'check_out' => $request->checkout
            ]);
        }
        
        return redirect()->route('booking.formCreate');
    }

    /**
     * Display the booking form.
     */
    public function createBookingForm(Request $request)
    {
        if (!$request->session()->has('booking')) {
            abort(403);
        }

        $booking = $request->session()->get('booking');
        $unit_selected = Unit::with(['photos', 'amenities'])->find($booking->unit_id);
        $unit_photo = $unit_selected->photos->first()->photos_path;
        // dd($unit_selected->amenities->amenity->where('highlight', true));
        $has_wifi = !empty($unit_selected->amenities->where('name', 'Free Wifi'));
        // $unit_highlights = $unit_selected->amenities->amenity
        $checkin = $booking->checkin_date;
        $checkout = $booking->checkout_date;
        $no_of_nights = Carbon::parse($checkin)->diffInDays(Carbon::parse($checkout));
        $servicesModel = Service::select('id', 'name', 'service_cost')->get();

        $sessionServices = null;
        if ($request->session()->exists('sessionServices')) {
            $sessionServices = $request->session()->get('sessionServices');
            // dump($sessionServices);
        }
        // dd($sessionServices[0]['quantity']);
        $services = [];
        foreach ($servicesModel as $item) {
            if (is_null($sessionServices) || !in_array($item->id, array_column($sessionServices, 'id'))) {
                $services[] = [
                    'id' => $item->id,
                    'name' => $item->name,
                    'service_cost' => $item->service_cost,
                    'is_checked' => false,
                    'quantity' => '',
                    'details' => ''
                ];
            } else {
                $services[] = [
                    'id' => $item->id,
                    'name' => $item->name,
                    'service_cost' => $item->service_cost,
                    'is_checked' => true,
                    'quantity' => $sessionServices[array_search($item->id, array_column($sessionServices, 'id'))]['quantity'],
                    'details' => $sessionServices[array_search($item->id, array_column($sessionServices, 'id'))]['details']
                ];
            }
        }

        $user = User::find(Auth::id());
        return view('bookings.booking_create', compact('booking', 'user', 'services', 'unit_selected', 'checkin', 'checkout', 'unit_photo', 'has_wifi', 'no_of_nights'));
    }

    public function createRebookingForm(Booking $booking)
    {
        Gate::allows('view-booking', $booking);
        $booking->load('unit');
        return view('bookings.booking_rebook', compact('booking'));
    }

    /**
     * Receive's the booking info, then proceeds to the payment
     */
    public function postBookingForm(Request $request)
    {
        $rules = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone_no' => 'required|regex:/^09\d{9}$/',
            'email' => 'required|email',
            'no_of_guests' => 'required|integer|min:1',
        ];
        $attributes = [
            'first_name' => 'first name',
            'last_name' => 'last name',
            'email' => 'email address',
            'phone_no' => 'phone number',
            'no_of_guests' => 'number of guests',
        ];
        $services = Service::all();
        $wakawaka = [];
        foreach ($services as $service) {
            $wakawaka[] = 'service' . $service->id;

            $rules['service' . $service->id] = 'nullable|integer|exists:services,id';
            $rules['quantity' . $service->id] = 'nullable|integer|between:1,6';
            $rules['description' . $service->id] = 'nullable|string';

            $attributes['service' . $service->id] = $service->name . ' checkbox';
            $attributes['quantity' . $service->id] = $service->name . ' quantity';
            $attributes['description' . $service->id] = $service->name . ' description';
        }
        $request->validate($rules, [], $attributes);

        $booking = $request->session()->get('booking');

        $unit = Unit::find($booking->unit_id);
        $total_amount = $unit->price_per_night;
        $in = Carbon::parse($booking->checkin_date);
        $out = Carbon::parse($booking->checkout_date);
        if ($in->diffInDays($out) > 1) {
            $total_amount *= $in->diffInDays($out);
        }
        $downpayment = $total_amount / 2;
        $request->session()->put('booking_downpayment', $downpayment);

        $sessionServices = [];
        if ($request->hasAny($wakawaka)) {
            foreach ($services as $service) {
                if ($request->has('service' . $service->id)) {
                    $sessionServices[] = [
                        'id' => $service->id,
                        'name' => $service->name,
                        'is_checked' => true,
                        'cost' => $service->service_cost,
                        'service_cost' => $service->name === 'Meal Service' ? $service->service_cost : $service->service_cost * $request->input('quantity' . $service->id),
                        'quantity' => $request->input('quantity' . $service->id),
                        'details' => $request->input('description' . $service->id)
                    ];

                    $total_amount += $service->service_cost * $request->input('quantity' . $service->id);
                }
            }

            $request->session()->put('sessionServices', $sessionServices);
        } else {
            if (!empty($request->session()->get('sessionServices'))) {
                $request->session()->forget('sessionServices');
            }
        }

        $booking->fill([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone_no' => $request->phone_no,
            'no_of_guests' => $request->no_of_guests,
            'total_payment' => $total_amount
        ]);
        $request->session()->put('booking', $booking);

        return redirect()->route('booking.payCreate');
    }

    public function postRebookingForm(Request $request, Booking $booking)
    {
        Gate::authorize('view-booking', $booking);
        $request->validate([
            'new_unit' => 'required|integer',
            'new_checkin' => 'required|date|after_or_equal:today',
            'new_checkout' => 'required|date|after:new_checkin',
        ]);
        
        $booking->unit_id = $request->new_unit;
        $booking->checkin_date = Carbon::parse($request->new_checkin);
        $booking->checkout_date = Carbon::parse($request->new_checkout);

        if($booking->isDirty())
        {
            $booking_queue = BookingQueue::create([
                'user_id' => $request->user()->id,
                'unit_id' => $request->new_unit,
                'check_in' => Carbon::parse($request->new_checkin),
                'check_out' => Carbon::parse($request->new_checkout),
            ]);
            if (Gate::allows('is-manager')) {
                $booking->status = 'confirmed';
            } else {
                $booking->status = 'pending';
            }
            
            if ($booking->save()) {
                $booking_queue->delete();
                if (Gate::allows('is-manager')) {
                    Alert::success('Booking Rescheduled', 'A confirmation will be sent to the customer shortly.');
                    return redirect()->route('bookings.index');
                } else {
                    Alert::success('Request Sent', 'We will send you a confirmation email when the request is confirmed.');
                    return redirect()->route('customerdashboard');
                }
            } else {
                $booking_queue->delete();
                Alert::error('Error', 'Something went wrong in rescheduling the booking');
                return back()->withInput();
            }
        } else {
            Alert::info('No Action', 'There are no changes in the form submitted.');
            return back();
        }
    }

    /**
     * Displays the gcash info page
     */
    public function getBookingPay(Request $request)
    {
        if (!$request->session()->has('booking') && !$request->session()->has('booking_downpayment') && !$request->session()->has('sessionServices')) {
            if (Gate::allows('is-customer')) {
                return redirect()->route('customerdashboard')->with('error', 'Action not allowed.');
            } else {
                return redirect()->route('managerdashboard')->with('error', 'Action not allowed.');
            }
        }

        $booking = $request->session()->get('booking');
        $selectedUnit = Unit::find($booking->unit_id);
        $unit_photo = $selectedUnit->photos->first()->photos_path;
        $downpayment = $request->session()->get('booking_downpayment');
        $sessionServices = $request->session()->get('sessionServices');
        $no_of_nights = Carbon::parse($booking->checkin_date)->diffInDays(Carbon::parse($booking->checkout_date));
        return view('bookings.booking_gcash', compact('booking', 'sessionServices', 'selectedUnit', 'downpayment', 'no_of_nights', 'unit_photo'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'ref_no' => ['required', 'unique:bookings,gcash_ref_no'],
            'privTerms' => ['accepted']
        ]);
        $booking = $request->session()->get('booking');
        $selectedServices = $request->session()->get('sessionServices');
        $downpayment = $request->session()->get('booking_downpayment');
        $outstanding_pay = $booking->total_payment - $downpayment;

        $booking->fill([
            'status' =>  Auth::user()->usertype == 'manager' ? 'confirmed' : 'pending',
            'outstanding_payment' => $outstanding_pay,
            'gcash_ref_no' => $request->ref_no == 'cash' ? null : $request->ref_no
        ]);

        try {
            DB::transaction(function () use ($booking, $selectedServices, $request) {
                $newBooking = Booking::create([
                    'unit_id' => $booking->unit_id,
                    'user_id' => $booking->user_id,
                    'checkin_date' => $booking->checkin_date,
                    'checkout_date' => $booking->checkout_date,
                    'first_name' => $booking->first_name,
                    'last_name' => $booking->last_name,
                    'email' => $booking->email,
                    'phone_no' => $booking->phone_no,
                    'no_of_guests' => $booking->no_of_guests,
                    'total_payment' => $booking->total_payment,
                    'status' => $booking->status,
                    'outstanding_payment' => $booking->outstanding_payment,
                    'gcash_ref_no' => $booking->gcash_ref_no,
                ]);

                if (!empty($selectedServices)) {
                    foreach ($selectedServices as $service) {
                        $newBooking->services()->attach($service['id'], [
                            'quantity' => $service['quantity'],
                            'details' => $service['details']
                        ]);
                    }
                }

                BookingCreated::dispatch($newBooking);

                $request->session()->forget(['booking', 'selectedServices', 'booking_downpayment', 'sessionServices']);

                BookingQueue::where('user_id', Auth::id())->delete();
            }, 2);
        } catch (\Exception $e) {
            Alert::error('Error!', 'Something went wrong in making the booking. ' . $e->getMessage());
            return back()->withInput();
        }

        if (Gate::allows('is-manager')) {
            Alert::success('Booking Created!', 'Booking is created and confirmed.');
            return redirect()->route('managerdashboard');
        } else {
            Alert::success('Booking Created!', 'You\'re booking is created successfully. Let\'s wait for the staff to confirm your booking.');
            return redirect()->route('customerdashboard');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        Gate::authorize('view-booking', $booking);

        $services = Service::where('is_archived', false)->get();
        $services_availed = [];
        foreach ($services as $service) {
            if ($booking->services->contains($service->id)) {
                $services_availed[] = [
                    'id' => $service->id,
                    'name' => $service->name,
                    'is_checked' => true,
                    'service_cost' => $service->service_cost,
                    'quantity' => $booking->services->find($service->id)->service->quantity,
                    'details' => $booking->services->find($service->id)->service->details
                ];
            } else {
                $services_availed[] = [
                    'id' => $service->id,
                    'name' => $service->name,
                    'is_checked' => false,
                    'service_cost' => $service->service_cost,
                    'quantity' => '',
                    'details' => ''
                ];
            }
        }
        $no_of_nights = Carbon::parse($booking->checkin_date)->diffInDays(Carbon::parse($booking->checkout_date));
        return view('bookings.booking_show', compact('booking', 'no_of_nights', 'services_availed'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Booking $booking)
    {
        return view('bookings.booking_edit', compact('booking'));
    }

    /**
     * Update the booking status to 'confirm'
     */
    public function confirmBooking(Booking $booking)
    {
        $booking->status = 'confirmed';
        if ($booking->save()) {
            Alert::success('Booking Confirmed!', 'The customer will be notified of their confirmed booking.');
            return redirect()->back()->with('success', 'The booking is now confirmed.');
        } else {
            Alert::error('Booking NOT Confirmed!', 'Something went wrong when confirming the booking.');
            return back()->with('error', 'Something went wrong when confirming the booking.');
        }
    }

    public function checkinBooking(Booking $booking)
    {
        $booking->checkin_time = Carbon::now();
        $booking->status = 'checked-in';
        if ($booking->save()) {
            return redirect()->back()->with('success', 'Booking is updated. Guest/s arrived.');
        } else {
            return back()->with('error', 'Something went wrong when checking in guest/s.');
        }
    }

    public function checkoutBooking(Booking $booking)
    {
        $booking->checkout_time = Carbon::now();
        $booking->status = 'checked-out';
        $booking->outstanding_payment = 0;
        if ($booking->save()) {
            return redirect()->back()->with('success', 'Booking is updated. Guest/s departed.');
        } else {
            return back()->with('error', 'Something went wrong when checking out guest/s.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookingRequest $request, Booking $booking)
    {
        //
    }

    /**
     * Update the services availed.
     */
    public function updateServices(Request $request, Booking $booking)
    {
        $services = Service::all();
        $wakawaka = $rules = $attributes = [];
        foreach ($services as $service) {
            $wakawaka[] = 'service' . $service->id;

            $rules['service' . $service->id] = 'nullable|integer|exists:services,id';
            $rules['quantity' . $service->id] = 'nullable|integer|between:1,6';
            $rules['description' . $service->id] = 'nullable|string';

            $attributes['service' . $service->id] = $service->name . ' checkbox';
            $attributes['quantity' . $service->id] = $service->name . ' quantity';
            $attributes['description' . $service->id] = $service->name . ' description';
        }
        $request->validate($rules, [], $attributes);

        $price_per_night = $booking->unit->price_per_night;
        $total_amount = $price_per_night;
        $no_of_nights = Carbon::parse($booking->checkin_date)->diffInDays(Carbon::parse($booking->checkout_date));
        if ($no_of_nights > 1) {
            $total_amount *= $no_of_nights;
        }
        $syncData = [];
        if ($request->hasAny($wakawaka)) {
            foreach ($services as $service) {
                if ($request->has('service' . $service->id)) {
                    $syncData[$service->id] = [
                        'quantity' => $request->input('quantity' . $service->id),
                        'details' => $request->input('description' . $service->id)
                    ];

                    $total_amount += $service->service_cost * $request->input('quantity' . $service->id);
                }
            }
        }

        try {
            DB::transaction(function () use ($booking, $total_amount, $syncData, $price_per_night, $no_of_nights) {
                $booking->total_payment = $total_amount;
                $booking->outstanding_payment = $total_amount - (($price_per_night * $no_of_nights) / 2);
                $booking->save();

                $booking->services()->sync($syncData);
            }, 2);

            return redirect()->back()->with('success', 'The availed services is updated.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Something went wrong when updating availed services.');
        }
    }

    /**
     * Cancel the selected booking transaction.
     */
    public function cancelBooking(Request $request, Booking $booking)
    {
        if ($booking->reason_of_cancel == null && $request->has('cancellation_reason')) {
            $request->validate([
                'cancellation_reason' => 'required|string|max:500'
            ]);
            $booking->reason_of_cancel = $request->cancellation_reason;
            if (Auth::user()->usertype == "manager") {
                $booking->status = 'cancelled';
            }
        } elseif (isset($booking->reason_of_cancel) && ($booking->status == 'confirmed' || $booking->status == 'pending')) {
            $booking->status = 'cancelled';
        }

        if ($booking->save()) {
            Alert::success('Success', 'Booking #'.$booking->reference_no.' is cancelled.');
            return redirect()->back();
        } else {
            Alert::success('Error', 'Something went wrong in cancelling #'.$booking->reference_no.'.');
            return back()->withInput();
        }
    }

    public function noshowBooking(Request $request, Booking $booking)
    {
        $booking->status = 'no-show';
        if ($booking->save()) {
            return redirect()->back();
        } else {
            return back()->with('error', 'Something went wrong in updating the booking.');
        }
    }

    public function deleteQueue(Request $request)
    {
        // dd($request->destination);
        BookingQueue::where('user_id', Auth::id())->delete();

        // BookingQueue::create([
        //     'user_id', Auth::id(),
        //     'unit_id'
        // ]);

        return redirect($request->destination);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        //
    }
}
