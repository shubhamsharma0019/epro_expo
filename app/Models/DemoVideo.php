<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DemoVideo extends Model
{
    protected $guarded = [];

    public function exhibitor()
    {
        return $this->belongsTo(Exhibitor::class);
    }
}
