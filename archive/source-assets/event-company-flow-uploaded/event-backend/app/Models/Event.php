<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'sub_category',
        'start_date',
        'end_date',
        'timezone',
        'venue',
        'website',
        'description',
        'logo_path',
        'banner_path',
        'primary_color',
        'secondary_color',
        'accent_color',
        'text_color',
        'organizer_name',
        'organizer_email',
        'organizer_phone',
        'status',
        'brochure_path',
        'sponsorship_guide_path',
        'review_notes',
        'allow_group_registrations',
        'show_remaining_tickets',
        'waiting_list',
    ];

    protected $casts = [
        'allow_group_registrations' => 'boolean',
        'show_remaining_tickets' => 'boolean',
        'waiting_list' => 'boolean',
    ];

    /**
     * Get the tickets for the event.
     */
    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }
}
