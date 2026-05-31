<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class BoothTeamMemberRequest extends FormRequest
{
    public function authorize(): bool { return session()->has('company_id'); }

    public function rules(): array
    {
        return [
            'photo' => ['nullable', 'image', 'max:4096'],
            'name' => ['required', 'string', 'max:255'],
            'designation' => ['required', 'string', 'max:255'],
            'expertise_tags' => ['nullable', 'string', 'max:1000'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'availability_start_date' => ['nullable', 'date'],
            'availability_end_date' => ['nullable', 'date', 'after_or_equal:availability_start_date'],
            'availability_start_time' => ['nullable', 'date_format:H:i'],
            'availability_end_time' => ['nullable', 'date_format:H:i'],
            'status' => ['required', 'in:active,inactive'],
        ];
    }
}
