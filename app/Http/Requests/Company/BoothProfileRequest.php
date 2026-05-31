<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BoothProfileRequest extends FormRequest
{
    public function authorize(): bool { return session()->has('company_id'); }

    public function rules(): array
    {
        return [
            'company_logo' => ['nullable', 'image', 'max:5120'],
            'company_name' => ['required', 'string', 'max:255'],
            'contact_person' => ['required', 'string', 'max:255'],
            'industry' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('companies', 'email')->ignore((int) session('company_id')),
            ],
            'phone' => ['required', 'string', 'max:50'],
            'tagline' => ['nullable', 'string', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],
            'about_company' => ['required', 'string', 'max:300'],
            'address' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:100'],
            'state' => ['required', 'string', 'max:100'],
            'zip_code' => ['required', 'string', 'max:30'],
            'country' => ['required', 'string', 'max:100'],
            'linkedin_url' => ['nullable', 'url', 'max:255'],
            'twitter_url' => ['nullable', 'url', 'max:255'],
            'facebook_url' => ['nullable', 'url', 'max:255'],
            'youtube_url' => ['nullable', 'url', 'max:255'],
            'next' => ['nullable', 'in:stay,branding'],
        ];
    }
}
