<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $guarded = [];

    public function exhibition()
    {
        return $this->belongsTo(Exhibition::class);
    }

    public function meetings()
    {
        return $this->hasMany(Meeting::class, 'booking_id', 'booking_id');
    }
}
