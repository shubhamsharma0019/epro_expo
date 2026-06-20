<?php

namespace App\Domain\Company\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReplyEnquiryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return session()->has('company_id');
    }

    public function rules(): array
    {
        return [
            'message' => ['required', 'string', 'min:5', 'max:5000'],
        ];
    }
}
