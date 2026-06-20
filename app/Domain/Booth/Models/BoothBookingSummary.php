<?php

namespace App\Domain\Booth\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BoothBookingSummary extends Model
{
    use HasFactory;

    protected $fillable = [
        'booth_booking_id',
        'company_id',
        'exhibition_id',
        'pavilion_id',
        'hall_id',
        'booth_id',
        'booth_size_id',
        'pavilion_title',
        'hall_title',
        'booth_number',
        'booth_size_title',
        'selected_days_count',
        'selected_days',
        'booth_price',
        'days_amount',
        'services_amount',
        'total_amount',
        'booking_status',
        'payment_status',
    ];

    protected function casts(): array
    {
        return [
            'selected_days' => 'array',
            'booth_price' => 'decimal:2',
            'days_amount' => 'decimal:2',
            'services_amount' => 'decimal:2',
            'total_amount' => 'decimal:2',
        ];
    }

    public function boothBooking(): BelongsTo
    {
        return $this->belongsTo(BoothBooking::class);
    }
}
