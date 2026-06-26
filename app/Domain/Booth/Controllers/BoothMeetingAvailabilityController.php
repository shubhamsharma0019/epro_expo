<?php

namespace App\Domain\Booth\Controllers;

use App\Http\Requests\Company\BoothMeetingAvailabilityRequest;
use App\Domain\Booth\Models\BoothBooking;
use App\Domain\Booth\Models\BoothMeetingAvailability;
use App\Domain\Booth\Services\BoothMeetingSlotService;
use App\Domain\Booth\Services\BoothSetupStepService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BoothMeetingAvailabilityController extends BaseBoothSetupController
{
    public function edit(BoothBooking $booking, BoothSetupStepService $steps): View
    {
        $booking = $this->setupBooking($booking);
        $steps->markStepInProgress($booking, 'meetings');

        return view('company.booth-setup.meetings', $this->commonData($booking, $steps) + [
            'availability' => $booking->boothMeetingAvailability,
            'meetingSlots' => $booking->boothMeetingSlots()->orderBy('date')->orderBy('start_time')->get(),
            'teamMembers' => $booking->boothTeamMembers()->where('status', 'active')->get(),
        ]);
    }

    public function update(BoothMeetingAvailabilityRequest $request, BoothBooking $booking, BoothMeetingSlotService $slots, BoothSetupStepService $steps): RedirectResponse
    {
        $booking = $this->setupBooking($booking);
        $data = $request->validated() + ['company_id' => $booking->company_id, 'booth_booking_id' => $booking->id];
        $availability = BoothMeetingAvailability::updateOrCreate(['booth_booking_id' => $booking->id], $data);
        $slots->regenerate($availability);
        $steps->markStepCompleted($booking, 'meetings');

        return back()->with('status', 'Meeting availability saved and slots generated.');
    }
}
