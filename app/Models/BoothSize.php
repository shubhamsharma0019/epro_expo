<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BoothSize extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'width',
        'height',
        'area',
        'price',
        'description',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'width' => 'decimal:2',
            'height' => 'decimal:2',
            'area' => 'decimal:2',
            'price' => 'decimal:2',
        ];
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
