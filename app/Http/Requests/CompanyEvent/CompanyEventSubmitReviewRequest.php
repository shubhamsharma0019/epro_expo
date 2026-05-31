<?php

namespace App\Http\Requests\CompanyEvent;

use Illuminate\Foundation\Http\FormRequest;

class CompanyEventSubmitReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return session()->has('company_id');
    }

    public function rules(): array
    {
        return [
            'company_notes' => ['nullable', 'string', 'max:2000'],
        ];
    }
}
