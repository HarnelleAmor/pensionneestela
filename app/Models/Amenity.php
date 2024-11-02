<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Amenity extends Model
{
    use HasFactory;

    // public function units(): BelongsToMany
    // {
    //     return $this->belongsToMany(Unit::class)
    //         ->as('amenity')
    //         ->withPivot('quantity', 'highlight')
    //         ->withTimestamps();
    // }
}
