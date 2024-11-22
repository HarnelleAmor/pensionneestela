<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BookingQueue;
use App\Models\Unit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UnitCheckController extends Controller
{
    public function checkUnitPage()
    {
        return view('bookings.check_unit');
    }

    /**
     * Search the availability of all units
     */
    public function searchAvailUnit(Request $request)
    {
        $request->validate([
            'check-in' => 'bail|required|date|after_or_equal:today',
            'check-out' => 'required|date|after:check-in',
        ]);

        $checkin_date = $request->date('check-in');
        $checkout_date = $request->date('check-out');

        $units_with_status = Unit::with(['amenities', 'photos'])->get();
        foreach ($units_with_status as $unit) {
            $is_available = Booking::where('unit_id', $unit->id)
            ->where('is_archived', false)
            ->where(function ($query) {
                $query->where('status', 'pending')->orWhere('status', 'confirmed')->orWhere('status', 'checked-in');
            })
            ->where(function ($query) use ($checkin_date, $checkout_date) {
                $query->whereBetween('checkin_date', [$checkin_date, $checkout_date])
                      ->orWhereBetween('checkout_date', [$checkin_date, $checkout_date])
                      ->orWhere(function ($q) use ($checkin_date, $checkout_date) {
                          $q->where('checkin_date', '<=', $checkin_date)
                            ->where('checkout_date', '>=', $checkout_date);
                      });
            })
            ->doesntExist();

            $free_on_queue = BookingQueue::where('unit_id', $unit->id)
            ->where(function ($query) use ($checkin_date, $checkout_date) {
                $query->whereBetween('check_in', [$checkin_date, $checkout_date])
                    ->orWhereBetween('check_out', [$checkin_date, $checkout_date])
                    ->orWhere(function ($q) use ($checkin_date, $checkout_date) {
                        $q->where('check_in', '<=', $checkin_date)
                            ->where('check_out', '>=', $checkout_date);
                    });
            })
            ->doesntExist();

            $unit->is_available = $is_available && $free_on_queue ? true : false;
            $unit->checkin_date = $checkin_date;
            $unit->checkout_date = $checkout_date;
        }

        $parsed_in = Carbon::parse($checkin_date);
        $parsed_out = Carbon::parse($checkout_date);
        $no_of_nights = $parsed_in->diffInDays($parsed_out);
        $show_in = $parsed_in->format('F j, Y');
        $show_out = $parsed_out->format('F j, Y');
        if (Auth::check()) {
            return view('bookings.check_unit', compact('units_with_status', 'show_in', 'show_out', 'no_of_nights'));
        } else {
            return view('home.home-units', ['units' => $units_with_status], compact('show_in', 'show_out', 'no_of_nights'));
        }
    }
}