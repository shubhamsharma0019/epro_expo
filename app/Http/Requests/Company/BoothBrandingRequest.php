<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class BoothBrandingRequest extends FormRequest
{
    public function authorize(): bool { return session()->has('company_id'); }

    public function rules(): array
    {
        return [
            'booth_banner' => ['nullable', 'image', 'max:8192'],
            'primary_color' => ['nullable', 'string', 'max:20'],
            'secondary_color' => ['nullable', 'string', 'max:20'],
            'welcome_heading' => ['nullable', 'string', 'max:255'],
            'theme_template' => ['nullable', 'string', 'max:100'],
            'booth_background' => ['nullable', 'image', 'max:8192'],
            'preset_background' => ['nullable', 'string', 'max:255'],
            'cta_button_text' => ['nullable', 'string', 'max:100'],
            'cta_button_link' => ['nullable', 'url', 'max:255'],
            'action' => ['nullable', 'in:save,continue,reset'],
        ];
    }
}
