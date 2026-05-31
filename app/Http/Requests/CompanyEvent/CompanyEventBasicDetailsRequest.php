<?php

namespace App\Http\Requests\CompanyEvent;

use Illuminate\Foundation\Http\FormRequest;

class CompanyEventBasicDetailsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return session()->has('company_id');
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'event_type' => ['nullable', 'in:in_person,virtual,hybrid,webinar'],
            'category' => ['nullable', 'string', 'max:120'],
            'sub_category' => ['nullable', 'string', 'max:120'],
            'event_mode' => ['nullable', 'in:in_person,virtual,hybrid'],
            'starts_at' => ['nullable', 'date'],
            'ends_at' => ['nullable', 'date', 'after_or_equal:starts_at'],
            'timezone' => ['nullable', 'string', 'max:80'],
            'venue_name' => ['nullable', 'string', 'max:255'],
            'venue_address' => ['nullable', 'string', 'max:2000'],
            'city' => ['nullable', 'string', 'max:120'],
            'country' => ['nullable', 'string', 'max:120'],
            'website' => ['nullable', 'url', 'max:255'],
            'summary' => ['nullable', 'string', 'max:500'],
            'description' => ['nullable', 'string'],
            'highlights' => ['nullable', 'array'],
            'highlights.*' => ['nullable', 'string', 'max:180'],
            'capacity' => ['nullable', 'integer', 'min:1'],
            'visibility' => ['nullable', 'in:private,public,unlisted'],
            'next' => ['nullable', 'in:stay,branding'],
        ];
    }
}
