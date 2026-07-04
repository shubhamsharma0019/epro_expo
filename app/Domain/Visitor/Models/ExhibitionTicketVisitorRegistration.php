<?php

namespace App\Domain\Visitor\Models;

use App\Domain\Event\Models\Exhibition;
use App\Domain\Shared\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExhibitionTicketVisitorRegistration extends Model
{
    protected $fillable = [
        'user_id',
        'exhibition_id',
        'exhibition_slug',
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

    public function exhibition(): BelongsTo
    {
        return $this->belongsTo(Exhibition::class);
    }

    /** @return array{name: string, email: string, phone: string, gender: string, city: string}> */
    public function toVisitorPrefill(): array
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
