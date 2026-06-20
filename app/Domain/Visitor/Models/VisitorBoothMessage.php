<?php

namespace App\Domain\Visitor\Models;

use App\Domain\Company\Models\Company;
use App\Domain\Event\Models\Exhibition;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VisitorBoothMessage extends Model
{
    protected $fillable = [
        'exhibition_id',
        'company_id',
        'visitor_booking_id',
        'user_id',
        'sender_type',
        'sender_name',
        'message',
    ];

    public function exhibition(): BelongsTo
    {
        return $this->belongsTo(Exhibition::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
