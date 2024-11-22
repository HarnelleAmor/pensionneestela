<?php

namespace App\Http\Controllers;

use App\Jobs\SendBookingEmail;
use App\Mail\SampleMail;
use App\Models\Booking;
use App\Models\BookingQueue;
use App\Models\User;
use App\Notifications\BookingCreated;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use RealRashid\SweetAlert\Facades\Alert;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('is-manager');
        $accounts = User::all();
        return view('accounts.account_index', compact('accounts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('is-manager');
        // $user = User::find(Auth::user()->id);
        // $user->notify(new BookingCreated(Booking::find(24)));
        // return (new BookingCreated(Booking::first()))->toMail(Booking::with('user')->first()->user);
        // Mail::to('harnelleamor@gmail.com')->queue(new SampleMail(Booking::first()));
        // return (new SampleMail(Booking::first()))->render();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('is-manager');
        
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'verify_email' => 'boolean',
            'phone_no' => 'required|numeric|digits:11|starts_with:09',
            'usertype' => 'required|in:customer,manager',
            'password' => ['required', Password::defaults()],
            'active' => 'boolean',
        ]);

        $user_created = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone_no' => $request->phone_no,
            'usertype' => $request->usertype,
            'password' => Hash::make($request->password),
            'email_verified_at' => $request->has('verify_email') ? Carbon::now() : null,
            'is_archived' => $request->has('active') ? 1 : 0
        ]);

        if (!$request->has('verify_email')) {
            event(new Registered($user_created));
        }

        if($user_created) {
            Alert::success('Success', 'User account \'' . $user_created->first_name . ' ' . $user_created->last_name . '\' is created successfully.');
            return redirect()->back();
        } else {
            Alert::error('Error', 'Something went wrong in creating the user.');
            return back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $account)
    {
        Gate::authorize('is-manager');

        $account->load('bookings');
        return view('accounts.account_show', compact('account'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $account)
    {
        Gate::authorize('is-manager');


        return  view('accounts.account_edit', compact('account'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $account)
    {
        Gate::authorize('is-manager');

        // Validate the incoming request
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($account->id)],
            'phone_no' => ['required', 'regex:/^09\d{9}$/'],
        ]);

        // Fill the account model with only validated fields
        $account->fill($request->only(['first_name', 'last_name', 'email', 'phone_no']));

        // Check if the model is dirty before saving to avoid unnecessary update
        if ($account->isDirty()) {
            try {
                $account->save();

                Alert::success('Success', 'The account is updated.');
                return redirect()->back();
            } catch (\Exception $e) {
                // Log the error for debugging (optional)
                Log::error('Error updating account: ' . $e->getMessage());

                Alert::error('Error', 'Error: '. $e->getMessage());
                return redirect()->back();
            }
        }

        Alert::info('No Update', 'No changes detected in the account details.');
        return redirect()->back();
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $account)
    {
        Gate::authorize('is-manager');
        // 
    }

    public function deactivate(User $account)
    {
        Gate::authorize('is-manager');

        $no_bookings = Booking::where('user_id', $account->id)
            ->where(function (Builder $query) {
                $query->where('status', 'pending')
                    ->orWhere('status', 'confirmed')
                    ->orWhere('status', 'checked-in');
            })
            ->where('is_archived', 0)
            ->doesntExist();
        
        $no_booking_queue = BookingQueue::where('user_id', $account->id)->doesntExist();

        if ($no_bookings && $no_booking_queue) {
            $account->is_archived = true;
            if ($account->save()) {
                // send deactivation notification
                Alert::success('Success', 'The account is deactivated.');
                return redirect()->back();
            } else {
                Alert::error('Error', 'Something went wrong in deactivating account');
                return redirect()->back();
            }
        } else {
            Alert::error('Error', 'Account has active bookings.');
            return back();
        }
    }

    public function activate(User $account)
    {
        Gate::authorize('is-manager');
        
        $account->is_archived = false;
        if ($account->save()) {
            // send activation notification
            Alert::success('Success', 'The account is activated.');
            return redirect()->back();
        } else {
            Alert::error('Error', 'Something went wrong in activating account');
            return redirect()->back();
        }
    }
}
