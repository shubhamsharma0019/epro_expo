<?php

namespace App\Http\Requests\Visitor;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EventVisitorRegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'event' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
            'phone' => ['required', 'string', 'max:30'],
            'gender' => ['required', 'string', Rule::in(['male', 'female', 'other', 'prefer_not_to_say'])],
            'city' => ['required', 'string', 'max:120'],
        ];
    }

    public function messages(): array
    {
        return [
            'password.min' => 'Password must be at least 8 characters.',
            'gender.in' => 'Please select a valid gender option.',
        ];
    }
}
