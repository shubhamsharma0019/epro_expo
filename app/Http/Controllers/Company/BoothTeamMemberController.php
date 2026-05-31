<?php

namespace App\Http\Controllers\Company;

use App\Http\Requests\Company\BoothTeamMemberRequest;
use App\Models\BoothBooking;
use App\Models\BoothTeamMember;
use App\Services\Company\BoothFileUploadService;
use App\Services\Company\BoothSetupStepService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BoothTeamMemberController extends BaseBoothSetupController
{
    public function index(BoothBooking $booking, BoothSetupStepService $steps): View
    {
        $booking = $this->setupBooking($booking);
        return view('company.booth-setup.team', $this->commonData($booking, $steps) + ['teamMembers' => $booking->boothTeamMembers()->latest()->get()]);
    }
    public function create(BoothBooking $booking, BoothSetupStepService $steps): View { return $this->index($booking, $steps); }
    public function show(BoothBooking $booking, BoothTeamMember $teamMember, BoothSetupStepService $steps): View { return $this->edit($booking, $teamMember, $steps); }
    public function store(BoothTeamMemberRequest $request, BoothBooking $booking, BoothFileUploadService $files, BoothSetupStepService $steps): RedirectResponse
    {
        $booking = $this->setupBooking($booking);
        $data = $request->validated();
        $data['expertise_tags'] = collect(explode(',', (string) ($data['expertise_tags'] ?? '')))->map(fn ($tag) => trim($tag))->filter()->values()->all();
        if ($request->hasFile('photo')) {
            $data['photo'] = $files->upload($request->file('photo'), $booking->id, 'team');
        }
        BoothTeamMember::create($data + ['company_id' => $booking->company_id, 'booth_booking_id' => $booking->id]);
        $booking->boothTeamMembers()->where('status', 'active')->exists() ? $steps->markStepCompleted($booking, 'team') : $steps->markStepInProgress($booking, 'team');
        return back()->with('status', 'Team member saved.');
    }
    public function edit(BoothBooking $booking, BoothTeamMember $teamMember, BoothSetupStepService $steps): View
    {
        abort_unless($teamMember->company_id === (int) session('company_id') && $teamMember->booth_booking_id === $booking->id, 403);
        $booking = $this->setupBooking($booking);
        return view('company.booth-setup.team', $this->commonData($booking, $steps) + ['teamMember' => $teamMember, 'teamMembers' => $booking->boothTeamMembers()->latest()->get()]);
    }
    public function update(BoothTeamMemberRequest $request, BoothBooking $booking, BoothTeamMember $teamMember, BoothFileUploadService $files, BoothSetupStepService $steps): RedirectResponse
    {
        abort_unless($teamMember->company_id === (int) session('company_id') && $teamMember->booth_booking_id === $booking->id, 403);
        $booking = $this->setupBooking($booking);
        $data = $request->validated();
        $data['expertise_tags'] = collect(explode(',', (string) ($data['expertise_tags'] ?? '')))->map(fn ($tag) => trim($tag))->filter()->values()->all();
        if ($request->hasFile('photo')) {
            $data['photo'] = $files->upload($request->file('photo'), $booking->id, 'team', $teamMember->photo);
        }
        $teamMember->update($data);
        $booking->boothTeamMembers()->where('status', 'active')->exists() ? $steps->markStepCompleted($booking, 'team') : $steps->markStepInProgress($booking, 'team');
        return back()->with('status', 'Team member updated.');
    }
    public function destroy(BoothBooking $booking, BoothTeamMember $teamMember, BoothFileUploadService $files, BoothSetupStepService $steps): RedirectResponse
    {
        abort_unless($teamMember->company_id === (int) session('company_id') && $teamMember->booth_booking_id === $booking->id, 403);
        $booking = $this->setupBooking($booking);
        $files->delete($teamMember->photo);
        $teamMember->delete();
        $booking->boothTeamMembers()->where('status', 'active')->exists() ? $steps->markStepCompleted($booking, 'team') : $steps->markStepPending($booking, 'team');
        return back()->with('status', 'Team member deleted.');
    }
}
