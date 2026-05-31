<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExhibitionVisitor extends Model
{
    protected $fillable = [
        'exhibition_id',
        'booking_id',
        'first_name',
        'last_name',
        'email',
        'mobile',
        'job_title',
        'company',
        'country',
        'state',
        'city',
        'industry',
        'company_size',
        'business_address',
        'pass_type',
        'amount',
        'payment_status',
        'checkin_status',
        'checkin_time'
    ];

    public function exhibition()
    {
        return $this->belongsTo(Exhibition::class);
    }

    public function meetings()
    {
        return $this->hasMany(ExhibitionMeeting::class, 'visitor_id');
    }
}
