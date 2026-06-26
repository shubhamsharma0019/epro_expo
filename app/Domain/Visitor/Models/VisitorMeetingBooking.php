<?php

namespace App\Domain\Visitor\Models;

use App\Domain\Company\Models\Company;
use App\Domain\Shared\Models\User;
use App\Domain\Company\Models\CompanyMeeting;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VisitorMeetingBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_meeting_id',
        'booth_session_id',
        'company_id',
        'visitor_id',
        'visitor_name',
        'visitor_email',
        'visitor_phone',
        'meeting_topic',
        'preferred_date',
        'preferred_time',
        'message',
        'status',
        'created_by',
        'updated_by',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'preferred_date' => 'date',
            'completed_at' => 'datetime',
        ];
    }

    public static function displayStatus(string $status): string
    {
        return match ($status) {
            'confirmed', 'accepted' => 'Accepted',
            'rejected' => 'Rejected',
            'completed' => 'Completed',
            default => 'Pending',
        };
    }

    public function companyMeeting(): BelongsTo
    {
        return $this->belongsTo(CompanyMeeting::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function visitor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'visitor_id');
    }
}
