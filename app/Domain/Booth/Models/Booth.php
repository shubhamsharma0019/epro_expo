<?php

namespace App\Domain\Booth\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Domain\Event\Models\Hall;

class Booth extends Model
{
    use HasFactory;

    protected $fillable = [
        'hall_id',
        'booth_size_id',
        'booth_number',
        'position_x',
        'position_y',
        'price',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
        ];
    }

    public function hall(): BelongsTo
    {
        return $this->belongsTo(Hall::class);
    }

    public function boothSize(): BelongsTo
    {
        return $this->belongsTo(BoothSize::class);
    }

    public function boothBooking(): HasOne
    {
        return $this->hasOne(BoothBooking::class);
    }
}
