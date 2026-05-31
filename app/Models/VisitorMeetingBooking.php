<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VisitorMeetingBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_meeting_id',
        'company_id',
        'visitor_id',
        'visitor_name',
        'visitor_email',
        'visitor_phone',
        'message',
        'status',
    ];

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
