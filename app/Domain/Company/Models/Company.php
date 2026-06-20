<?php

namespace App\Domain\Company\Models;

use App\Domain\Event\Models\CompanyEvent\CompanyEvent;
use App\Domain\Event\Models\CompanyEvent\CompanyEventBranding;
use App\Domain\Event\Models\CompanyEvent\CompanyEventPublishRequest;
use App\Domain\Event\Models\CompanyEvent\CompanyEventSession;
use App\Domain\Event\Models\CompanyEvent\CompanyEventSpeaker;
use App\Domain\Event\Models\CompanyEvent\CompanyEventTicketType;
use App\Domain\Shared\Models\User;
use App\Domain\Booth\Models\BoothBooking;
use App\Domain\Booth\Models\BoothProfile;
use App\Domain\Booth\Models\BoothBranding;
use App\Domain\Booth\Models\BoothProduct;
use App\Domain\Booth\Models\BoothDocument;
use App\Domain\Booth\Models\BoothCatalogue;
use App\Domain\Booth\Models\BoothMedia;
use App\Domain\Booth\Models\BoothTeamMember;
use App\Domain\Booth\Models\BoothSession;
use App\Domain\Booth\Models\BoothView;
use App\Domain\Event\Models\MediaGallery;
use App\Domain\Visitor\Models\BusinessCard;
use App\Domain\Visitor\Models\VisitorMeetingBooking;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Company extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'user_id',
        'name',
        'owner_name',
        'company_name',
        'contact_person_name',
        'email',
        'phone',
        'password',
        'logo',
        'website',
        'industry',
        'about',
        'address',
        'social_links',
        'city',
        'country',
        'status',
        'account_type',
        'submitted_at',
        'approved_by',
        'approved_at',
        'rejection_reason',
        'is_home_featured',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'social_links' => 'array',
            'submitted_at' => 'datetime',
            'approved_at' => 'datetime',
            'is_home_featured' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function boothBookings(): HasMany
    {
        return $this->hasMany(BoothBooking::class);
    }

    public function boothProfiles(): HasMany
    {
        return $this->hasMany(BoothProfile::class);
    }

    public function boothBrandings(): HasMany
    {
        return $this->hasMany(BoothBranding::class);
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

    public function boothSessions(): HasMany
    {
        return $this->hasMany(BoothSession::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function companyDocuments(): HasMany
    {
        return $this->hasMany(CompanyDocument::class);
    }

    public function catalogues(): HasMany
    {
        return $this->hasMany(Catalogue::class);
    }

    public function mediaGalleries(): HasMany
    {
        return $this->hasMany(MediaGallery::class);
    }

    public function businessCards(): HasMany
    {
        return $this->hasMany(BusinessCard::class);
    }

    public function companyMeetings(): HasMany
    {
        return $this->hasMany(CompanyMeeting::class);
    }

    public function enquiries(): HasMany
    {
        return $this->hasMany(Enquiry::class);
    }

    public function visitorMeetingBookings(): HasMany
    {
        return $this->hasMany(VisitorMeetingBooking::class);
    }

    public function boothViews(): HasMany
    {
        return $this->hasMany(BoothView::class);
    }

    public function companyEvents(): HasMany
    {
        return $this->hasMany(CompanyEvent::class);
    }

    public function companyEventBrandings(): HasMany
    {
        return $this->hasMany(CompanyEventBranding::class);
    }

    public function companyEventTicketTypes(): HasMany
    {
        return $this->hasMany(CompanyEventTicketType::class);
    }

    public function companyEventSessions(): HasMany
    {
        return $this->hasMany(CompanyEventSession::class);
    }

    public function companyEventSpeakers(): HasMany
    {
        return $this->hasMany(CompanyEventSpeaker::class);
    }

    public function companyEventPublishRequests(): HasMany
    {
        return $this->hasMany(CompanyEventPublishRequest::class);
    }

    public function isProfileComplete(): bool
    {
        return filled($this->logo)
            && filled($this->industry)
            && filled($this->website)
            && filled($this->about)
            && filled($this->address);
    }
}

