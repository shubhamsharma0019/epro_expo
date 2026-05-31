<?php

namespace App\Services\Company;

use App\Models\BoothBooking;
use App\Models\BoothSetupStep;
use Illuminate\Support\Collection;

class BoothSetupStepService
{
    public const STEPS = [
        'profile' => 'Company Profile',
        'branding' => 'Booth Branding',
        'products' => 'Products',
        'documents' => 'Documents',
        'catalogues' => 'Catalogues',
        'media' => 'Media Gallery',
        'team' => 'Team Members',
        'meetings' => 'Meeting Availability',
        'sessions' => 'Sessions',
        'preview' => 'Preview Booth',
        'publish' => 'Publish Booth',
    ];

    public function createDefaultSteps(BoothBooking $booking): Collection
    {
        foreach (self::STEPS as $index => $name) {
            BoothSetupStep::firstOrCreate(
                [
                    'booth_booking_id' => $booking->id,
                    'step_key' => $index,
                ],
                [
                    'company_id' => $booking->company_id,
                    'step_name' => $name,
                    'status' => 'pending',
                    'sort_order' => array_search($index, array_keys(self::STEPS), true) + 1,
                ]
            );
        }

        return $booking->boothSetupSteps()->orderBy('sort_order')->get();
    }

    public function markStepPending(BoothBooking $booking, string $stepKey): BoothSetupStep
    {
        return $this->mark($booking, $stepKey, 'pending');
    }

    public function markStepInProgress(BoothBooking $booking, string $stepKey): BoothSetupStep
    {
        return $this->mark($booking, $stepKey, 'in_progress');
    }

    public function markStepCompleted(BoothBooking $booking, string $stepKey): BoothSetupStep
    {
        return $this->mark($booking, $stepKey, 'completed');
    }

    public function getProgress(BoothBooking $booking): int
    {
        $this->syncFromBookingData($booking);

        $steps = $this->getSteps($booking);
        if ($steps->isEmpty()) {
            return 0;
        }

        return (int) round(($steps->where('status', 'completed')->count() / $steps->count()) * 100);
    }

    public function getSteps(BoothBooking $booking): Collection
    {
        $this->syncFromBookingData($booking, false);

        return $booking->boothSetupSteps()->orderBy('sort_order')->get();
    }

    public function checkPublishReadiness(BoothBooking $booking): array
    {
        $this->syncFromBookingData($booking);

        $required = collect(self::STEPS)->keys()->reject(fn ($key) => $key === 'publish')->values();
        $completed = $this->getSteps($booking)->where('status', 'completed')->pluck('step_key');
        $missing = $required->diff($completed)->values();

        return [
            'ready' => $missing->isEmpty(),
            'missing' => $missing,
            'steps' => $this->getSteps($booking),
        ];
    }

    private function mark(BoothBooking $booking, string $stepKey, string $status): BoothSetupStep
    {
        $this->createDefaultSteps($booking);

        $step = BoothSetupStep::where('booth_booking_id', $booking->id)
            ->where('step_key', $stepKey)
            ->firstOrFail();

        $step->update([
            'status' => $status,
            'completed_at' => $status === 'completed' ? now() : null,
        ]);

        if ($booking->booth_setup_status === 'draft') {
            $booking->update(['booth_setup_status' => 'setup_in_progress']);
        }

        return $step;
    }

    public function syncFromBookingData(BoothBooking $booking, bool $ensureSteps = true): void
    {
        static $syncing = [];

        if (isset($syncing[$booking->id])) {
            return;
        }

        $syncing[$booking->id] = true;

        if ($ensureSteps) {
            $this->createDefaultSteps($booking);
        }

        $booking->loadMissing([
            'boothProfile',
            'boothBranding',
            'boothProducts',
            'boothDocuments',
            'boothCatalogues',
            'boothMedia',
            'boothTeamMembers',
            'boothMeetingAvailability',
            'boothSessions',
            'boothPublishRequest',
        ]);

        $states = [
            'profile' => $booking->boothProfile ? 'completed' : 'pending',
            'branding' => $booking->boothBranding ? 'completed' : 'pending',
            'products' => $booking->boothProducts->isNotEmpty() ? 'completed' : 'pending',
            'documents' => $booking->boothDocuments->isNotEmpty() ? 'completed' : 'pending',
            'catalogues' => $booking->boothCatalogues->isNotEmpty() ? 'completed' : 'pending',
            'media' => $booking->boothMedia->isNotEmpty() ? 'completed' : 'pending',
            'team' => $booking->boothTeamMembers->isNotEmpty() ? 'completed' : 'pending',
            'meetings' => $booking->boothMeetingAvailability ? 'completed' : 'pending',
            'sessions' => $booking->boothSessions->isNotEmpty() ? 'completed' : 'pending',
            'preview' => $booking->booth_setup_status && in_array($booking->booth_setup_status, ['ready_to_publish', 'pending_review', 'published'], true) ? 'completed' : 'pending',
            'publish' => $booking->boothPublishRequest ? 'completed' : 'pending',
        ];

        foreach ($states as $stepKey => $status) {
            BoothSetupStep::where('booth_booking_id', $booking->id)
                ->where('step_key', $stepKey)
                ->update([
                    'status' => $status,
                    'completed_at' => $status === 'completed'
                        ? now()
                        : null,
                ]);
        }

        unset($syncing[$booking->id]);
    }
}
