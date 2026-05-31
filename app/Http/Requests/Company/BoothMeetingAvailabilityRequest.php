<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class BoothMeetingAvailabilityRequest extends FormRequest
{
    public function authorize(): bool { return session()->has('company_id'); }

    public function rules(): array
    {
        return [
            'available_start_date' => ['required', 'date'],
            'available_end_date' => ['required', 'date', 'after_or_equal:available_start_date'],
            'available_weekdays' => ['required', 'array', 'min:1'],
            'available_weekdays.*' => ['string'],
            'daily_start_time' => ['required', 'date_format:H:i'],
            'daily_end_time' => ['required', 'date_format:H:i'],
            'meeting_types' => ['required', 'array', 'min:1'],
            'meeting_types.*' => ['in:video,audio,chat'],
            'slot_duration' => ['required', 'integer', 'min:5', 'max:240'],
            'buffer_time' => ['nullable', 'integer', 'min:0', 'max:120'],
            'assigned_team_member_id' => ['nullable', 'integer', 'exists:booth_team_members,id'],
            'timezone' => ['nullable', 'string', 'max:100'],
        ];
    }
}
