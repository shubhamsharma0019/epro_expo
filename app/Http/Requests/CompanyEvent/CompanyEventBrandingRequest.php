<?php

namespace App\Http\Requests\CompanyEvent;

use Illuminate\Foundation\Http\FormRequest;

class CompanyEventBrandingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return session()->has('company_id');
    }

    public function rules(): array
    {
        return [
            'logo' => ['nullable', 'image', 'max:8192'],
            'banner' => ['nullable', 'image', 'max:8192'],
            'brochure' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:12288'],
            'primary_color' => ['nullable', 'string', 'max:20'],
            'secondary_color' => ['nullable', 'string', 'max:20'],
            'accent_color' => ['nullable', 'string', 'max:20'],
            'theme_template' => ['nullable', 'string', 'max:100'],
            'headline' => ['nullable', 'string', 'max:255'],
            'tagline' => ['nullable', 'string', 'max:500'],
            'cta_label' => ['nullable', 'string', 'max:100'],
            'cta_url' => ['nullable', 'url', 'max:255'],
            'social_links' => ['nullable', 'array'],
            'social_links.*' => ['nullable', 'url', 'max:255'],
            'action' => ['nullable', 'in:save,continue,reset'],
        ];
    }
}
