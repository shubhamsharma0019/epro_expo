<?php

namespace App\Domain\Booth\Models;

use App\Domain\Company\Models\Company;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class BoothMeetingAvailability extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'available_start_date' => 'date',
            'available_end_date' => 'date',
            'available_weekdays' => 'array',
            'meeting_types' => 'array',
            'slot_duration' => 'integer',
            'buffer_time' => 'integer',
            'assigned_team_member_id' => 'integer',
            'max_capacity' => 'integer',
            'allow_one_to_one' => 'boolean',
            'allow_one_to_many' => 'boolean',
            'allow_conference' => 'boolean',
        ];
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function boothBooking(): BelongsTo
    {
        return $this->belongsTo(BoothBooking::class);
    }
}
