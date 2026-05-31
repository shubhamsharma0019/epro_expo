<?php

namespace App\Models\CompanyEvent;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompanyEventTicketType extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_event_id',
        'company_id',
        'name',
        'description',
        'price',
        'currency',
        'quantity_total',
        'quantity_sold',
        'sales_start_at',
        'sales_end_at',
        'status',
        'benefits',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'quantity_total' => 'integer',
            'quantity_sold' => 'integer',
            'sales_start_at' => 'datetime',
            'sales_end_at' => 'datetime',
            'benefits' => 'array',
        ];
    }

    public function companyEvent(): BelongsTo
    {
        return $this->belongsTo(CompanyEvent::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
