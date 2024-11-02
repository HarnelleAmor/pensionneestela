<?php

namespace App\Livewire;

use App\Models\Booking;
use App\Models\BookingQueue;
use App\Models\Unit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CheckUnits extends Component
{
    public $units_with_status; 

    public $status_A1;
    public $status_A2;
    public $status_B1;
    public $status_B2;

    public $no_of_nights = 0;

    #[Validate('required|date|after_or_equal:today')]
    public $startDate = '';

    #[Validate('required|date|after:startDate')]
    public $endDate = '';

    public function mount()
    {
        $this->startDate = Carbon::today()->toDateString();
        $this->endDate = Carbon::parse($this->startDate)->addDay()->toDateString();

        $this->units_with_status = Unit::with(['amenities', 'photos'])->get();
        foreach ($this->units_with_status as $unit) {
            $unit->is_available = $this->checkAvail($unit);
            $unit->checkin_date = $this->startDate;
            $unit->checkout_date = $this->endDate;
        }
        $this->no_of_nights = Carbon::parse($this->startDate)->diffInDays(Carbon::parse($this->endDate));
        // dd($this->units_with_status);
        // dump($this->startDate, $this->endDate);
    }

    public function checkUnits()
    {
        $this->reset('status_A1', 'status_A2', 'status_B1', 'status_B2');
        $this->validate();

        foreach ($this->units_with_status as $unit) {
            $unit->is_available = $this->checkAvail($unit);
            $unit->checkin_date = $this->startDate;
            $unit->checkout_date = $this->endDate;
        }
        $this->no_of_nights = Carbon::parse($this->startDate)->diffInDays(Carbon::parse($this->endDate));

        $this->dispatch('checkLoading-true');
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
            ->doesntExist();
        
        return $is_available && $free_on_queue;
    }

    public function render()
    {
        return view('livewire.check-units');
    }
}
