<?php

namespace App\Livewire;

use App\Models\BookingQueue;
use Carbon\Carbon;
use Livewire\Component;

class BookingQueues extends Component
{
    public $booking_queues;

    public function mount()
    {
        $this->getBookingQueues();
    }

    public function getBookingQueues()
    {
        $this->booking_queues = BookingQueue::with('user', 'unit')->get();
        foreach ($this->booking_queues as $queue) {
            $queue->started = Carbon::parse($queue->created_at)->diffForHumans();
        }
    }

    public function deleteQueue(BookingQueue $queue)
    {
        if ($queue->delete()) {
            $this->dispatch('deleteSuccess');
            $this->getBookingQueues();
        } else {
            $this->dispatch('deleteError');
        }
    }

    public function deleteAll()
    {
        if (BookingQueue::truncate()) {
            $this->dispatch('deleteAllSuccess');
            $this->getBookingQueues();
        } else {
            $this->dispatch('deleteAllError');
        }
        
    }

    public function render()
    {
        return view('livewire.booking-queues');
    }
}
