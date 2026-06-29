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
        'exhibition_id',
        'entry_gate',
        'checkin_type',
        'device_type',
        'device_name',
        'user_agent',
        'ip_address',
        'status',
        'verified_by',
        'checked_in_at',
    ];

    protected function casts(): array
    {
        return [
            'checked_in_at' => 'datetime',
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
