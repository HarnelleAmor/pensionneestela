<?php

namespace App\Listeners;

use App\Events\BookingCreated;
use App\Models\User;
use App\Notifications\BookingCreatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class NotifyBookingCreated implements ShouldQueue
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
    public function handle(BookingCreated $event): void
    {
        // Notification::route('mail', ['harnelleamor@gmail.com' => 'Harnelle Amor'])
        //     ->notify(new BookingCreatedNotification($event->booking));
        if(!is_null($event->ondemand_email)) {
            $name = $event->booking->first_name . ' ' . $event->booking->last_name;
            Notification::route('mail', [$event->ondemand_email => $name,])
                ->notify(new BookingCreatedNotification($event->booking));
        }
        
        if ($event->booking->user->usertype == 'customer') {
            $user = User::find($event->booking->user->id);
            $user->notify(new BookingCreatedNotification($event->booking));
        }

        $managers = User::where('usertype', 'manager')->get();
        Notification::send($managers, new BookingCreatedNotification($event->booking));
    }
}
