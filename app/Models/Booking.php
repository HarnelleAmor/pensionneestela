<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class Booking extends Model implements Auditable
{
    use HasFactory, Notifiable, AuditingAuditable;

    /**
     * The channels the user receives notification broadcasts on.
     */
    public function receivesBroadcastNotificationsOn(): string
    {
        return 'users.' . $this->user->id;
    }

    protected $fillable = [
        'user_id',
        'unit_id',
        'first_name',
        'last_name',
        'email',
        'phone_no',
        'status',
        'reason_of_cancel',
        'no_of_guests',
        'checkin_date',
        'checkout_date',
        'checkin_time',
        'checkout_time',
        'outstanding_payment',
        'total_payment',
        'gcash_ref_no',
        'is_archived'
    ];

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::creating(function (Booking $booking) {
            $booking->reference_no = self::generateReferenceNo();
        });
    }

    private static function generateReferenceNo()
    {
        do {
            $generated_no = Str::upper(Str::random(5));
        } while (self::where('reference_no', $generated_no)->exists());

        return $generated_no;
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'checkin_date' => 'date',
            'checkout_date' => 'date',
            'is_archived' => 'boolean'
        ];
    }
    
    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class)
            ->as('service')
            ->withPivot('quantity', 'details')
            ->withTimestamps();
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
