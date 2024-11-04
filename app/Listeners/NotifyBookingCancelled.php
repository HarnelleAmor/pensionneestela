<?php

namespace App\Listeners;

use App\Events\BookingCancelled;
use App\Events\BookingConfirmed;
use App\Models\User;
use App\Notifications\BookingCancelledNotification;
use App\Notifications\BookingConfirmedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class NotifyBookingCancelled
{

    /**
     * The name of the queue the job should be sent to.
     *
     * @var string|null
     */
    public $queue = 'listeners';

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(BookingCancelled $event): void
    {
        if(!is_null($event->ondemand_email)) {
            $name = $event->booking->first_name . ' ' . $event->booking->last_name;
            Notification::route('mail', [$event->ondemand_email => $name,])
                ->notify(new BookingCancelledNotification($event->booking));
        }
        
        if ($event->booking->user->usertype == 'customer') {
            $user = User::find($event->booking->user->id);
            $user->notify(new BookingCancelledNotification($event->booking));
        }

        $managers = User::where('usertype', 'manager')->get();
        Notification::send($managers, new BookingCancelledNotification($event->booking));
    }
}