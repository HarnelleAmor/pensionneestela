<?php

namespace App\Events;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class Example implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    // public function broadcastQueue():string
    // {
    //     return 'chat';
    // }

    /**
     * Create a new event instance.
     */
    public function __construct(public Booking $booking)
    {
        //
    }

    public function broadcastWith(): array
    {
        return [
            'reference_no' => $this->booking->reference_no,
            'first_name' => $this->booking->user->first_name,
            'last_name' => $this->booking->user->last_name,
            'unit_name' => $this->booking->unit->name,
            'checkin_date' => $this->booking->checkin_date,
            'checkout_date' => $this->booking->checkout_date,
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'example';
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
