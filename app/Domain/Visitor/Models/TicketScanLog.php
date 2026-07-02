<?php

namespace App\Domain\Visitor\Models;

use App\Domain\Event\Models\CompanyEvent\CompanyEvent;
use App\Domain\Shared\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TicketScanLog extends Model
{
    protected $fillable = [
        'ticket_id',
        'visitor_id',
        'company_event_id',
        'visitor_name',
        'visitor_email',
        'visitor_phone',
        'qr_token',
        'action',
        'scanner_username',
        'scan_location',
        'device_type',
        'device_name',
        'user_agent',
        'ip_address',
        'scanned_at',
    ];

    protected function casts(): array
    {
        return [
            'scanned_at' => 'datetime',
        ];
    }

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function visitor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'visitor_id');
    }

    public function companyEvent(): BelongsTo
    {
        return $this->belongsTo(CompanyEvent::class);
    }
}
