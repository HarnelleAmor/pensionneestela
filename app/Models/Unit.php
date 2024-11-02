<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'occupancy_limit',
        'bed_config',
        'view',
        'location',
        'price_per_night'
    ];

    public function photos(): HasMany
    {
        return $this->hasMany(Photo::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function reviews(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'reviews')
            ->as('reviews')
            ->withPivot('details', 'rating', 'is_archived')
            ->withTimestamps();
    }

    public function amenities(): BelongsToMany
    {
        return $this->belongsToMany(Amenity::class)
            ->as('amenity')
            ->withPivot('quantity', 'highlight')
            ->withTimestamps();
    }
}
