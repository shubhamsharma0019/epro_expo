<?php

namespace App\Domain\Event\Models;

use Illuminate\Database\Eloquent\Model;

class AgendaSession extends Model
{
    protected $guarded = [];

    public function exhibition()
    {
        return $this->belongsTo(Exhibition::class);
    }
}
