<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exhibitor extends Model
{
    protected $guarded = [];

    public function exhibition()
    {
        return $this->belongsTo(Exhibition::class);
    }

    public function meetings()
    {
        return $this->hasMany(Meeting::class);
    }

    public function demoVideos()
    {
        return $this->hasMany(DemoVideo::class);
    }

    public function products()
    {
        return $this->hasMany(VisitorProduct::class);
    }
}
