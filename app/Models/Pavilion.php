<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pavilion extends Model
{
    use HasFactory;

    protected $fillable = [
        'exhibition_id',
        'title',
        'slug',
        'description',
        'image',
        'total_halls',
        'total_booths',
        'status',
    ];

    public function exhibition(): BelongsTo
    {
        return $this->belongsTo(Exhibition::class);
    }

    public function halls(): HasMany
    {
        return $this->hasMany(Hall::class);
    }

    public function boothBookings(): HasMany
    {
        return $this->hasMany(BoothBooking::class);
    }
}
