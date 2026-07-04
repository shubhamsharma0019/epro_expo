<?php

namespace App\Domain\Booth\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Domain\Company\Models\Company;
use App\Domain\Company\Models\Service;
use App\Domain\Event\Models\Exhibition;
use App\Domain\Event\Models\Pavilion;
use App\Domain\Event\Models\Hall;

class BoothBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'exhibition_id',
        'pavilion_id',
        'hall_id',
        'booth_size_id',
        'booth_id',
        'selected_booth_ids',
        'amount',
        'services_amount',
        'total_amount',
        'payment_status',
        'booth_setup_status',
        'is_home_featured',
        'razorpay_order_id',
        'razorpay_payment_id',
        'razorpay_signature',
        'paid_at',
        'booking_status',
        'admin_status',
        'notes',
        'submitted_at',
        'approved_by',
        'approved_at',
        'rejection_reason',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'services_amount' => 'decimal:2',
            'total_amount' => 'decimal:2',
            'selected_booth_ids' => 'array',
            'is_home_featured' => 'boolean',
            'paid_at' => 'datetime',
            'submitted_at' => 'datetime',
            'approved_at' => 'datetime',
        ];
    }

    public function scopePubliclyVisible(Builder $query): Builder
    {
        return $query
            ->where('payment_status', 'paid')
            ->whereIn('booking_status', ['confirmed', 'active'])
            ->where('admin_status', 'approved')
            ->whereIn('booth_setup_status', ['published', 'approved', 'live']);
    }

    public function scopeRegisteredExhibitor(Builder $query): Builder
    {
        return $query
            ->where('payment_status', 'paid')
            ->whereIn('booking_status', ['confirmed', 'active'])
            ->where('admin_status', 'approved');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function exhibition(): BelongsTo
    {
        return $this->belongsTo(Exhibition::class);
    }

    public function pavilion(): BelongsTo
    {
        return $this->belongsTo(Pavilion::class);
    }

    public function hall(): BelongsTo
    {
        return $this->belongsTo(Hall::class);
    }

    public function boothSize(): BelongsTo
    {
        return $this->belongsTo(BoothSize::class);
    }

    public function booth(): BelongsTo
    {
        return $this->belongsTo(Booth::class);
    }

    public function boothProfile(): HasOne
    {
        return $this->hasOne(BoothProfile::class);
    }

    public function boothBranding(): HasOne
    {
        return $this->hasOne(BoothBranding::class);
    }

    public function boothProducts(): HasMany
    {
        return $this->hasMany(BoothProduct::class);
    }

    public function boothDocuments(): HasMany
    {
        return $this->hasMany(BoothDocument::class);
    }

    public function boothCatalogues(): HasMany
    {
        return $this->hasMany(BoothCatalogue::class);
    }

    public function boothMedia(): HasMany
    {
        return $this->hasMany(BoothMedia::class);
    }

    public function boothTeamMembers(): HasMany
    {
        return $this->hasMany(BoothTeamMember::class);
    }

    public function boothMeetingAvailability(): HasOne
    {
        return $this->hasOne(BoothMeetingAvailability::class);
    }

    public function boothMeetingSlots(): HasMany
    {
        return $this->hasMany(BoothMeetingSlot::class);
    }

    public function boothSessions(): HasMany
    {
        return $this->hasMany(BoothSession::class);
    }

    public function boothSetupSteps(): HasMany
    {
        return $this->hasMany(BoothSetupStep::class);
    }

    public function boothPublishRequest(): HasOne
    {
        return $this->hasOne(BoothPublishRequest::class);
    }

    public function boothAnalytics(): HasOne
    {
        return $this->hasOne(BoothAnalytics::class);
    }

    public function summary(): HasOne
    {
        return $this->hasOne(BoothBookingSummary::class);
    }

    public function days(): HasMany
    {
        return $this->hasMany(BoothBookingDay::class);
    }

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'booking_services')
            ->withPivot(['price', 'quantity', 'total'])
            ->withTimestamps();
    }
}
