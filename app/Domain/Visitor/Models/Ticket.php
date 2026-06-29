<?php

namespace App\Domain\Visitor\Models;

use App\Domain\Event\Models\CompanyEvent\CompanyEvent;
use App\Domain\Shared\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'ticket_no',
        'booking_id',
        'visitor_id',
        'event_id',
        'ticket_type',
        'quantity',
        'qr_token',
        'qr_url',
        'status',
        'checked_in',
        'checked_in_at',
        'payment_status',
        'amount',
        'meta',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
            'checked_in' => 'boolean',
            'checked_in_at' => 'datetime',
            'amount' => 'decimal:2',
            'meta' => 'array',
        ];
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function visitor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'visitor_id');
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(CompanyEvent::class, 'event_id');
    }

    public function checkins(): HasMany
    {
        return $this->hasMany(VisitorCheckin::class);
    }

    public function scanLogs(): HasMany
    {
        return $this->hasMany(TicketScanLog::class);
    }
}
