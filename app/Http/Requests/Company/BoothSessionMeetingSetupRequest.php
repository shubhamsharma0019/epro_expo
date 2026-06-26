<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class BoothSessionMeetingSetupRequest extends FormRequest
{
    public function authorize(): bool
    {
        return session()->has('company_id');
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'allow_one_to_one' => $this->boolean('allow_one_to_one'),
            'allow_one_to_many' => $this->boolean('allow_one_to_many'),
            'allow_conference' => $this->boolean('allow_conference'),
        ]);
    }

    public function rules(): array
    {
        return [
            'allow_one_to_one' => ['boolean'],
            'allow_one_to_many' => ['boolean'],
            'allow_conference' => ['boolean'],
            'conference_capacity' => ['nullable', 'integer', 'min:2', 'max:1000'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator): void {
            if (! $this->boolean('allow_one_to_one')
                && ! $this->boolean('allow_one_to_many')
                && ! $this->boolean('allow_conference')) {
                $validator->errors()->add('meeting_setup', 'Select at least one meeting format.');
            }

            if ($this->boolean('allow_conference') && ! $this->filled('conference_capacity')) {
                $validator->errors()->add('conference_capacity', 'Enter the maximum number of attendees for conference meetings.');
            }
        });
    }
}
