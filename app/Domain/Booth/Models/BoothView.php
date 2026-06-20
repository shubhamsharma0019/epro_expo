<?php

namespace App\Domain\Booth\Models;

use App\Domain\Company\Models\Company;
use App\Domain\Shared\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BoothView extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'booth_profile_id',
        'visitor_id',
        'ip_address',
        'user_agent',
        'viewed_at',
    ];

    protected function casts(): array
    {
        return [
            'viewed_at' => 'datetime',
        ];
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function boothProfile(): BelongsTo
    {
        return $this->belongsTo(BoothProfile::class);
    }

    public function visitor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'visitor_id');
    }
}
