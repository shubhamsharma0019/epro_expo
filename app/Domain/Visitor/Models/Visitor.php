<?php

namespace App\Domain\Visitor\Models;

use Illuminate\Database\Eloquent\Model;
use App\Domain\Event\Models\Exhibition;

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
