<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'event_id',
        'booking_id',
        'ticket_type',
        'amount',
        'booking_date',
        'attendee_name',
        'attendee_email',
        'checkin_status',
        'checkin_time'
    ];

    /**
     * Get the event associated with the booking.
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
