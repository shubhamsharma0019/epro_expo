<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class BoothProfile extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'booth_booking_id',
        'company_logo',
        'company_name',
        'contact_person',
        'industry',
        'email',
        'phone',
        'tagline',
        'website',
        'about_company',
        'address',
        'city',
        'state',
        'zip_code',
        'country',
        'linkedin_url',
        'twitter_url',
        'facebook_url',
        'youtube_url',
        'created_by',
        'booth_title',
        'booth_banner',
        'welcome_text',
        'brand_color',
        'video_url',
        'cta_text',
        'cta_link',
        'status',
        'submitted_at',
        'approved_by',
        'approved_at',
        'rejection_reason',
    ];

    protected function casts(): array
    {
        return [
            'submitted_at' => 'datetime',
            'approved_at' => 'datetime',
        ];
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function boothBooking(): BelongsTo
    {
        return $this->belongsTo(BoothBooking::class);
    }

    public function boothViews(): HasMany
    {
        return $this->hasMany(BoothView::class);
    }
}
