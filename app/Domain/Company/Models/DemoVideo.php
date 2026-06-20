<?php

namespace App\Domain\Company\Models;

use Illuminate\Database\Eloquent\Model;

class DemoVideo extends Model
{
    protected $guarded = [];

    public function exhibitor()
    {
        return $this->belongsTo(Exhibitor::class);
    }
}
