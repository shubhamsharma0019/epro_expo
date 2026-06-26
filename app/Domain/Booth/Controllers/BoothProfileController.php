<?php

namespace App\Domain\Booth\Controllers;

use App\Http\Requests\Company\BoothProfileRequest;
use App\Domain\Booth\Models\BoothBooking;
use App\Domain\Booth\Models\BoothProfile;
use App\Domain\Booth\Services\BoothFileUploadService;
use App\Domain\Booth\Services\BoothSetupStepService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BoothProfileController extends BaseBoothSetupController
{
    public function edit(BoothBooking $booking, BoothSetupStepService $steps): View
    {
        $booking = $this->setupBooking($booking);
        $steps->markStepInProgress($booking, 'profile');

        return view('company.booth-setup.company-profile', $this->commonData($booking, $steps) + [
            'profile' => $booking->boothProfile,
        ]);
    }

    public function update(BoothProfileRequest $request, BoothBooking $booking, BoothFileUploadService $files, BoothSetupStepService $steps): RedirectResponse|JsonResponse
    {
        $booking = $this->setupBooking($booking);
        $data = $request->validated();
        $next = $data['next'] ?? 'stay';
        unset($data['next']);

        $existing = $booking->boothProfile;

        if ($request->hasFile('company_logo')) {
            $data['company_logo'] = $files->upload($request->file('company_logo'), $booking->id, 'profile', $existing?->company_logo);
        }

        $data += [
            'company_id' => $booking->company_id,
            'booth_booking_id' => $booking->id,
            'booth_title' => $data['company_name'] ?? $booking->company?->company_name ?? 'Booth',
            'status' => 'draft',
        ];

        $profile = BoothProfile::updateOrCreate(['booth_booking_id' => $booking->id], $data);
        $booking->company?->update([
            'company_name' => $data['company_name'],
            'name' => $data['company_name'],
            'contact_person_name' => $data['contact_person'],
            'owner_name' => $data['contact_person'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'logo' => isset($data['company_logo']) ? 'storage/' . $data['company_logo'] : $booking->company?->logo,
            'website' => $data['website'] ?? null,
            'industry' => $data['industry'],
            'about' => $data['about_company'],
            'address' => $data['address'],
            'city' => $data['city'],
            'country' => $data['country'],
            'social_links' => array_filter([
                'linkedin' => $data['linkedin_url'] ?? null,
                'twitter' => $data['twitter_url'] ?? null,
                'facebook' => $data['facebook_url'] ?? null,
                'youtube' => $data['youtube_url'] ?? null,
            ]),
        ]);

        $steps->markStepCompleted($booking, 'profile');

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Company profile saved.',
                'profile_id' => $profile->id,
                'next_url' => route('company.booth-setup.branding.edit', $booking),
            ]);
        }

        if ($next === 'branding') {
            return redirect()
                ->route('company.booth-setup.branding.edit', $booking)
                ->with('status', 'Company profile saved. Continue with booth branding.');
        }

        return back()->with('status', 'Company profile saved.');
    }
}
