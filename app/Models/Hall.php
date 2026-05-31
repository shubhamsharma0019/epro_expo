<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Hall extends Model
{
    use HasFactory;

    protected $fillable = [
        'pavilion_id',
        'title',
        'slug',
        'description',
        'image',
        'floor_plan_image',
        'total_booths',
        'status',
    ];

    public function pavilion(): BelongsTo
    {
        return $this->belongsTo(Pavilion::class);
    }

    public function booths(): HasMany
    {
        return $this->hasMany(Booth::class);
    }

    public function boothBookings(): HasMany
    {
        return $this->hasMany(BoothBooking::class);
    }
}
