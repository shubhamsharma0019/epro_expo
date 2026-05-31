<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Exhibition extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'location',
        'start_date',
        'end_date',
        'banner_image',
        'status',
        'name',
        'venue',
        'banner_url',
        'companies_count',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }

    public function pavilions(): HasMany
    {
        return $this->hasMany(Pavilion::class);
    }

    public function boothBookings(): HasMany
    {
        return $this->hasMany(BoothBooking::class);
    }

    public function exhibitors(): HasMany
    {
        return $this->hasMany(Exhibitor::class);
    }

    public function visitors(): HasMany
    {
        return $this->hasMany(Visitor::class);
    }
}
