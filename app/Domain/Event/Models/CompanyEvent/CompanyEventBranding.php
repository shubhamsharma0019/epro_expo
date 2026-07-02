<?php

namespace App\Domain\Event\Models\CompanyEvent;

use App\Domain\Company\Models\Company;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompanyEventBranding extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_event_id',
        'company_id',
        'logo_path',
        'banner_path',
        'brochure_path',
        'primary_color',
        'secondary_color',
        'accent_color',
        'theme_template',
        'headline',
        'tagline',
        'cta_label',
        'cta_url',
        'social_links',
        'theme_sections',
    ];

    protected function casts(): array
    {
        return [
            'social_links' => 'array',
            'theme_sections' => 'array',
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
