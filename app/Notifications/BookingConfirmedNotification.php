<?php

namespace App\Notifications;

use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingConfirmedNotification extends Notification
{
    use Queueable;

    protected Booking $booking;

    /**
     * Create a new notification instance.
     */
    public function __construct(Booking $booking)
    {
        $booking->load('unit');
        $this->booking = $booking;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        if ($notifiable instanceof AnonymousNotifiable) {
            // Only send the notification via mail for anonymous notifiables
            return ['mail'];
        }

        if ($notifiable->usertype == 'manager') {
            return ['database', 'broadcast'];
        }
        
        return [
            'mail', 
            'database', 
            'broadcast'
        ];
    }

    /**
     * Determine which queues should be used for each notification channel.
     *
     * @return array<string, string>
     */
    public function viaQueues(): array
    {
        return [
            'mail' => 'mail-queue',
            'database' => 'db-queue',
            'broadcast' => 'broadcast-queue'
        ];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Booking Confirmation - ' . $this->booking->unit->name)
            ->markdown('mail.booking.confirmed');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'booking_id' => $this->booking->id,
            'reference_no' => $this->booking->reference_no,
            'unit_name' => $this->booking->unit->name,
            'first_name' => $this->booking->user->first_name,
            'last_name' => $this->booking->user->last_name,
            'checkin_date' => $this->booking->checkin_date,
            'checkout_date' => $this->booking->checkout_date,
            'no_of_guests' => $this->booking->no_of_guests,
            'no_of_nights' => Carbon::parse($this->booking->checkin_date)->diffInDays(Carbon::parse($this->booking->checkout_date))
        ];
    }

    /**
     * Get the notification's database type.
     *
     * @return string
     */
    public function databaseType(object $notifiable): string
    {
        return 'booking-confirmed';
    }

    /**
     * Get the broadcastable representation of the notification.
     */
    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'reference_no' => $this->booking->reference_no,
            'first_name' => $this->booking->user->first_name,
            'last_name' => $this->booking->user->last_name,
            'unit_name' => $this->booking->unit->name,
            'checkin_date' => $this->booking->checkin_date,
            'checkout_date' => $this->booking->checkout_date,
        ]);
    }

    /**
     * Get the type of the notification being broadcast.
     */
    public function broadcastType(): string
    {
        return 'booking-confirmed';
    }
}
