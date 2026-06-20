<?php

namespace App\Domain\Visitor\Models;

use Illuminate\Database\Eloquent\Model;
use App\Domain\Company\Models\Exhibitor;
use App\Domain\Visitor\Models\Visitor;

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
