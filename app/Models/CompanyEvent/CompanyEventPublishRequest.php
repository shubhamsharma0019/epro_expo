<?php

namespace App\Models\CompanyEvent;

use App\Models\Admin;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompanyEventPublishRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_event_id',
        'company_id',
        'status',
        'company_notes',
        'review_notes',
        'reviewed_by',
        'submitted_at',
        'reviewed_at',
    ];

    protected function casts(): array
    {
        return [
            'submitted_at' => 'datetime',
            'reviewed_at' => 'datetime',
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

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'reviewed_by');
    }
}
