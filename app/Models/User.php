<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class User extends Authenticatable implements Auditable // implements MustVerifyEmail
{
    use HasFactory, Notifiable, AuditingAuditable;

    /**
     * Attributes to exclude from the Audit.
     *
     * @var array
     */
    protected $auditExclude = [
        'password',
    ];

    /**
     * The channels the user receives notification broadcasts on.
     */
    public function receivesBroadcastNotificationsOn(): string
    {
        return 'users.' . $this->id;
    }

    /**
     * Route notifications for the mail channel.
     *
     * @return  array<string, string>|string
     */
    public function routeNotificationForMail(Notification $notification): array|string
    {

        return 'harnelleamor@gmail.com';
        // Return email address only...
        // return $this->email_address;
 
        // Return email address and name...
        // return [$this->email_address => $this->first_name];
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'usertype',
        'email',
        'phone_no',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * A User can write many reviews on a unit, and a unit can have many reviews
     */
    public function reviews(): BelongsToMany
    {
        return $this->belongsToMany(Unit::class, 'reviews')
            ->as('review')
            ->withPivot('details', 'rating', 'is_archived')
            ->withTimestamps();
    }

    /**
     * A User can book many units, and a unit can be booked by many users
     */
    // public function bookings(): BelongsToMany
    // {
    //     return $this->belongsToMany(Unit::class, 'bookings', 'user_id', 'unit_id')
    //         ->as('booking')
    //         ->withPivot('no_of_guests', 'checkin_date', 'checkout_date', 'outstanding_payment', 'total_payment', 'is_archived')
    //         ->withTimestamps();
    // }

    /**
     * A User can have many bookings, and a booking belongs to a user
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}
