<?php

namespace App\Domain\Booth\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class BoothSession extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'session_date' => 'date',
            'attendee_limit' => 'integer',
            'team_member_id' => 'integer',
        ];
    }

    public function boothBooking(): BelongsTo
    {
        return $this->belongsTo(BoothBooking::class);
    }

    public function teamMember(): BelongsTo
    {
        return $this->belongsTo(BoothTeamMember::class, 'team_member_id');
    }
}
