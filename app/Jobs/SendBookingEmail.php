<?php

namespace App\Jobs;

use App\Mail\SampleMail;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Throwable;

class SendBookingEmail implements ShouldQueue
{
    use Queueable;

    /**
     * Delete the job if its models no longer exist.
     *
     * @var bool
     */
    public $deleteWhenMissingModels = true;

    protected $same_email = false;
    /**
     * Create a new job instance.
     */
    public function __construct(protected Booking $booking, protected User $user)
    {
        $this->same_email = $booking->email == $user->email;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->booking->email)->send(new SampleMail($this->booking));

        // if ($this->same_email) {
        //     Mail::to($this->user->email)->send(new SampleMail($this->booking));
        // }
    }

    /**
     * Handle a job failure.
     */
    public function failed(?Throwable $exception): void
    {
        
    }
}
