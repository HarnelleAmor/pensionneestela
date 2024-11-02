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

class BookingCreatedNotification extends Notification
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
        // return ['mail'];
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
            // ->greeting('Hello ' . $this->booking->first_name . ',')
            // ->line('We are pleased to inform you that your booking has been successfully created!')
            // ->line('**Booking Details:**')
            // ->line('**Booking ID:** #' . $this->booking->reference_no)
            // ->line('**Check-in Date:** ' . Carbon::parse($this->booking->checkin_date)->format('M j, Y'))
            // ->line('**Check-out Date:** ' . Carbon::parse($this->booking->checkout_date)->format('M j, Y'))
            // ->line('**Number of Guests:** ' . $this->booking->no_of_guests)
            // ->line('**Total Payment:** PHP' . number_format($this->booking->total_payment, 2))
            // ->line('Thank you for choosing Pensionne Estela! We look forward to hosting you.')
            // ->action('View Your Booking', url('/bookings/' . $this->booking->id))
            // ->salutation('Warm regards,')
            // ->line(config('app.name'))
            ->markdown('emails.booking_confirmation', ['booking' => $this->booking]); // Pass booking data;
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
        return 'booking-created';
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
        return 'booking-created';
    }
}
