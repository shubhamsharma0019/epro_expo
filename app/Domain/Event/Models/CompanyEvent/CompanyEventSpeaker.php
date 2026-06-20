<?php

namespace App\Domain\Event\Models\CompanyEvent;

use App\Domain\Company\Models\Company;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompanyEventSpeaker extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_event_id',
        'company_id',
        'name',
        'designation',
        'organization',
        'email',
        'photo_path',
        'bio',
        'social_links',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'social_links' => 'array',
        ];
    }

    public function companyEvent(): BelongsTo
    {
        return $this->belongsTo(CompanyEvent::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
