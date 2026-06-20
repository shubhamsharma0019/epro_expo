<?php

namespace App\Domain\Visitor\Models;

use App\Domain\Shared\Models\User;
use App\Domain\Event\Models\Exhibition;
use App\Domain\Booth\Models\BoothSession;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VisitorSessionRegistration extends Model
{
    protected $fillable = [
        'booth_session_id',
        'exhibition_id',
        'visitor_booking_id',
        'user_id',
        'visitor_email',
        'status',
    ];

    public function boothSession(): BelongsTo
    {
        return $this->belongsTo(BoothSession::class);
    }

    public function exhibition(): BelongsTo
    {
        return $this->belongsTo(Exhibition::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
