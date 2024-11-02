<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Unit;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use RealRashid\SweetAlert\Facades\Alert;

class DashboardController extends Controller
{
    public function customerDashboard()
    {
        Gate::authorize('is-customer');
        $upcoming_bookings = Booking::with(['services', 'unit'])
            ->where('user_id', Auth::id())
            ->where(function (Builder $query) {
                $query->where('status', 'pending')->orWhere('status', 'confirmed');
            })
            ->where('reason_of_cancel', null)
            ->where('is_archived', false)
            ->oldest('checkin_date')
            ->get();
        // ->dd();
        return view('customerdashboard.c-dashboard', compact('upcoming_bookings'));
    }

    public function managerDashboard()
    {
        Gate::authorize('is-manager');
        // $notifications = auth()->user()->notifications;
        // dd($notifications);
        $units = Unit::with('photos')->get();
        $pending_bookings = Booking::with('services')
            ->where('status', 'pending')
            ->where('reason_of_cancel', null)
            ->where('is_archived', false)
            ->oldest('checkin_date')
            ->get();
        
        $upcoming_bookings = Booking::with('services')
            ->where('status', 'confirmed')
            ->where('reason_of_cancel', null)
            ->where('is_archived', false)
            ->oldest('checkin_date')
            ->get();

        $upcoming_services = $upcoming_bookings->flatMap(function ($booking) {
            return $booking->services; // Collect services from each booking
        });

        $checkin_bookings = Booking::with(['unit', 'services'])
            ->whereDate('checkin_date', '=', Carbon::today())
            ->where('status', 'confirmed')
            ->where('reason_of_cancel', null)
            ->where('is_archived', false)
            ->get();
        
        $checkout_bookings = Booking::with(['unit', 'services'])
            ->whereDate('checkout_date', '=', Carbon::today())
            ->where('status', 'checked-in')
            ->where('is_archived', false)
            ->get();

        $for_approvals = Booking::with(['unit', 'services'])
            ->where(function (Builder $query) {
                $query->where('status', 'pending')->orWhere('status', 'confirmed');
            })
            ->whereNot('reason_of_cancel', null)
            ->where('is_archived', false)
            ->get();

        foreach ($units as $unit) {
            $booking = Booking::where('unit_id', $unit->id)
                ->where(function (Builder $query) {
                    $query->where('checkin_date', Carbon::today())->orWhere('checkout_date', Carbon::today());
                })
                ->where('status', 'checked-in')
                ->where('is_archived', false)
                ->first();
            if (!is_null($booking)) {
                $unit->is_available = false;
                
                $unit->booking = $booking;
            } else {
                $unit->is_available = true;
            }
            $unit->image = $unit->photos->first()->photos_path;
            $unit->unit_bookings = Booking::where('unit_id', $unit->id)
                ->where('is_archived', false)
                ->count();
        }
        $total_bookings = Booking::whereMonth('checkout_date', Carbon::now()->month)->count();
        $total_customers = User::where('usertype', 'customer')->count();
        $total_revenue = Booking::whereMonth('checkout_date', Carbon::now()->month)
            ->where('status', 'checked-out')
            ->sum('total_payment');

        $checkedout_bookings = Booking::where('is_archived', false)
            ->where('status', 'checked-out')
            ->get();
        
        $cancelled_bookings = Booking::where('is_archived', false)
            ->where('status', 'cancelled')
            ->get();

        $noshow_bookings = Booking::where('is_archived', false)
            ->where('status', 'no-show')
            ->get();

        $donut_bookings = [
            'labels' => ['Pending', 'Confirmed', 'Completed', 'Cancelled', 'No Show'],
            'data' => [
                $pending_bookings->count(),
                $upcoming_bookings->count(),
                $checkedout_bookings->count(),
                $cancelled_bookings->count(),
                $noshow_bookings->count()
            ],
            'total' => Booking::where('is_archived', false)->count(),
        ];

        $user = User::find(Auth::id());
        $notifications = $user->notifications()->take(20)->get();
        $unread_notifications = $user->unreadNotifications()->take(20)->get();
        // dd($notifications->first());

        return view('managerdashboard.m-dashboard', compact('units', 'upcoming_bookings', 'upcoming_services', 'pending_bookings', 'checkin_bookings', 'checkout_bookings', 'total_bookings', 'total_customers', 'for_approvals', 'total_revenue', 'donut_bookings', 'notifications', 'unread_notifications'));
    }
}
