<?php

namespace App\Domain\Visitor\Models;

use App\Domain\Event\Models\CompanyEvent\CompanyEvent;
use App\Domain\Shared\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventTicketVisitorRegistration extends Model
{
    protected $fillable = [
        'user_id',
        'company_event_id',
        'event_slug',
        'name',
        'email',
        'phone',
        'gender',
        'city',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function companyEvent(): BelongsTo
    {
        return $this->belongsTo(CompanyEvent::class);
    }

    /** @return array{name: string, email: string, phone: string, gender: string, city: string}> */
    public function toAttendeePrefill(): array
    {
        return [
            'name' => (string) $this->name,
            'email' => (string) $this->email,
            'phone' => (string) ($this->phone ?? ''),
            'gender' => (string) ($this->gender ?? ''),
            'city' => (string) ($this->city ?? ''),
        ];
    }
}
