<?php

namespace App\Events;

use App\Models\Booking;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Events\ShouldDispatchAfterCommit;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class BookingCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Booking $booking;
    public $ondemand_email = null;
    /**
     * Create a new event instance.
     */
    public function __construct(Booking $booking)
    {
        $booking->load('user');
        $this->booking = $booking;
        if ($booking->email != $booking->user->email) {
            $this->ondemand_email = $booking->email;
        }
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('users.' . Auth::id()),
        ];
    }
}
