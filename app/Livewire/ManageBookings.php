<?php

namespace App\Livewire;

use App\Events\BookingCancelled;
use App\Events\BookingConfirmed;
use App\Models\Booking;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class ManageBookings extends Component
{

    public $bookings;

    public function mount()
    {
        $this->bookings = Booking::where('is_archived', 0)
            ->where(function (Builder $query) {
                $query->where('status', 'pending')
                    ->orWhere('status', 'confirmed')
                    ->orWhere('status', 'checked-in');
            })
            ->get();
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
