<?php

namespace App\Http\Requests\CompanyEvent;

use Illuminate\Foundation\Http\FormRequest;

class CompanyEventTicketTypeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return session()->has('company_id');
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'description' => ['nullable', 'string', 'max:1000'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'currency' => ['nullable', 'string', 'size:3'],
            'quantity_total' => ['nullable', 'integer', 'min:1'],
            'sales_start_at' => ['nullable', 'date'],
            'sales_end_at' => ['nullable', 'date', 'after_or_equal:sales_start_at'],
            'status' => ['nullable', 'in:active,inactive,sold_out'],
            'benefits' => ['nullable', 'array'],
            'benefits.*' => ['nullable', 'string', 'max:180'],
            'next' => ['nullable', 'in:stay,preview'],
        ];
    }
}
