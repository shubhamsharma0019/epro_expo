<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    protected $guarded = [];

    public function exhibitor()
    {
        return $this->belongsTo(Exhibitor::class);
    }

    public function visitor()
    {
        return $this->belongsTo(Visitor::class, 'booking_id', 'booking_id');
    }
}
