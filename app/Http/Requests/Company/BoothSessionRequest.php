<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BoothSessionRequest extends FormRequest
{
    public function authorize(): bool { return session()->has('company_id'); }

    public function rules(): array
    {
        $booking = $this->route('booking');
        $bookingId = is_object($booking) ? $booking->id : $booking;

        return [
            'team_member_id' => [
                'nullable',
                'integer',
                Rule::exists('booth_team_members', 'id')
                    ->where('company_id', (int) session('company_id'))
                    ->where('booth_booking_id', (int) $bookingId),
            ],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'session_date' => ['required', 'date'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
            'type' => ['required', 'in:live_demo,webinar,talk,qna'],
            'attendee_limit' => ['nullable', 'integer', 'min:1'],
            'status' => ['required', 'in:upcoming,live,completed,cancelled'],
        ];
    }
}
