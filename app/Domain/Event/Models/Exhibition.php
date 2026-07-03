<?php

namespace App\Domain\Event\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Domain\Booth\Models\BoothBooking;

class Exhibition extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'title',
        'slug',
        'description',
        'location',
        'venue',
        'start_date',
        'end_date',
        'duration_days',
        'booth_booking_days',
        'banner_image',
        'banner_url',
        'companies_count',
        'status',
        'approval_status',
        'publish_status',
        'approved_at',
        'published_at',
        'is_home_featured',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'approved_at' => 'datetime',
            'published_at' => 'datetime',
            'is_home_featured' => 'boolean',
            'booth_booking_days' => 'integer',
            'duration_days' => 'integer',
        ];
    }

    public function durationDays(): int
    {
        if ((int) ($this->duration_days ?? 0) > 0) {
            return min((int) $this->duration_days, 60);
        }

        return $this->boothBookingDays();
    }

    public function boothBookingDays(): int
    {
        if ((int) ($this->duration_days ?? 0) > 0) {
            return min((int) $this->duration_days, 60);
        }

        if ((int) ($this->booth_booking_days ?? 0) > 0) {
            return min((int) $this->booth_booking_days, 60);
        }

        if ($this->start_date && $this->end_date) {
            return min(max($this->start_date->diffInDays($this->end_date) + 1, 1), 60);
        }

        return 1;
    }

    public function scopeLiveForVisitors(Builder $query): Builder
    {
        return $query
            ->where('approval_status', 'approved')
            ->where('publish_status', 'published')
            ->whereIn('status', ['active', 'published', 'live']);
    }

    public function isLiveForVisitors(): bool
    {
        return $this->approval_status === 'approved'
            && $this->publish_status === 'published'
            && in_array($this->status, ['active', 'published', 'live'], true);
    }

    public function pavilions(): HasMany
    {
        return $this->hasMany(Pavilion::class);
    }

    public function boothBookings(): HasMany
    {
        return $this->hasMany(BoothBooking::class);
    }
}
