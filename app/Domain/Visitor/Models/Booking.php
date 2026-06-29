<?php

namespace App\Domain\Visitor\Models;

use App\Domain\Event\Models\CompanyEvent\CompanyEvent;
use App\Domain\Event\Models\CompanyEvent\CompanyEventTicketType;
use App\Domain\Shared\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'company_event_id',
        'ticket_type_id',
        'visitor_ticket_id',
        'booking_number',
        'ticket_type',
        'quantity',
        'amount',
        'payment_status',
        'razorpay_order_id',
        'razorpay_payment_id',
        'status',
        'meta',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
            'amount' => 'decimal:2',
            'meta' => 'array',
        ];
    }

    public function visitor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function companyEvent(): BelongsTo
    {
        return $this->belongsTo(CompanyEvent::class, 'company_event_id');
    }

    public function ticketType(): BelongsTo
    {
        return $this->belongsTo(CompanyEventTicketType::class, 'ticket_type_id');
    }

    public function visitorTicket(): BelongsTo
    {
        return $this->belongsTo(VisitorTicket::class);
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }
}
