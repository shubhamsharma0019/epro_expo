<?php

namespace App\Domain\Visitor\Models;

use App\Domain\Event\Models\CompanyEvent\CompanyEvent;
use App\Domain\Event\Models\Exhibition;
use App\Domain\Shared\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VisitorCheckin extends Model
{
    protected $table = 'visitor_checkins';

    protected $fillable = [
        'user_id',
        'visitor_ticket_id',
        'ticket_id',
        'company_event_id',
        'visitor_name',
        'visitor_email',
        'visitor_phone',
        'exhibition_id',
        'entry_gate',
        'checkin_type',
        'device_type',
        'device_name',
        'user_agent',
        'ip_address',
        'status',
        'verified_by',
        'scanner_username',
        'scan_location',
        'checked_in_at',
        'checkin_date',
    ];

    protected function casts(): array
    {
        return [
            'checked_in_at' => 'datetime',
            'checkin_date' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function visitorTicket(): BelongsTo
    {
        return $this->belongsTo(VisitorTicket::class);
    }

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function companyEvent(): BelongsTo
    {
        return $this->belongsTo(CompanyEvent::class);
    }

    public function exhibition(): BelongsTo
    {
        return $this->belongsTo(Exhibition::class);
    }
}
