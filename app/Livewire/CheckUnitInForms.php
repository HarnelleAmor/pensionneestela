<?php

namespace App\Livewire;

use App\Models\Booking;
use App\Models\BookingQueue;
use App\Models\Unit;
use Carbon\Carbon;
use Livewire\Attributes\Locked;
use Livewire\Component;

class CheckUnitInForms extends Component
{
    public $units_with_status;

    public $startDate = '';
    public $endDate = '';

    #[Locked]
    public $no_of_nights = 0;

    public $date_selected;
    public $days_selected;

    #[Locked]
    public $new_total_payment;

    #[Locked]
    public $new_outstanding_payment;

    public $booking;

    public function mount(int $booking)
    {
        $this->booking = Booking::with(['unit', 'services'])->findOrFail($booking);
        // dd($this->booking);
        $this->startDate = Carbon::now()->toDateString();
        $this->endDate = Carbon::parse($this->startDate)->addDay()->toDateString();
        $this->units_with_status = Unit::with(['amenities', 'photos'])->get();
        $this->checkUnits();
    }

    public function checkUnits()
    {
        $this->reset('no_of_nights', 'new_total_payment', 'new_outstanding_payment');
        $this->validate([
            'startDate' => 'required|date|after_or_equal:today',
            'endDate' => 'required|date|after:startDate'
        ]);

        $checkin_date = Carbon::parse($this->startDate);
        $checkout_date = Carbon::parse($this->endDate);

        $this->date_selected = $checkin_date->format('M j') . ' - ' . $checkout_date->format('M j, Y');
        $this->days_selected = $checkin_date->format('l') . ' - ' . $checkout_date->format('l');
        foreach ($this->units_with_status as $unit) {
            $unit->is_available = $this->checkAvail($unit);
            $unit->checkin_date = $checkin_date;
            $unit->checkout_date = $checkout_date;
        }
        $this->no_of_nights = $checkin_date->diffInDays($checkout_date);

        $orig_no_of_nights = Carbon::parse($this->booking->checkin_date)->diffInDays(Carbon::parse($this->booking->checkout_date));
        $add_charge = $this->booking->total_payment - ($this->booking->unit->price_per_night * $orig_no_of_nights);
        $this->new_total_payment = ($this->booking->unit->price_per_night * $this->no_of_nights) + $add_charge;
        $this->new_outstanding_payment = $this->new_total_payment - ($this->booking->total_payment - $this->booking->outstanding_payment);
    }

    public function checkAvail(Unit $unit): bool
    {
        $checkin_date = Carbon::parse($this->startDate);
        $checkout_date = Carbon::parse($this->endDate);

        $is_available = Booking::where('unit_id', $unit->id)
            ->where('is_archived', false)
            ->where(function ($query) {
                $query->where('status', 'pending')->orWhere('status', 'confirmed');
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
            // ->dd();
            ->doesntExist();
        
        // dump($is_available, $free_on_queue);
        return $is_available && $free_on_queue;
    }


    public function updateBookingForm()
    {

    }


    public function render()
    {
        return view('livewire.check-unit-in-forms')->with(['booking' => $this->booking]);
    }
}
