<?php

namespace App\Domain\Event\Models\CompanyEvent;

use App\Domain\Company\Models\Company;
use App\Domain\Visitor\Models\VisitorTicket;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CompanyEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'title',
        'slug',
        'event_type',
        'category',
        'sub_category',
        'event_mode',
        'status',
        'publish_status',
        'starts_at',
        'ends_at',
        'timezone',
        'venue_name',
        'venue_address',
        'city',
        'country',
        'website',
        'summary',
        'description',
        'highlights',
        'capacity',
        'ticket_attendee_fields',
        'allow_group_registrations',
        'show_remaining_ticket_count',
        'enable_waiting_list',
        'visibility',
        'submitted_at',
        'published_at',
        'is_home_featured',
    ];

    protected function casts(): array
    {
        return [
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
            'highlights' => 'array',
            'capacity' => 'integer',
            'ticket_attendee_fields' => 'array',
            'allow_group_registrations' => 'boolean',
            'show_remaining_ticket_count' => 'boolean',
            'enable_waiting_list' => 'boolean',
            'submitted_at' => 'datetime',
            'published_at' => 'datetime',
            'is_home_featured' => 'boolean',
        ];
    }

    public function scopeLiveForVisitors(Builder $query): Builder
    {
        return $query
            ->where('status', 'published')
            ->where('publish_status', 'published')
            ->where('visibility', 'public');
    }

    public function isLiveForVisitors(): bool
    {
        return $this->status === 'published'
            && $this->publish_status === 'published'
            && $this->visibility === 'public';
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function branding(): HasOne
    {
        return $this->hasOne(CompanyEventBranding::class);
    }

    public function ticketTypes(): HasMany
    {
        return $this->hasMany(CompanyEventTicketType::class);
    }

    public function sessions(): HasMany
    {
        return $this->hasMany(CompanyEventSession::class);
    }

    public function speakers(): HasMany
    {
        return $this->hasMany(CompanyEventSpeaker::class);
    }

    public function publishRequests(): HasMany
    {
        return $this->hasMany(CompanyEventPublishRequest::class);
    }

    public function visitorTickets(): HasMany
    {
        return $this->hasMany(VisitorTicket::class);
    }

    public function latestPublishRequest(): HasOne
    {
        return $this->hasOne(CompanyEventPublishRequest::class)->latestOfMany();
    }
}
