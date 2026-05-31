<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExhibitionMeeting extends Model
{
    protected $fillable = [
        'visitor_id',
        'exhibitor_id',
        'meeting_date',
        'meeting_time',
        'notes',
        'status'
    ];

    public function visitor()
    {
        return $this->belongsTo(ExhibitionVisitor::class, 'visitor_id');
    }

    public function exhibitor()
    {
        return $this->belongsTo(Exhibitor::class);
    }
}
