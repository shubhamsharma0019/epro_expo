<?php

namespace App\Domain\Event\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Domain\Booth\Models\BoothBooking;

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

    public function booths(): \Illuminate\Database\Eloquent\Relations\HasManyThrough
    {
        return $this->hasManyThrough(\App\Domain\Booth\Models\Booth::class, Hall::class);
    }

    public function boothBookings(): HasMany
    {
        return $this->hasMany(BoothBooking::class);
    }
}
