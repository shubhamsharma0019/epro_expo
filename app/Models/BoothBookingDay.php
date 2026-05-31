<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BoothBookingDay extends Model
{
    use HasFactory;

    protected $fillable = [
        'booth_booking_id',
        'booth_id',
        'booking_date',
        'label',
        'price',
    ];

    protected function casts(): array
    {
        return [
            'booking_date' => 'date',
            'price' => 'decimal:2',
        ];
    }

    public function boothBooking(): BelongsTo
    {
        return $this->belongsTo(BoothBooking::class);
    }

    public function booth(): BelongsTo
    {
        return $this->belongsTo(Booth::class);
    }
}
