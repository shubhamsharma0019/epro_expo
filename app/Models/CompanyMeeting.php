<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CompanyMeeting extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'title',
        'meeting_type',
        'start_time',
        'end_time',
        'meeting_link',
        'max_attendees',
        'description',
        'status',
        'submitted_at',
        'approved_by',
        'approved_at',
        'rejection_reason',
    ];

    protected function casts(): array
    {
        return [
            'start_time' => 'datetime',
            'end_time' => 'datetime',
            'submitted_at' => 'datetime',
            'approved_at' => 'datetime',
        ];
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function visitorMeetingBookings(): HasMany
    {
        return $this->hasMany(VisitorMeetingBooking::class);
    }
}
