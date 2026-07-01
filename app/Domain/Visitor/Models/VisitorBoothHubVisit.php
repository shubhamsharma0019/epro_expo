<?php

namespace App\Domain\Visitor\Models;

use App\Domain\Booth\Models\Booth;
use App\Domain\Booth\Models\BoothBooking;
use App\Domain\Company\Models\Company;
use App\Domain\Event\Models\Exhibition;
use App\Domain\Event\Models\Hall;
use App\Domain\Shared\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VisitorBoothHubVisit extends Model
{
    protected $fillable = [
        'user_id',
        'visitor_pass_id',
        'exhibition_id',
        'hall_id',
        'booth_id',
        'booth_booking_id',
        'company_id',
        'source',
        'visited_at',
    ];

    protected function casts(): array
    {
        return [
            'visited_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function visitorPass(): BelongsTo
    {
        return $this->belongsTo(Visitor::class, 'visitor_pass_id');
    }

    public function exhibition(): BelongsTo
    {
        return $this->belongsTo(Exhibition::class);
    }

    public function hall(): BelongsTo
    {
        return $this->belongsTo(Hall::class);
    }

    public function booth(): BelongsTo
    {
        return $this->belongsTo(Booth::class);
    }

    public function boothBooking(): BelongsTo
    {
        return $this->belongsTo(BoothBooking::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
