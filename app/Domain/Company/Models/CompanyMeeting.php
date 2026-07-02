<?php

namespace App\Domain\Company\Models;

use App\Domain\Visitor\Models\VisitorMeetingBooking;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CompanyMeeting extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'booth_session_id',
        'title',
        'meeting_type',
        'start_time',
        'end_time',
        'meeting_link',
        'zoom_join_url',
        'zoom_start_url',
        'google_calendar_link',
        'host_email',
        'attendee_email',
        'zoom_duration',
        'zoom_meeting_status',
        'zoom_meeting_id',
        'zoom_passcode',
        'meeting_agenda',
        'meeting_date',
        'meeting_time',
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
            'meeting_date' => 'date',
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

    public function boothSession(): BelongsTo
    {
        return $this->belongsTo(\App\Domain\Booth\Models\BoothSession::class);
    }
}
