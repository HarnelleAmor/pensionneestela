<?php

namespace App\Livewire;

use App\Events\BookingCancelled;
use App\Events\BookingConfirmed;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class ManageBookings extends Component
{

    public $bookings;

    public $checkin_bookings;

    public $checkout_bookings;

    public function mount()
    {
        $this->bookingRefresh();
    }

    public function bookingRefresh()
    {
        $this->bookings = Booking::where('is_archived', 0)
            ->where(function (Builder $query) {
                $query->where('status', 'pending')
                    ->orWhere('status', 'confirmed')
                    ->orWhere('status', 'checked-in');
            })
            ->get();

        $this->checkin_bookings = Booking::with(['unit', 'services'])
            ->whereDate('checkin_date', '=', Carbon::today())
            ->where('status', 'confirmed')
            ->where('reason_of_cancel', null)
            ->where('is_archived', false)
            ->get();

        $this->checkout_bookings = Booking::with(['unit', 'services'])
            ->whereDate('checkout_date', '=', Carbon::today())
            ->where('status', 'checked-in')
            ->where('is_archived', false)
            ->get();
    }

    public function confirm(Booking $booking)
    {
        $booking->status = 'confirmed';

        if ($booking->save()) {
            $booking_dispatch = Booking::find($booking->id);
            BookingConfirmed::dispatch($booking_dispatch);
            $this->bookingRefresh();
            $this->dispatch('confirmSuccess');
        } else {
            $this->dispatch('confirmError');
        }
        
    }

    public function cancel(Booking $booking, string $reason)
    {
        $booking->status = 'cancelled';
        $booking->reason_of_cancel = $reason; // no validation

        if ($booking->save()) {
            $booking_dispatch = Booking::find($booking->id);
            BookingCancelled::dispatch($booking_dispatch);
            $this->bookingRefresh();
            $this->dispatch('cancelSuccess');
        } else {
            $this->dispatch('cancelError');
        }
    }

    public function render()
    {
        return view('livewire.manage-bookings');
    }
}
