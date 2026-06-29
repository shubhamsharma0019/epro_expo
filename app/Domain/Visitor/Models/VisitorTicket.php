<?php

namespace App\Domain\Visitor\Models;

use App\Domain\Shared\Models\User;
use Illuminate\Database\Eloquent\Model;
use App\Domain\Event\Models\CompanyEvent\CompanyEvent;
use App\Domain\Event\Models\CompanyEvent\CompanyEventTicketType;
use App\Domain\Visitor\Models\Booking;
use App\Domain\Visitor\Models\Ticket;

class VisitorTicket extends Model
{
    protected $fillable = [
        'user_id',
        'company_event_id',
        'ticket_type_id',
        'ticket_name',
        'order_number',
        'quantity',
        'total_amount',
        'status',
        'payment_status',
        'razorpay_order_id',
        'razorpay_payment_id',
        'qr_code_path',
        'attendee_name',
        'attendee_email',
        'attendee_phone',
        'attendee_gender',
        'attendee_city',
        'event_slug',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function companyEvent()
    {
        return $this->belongsTo(CompanyEvent::class);
    }

    public function ticketType()
    {
        return $this->belongsTo(CompanyEventTicketType::class);
    }

    public function booking()
    {
        return $this->hasOne(Booking::class, 'visitor_ticket_id');
    }

    public function issuedTicket()
    {
        return $this->hasOneThrough(
            Ticket::class,
            Booking::class,
            'visitor_ticket_id',
            'booking_id',
            'id',
            'id'
        );
    }
}
