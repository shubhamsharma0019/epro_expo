<?php

use App\Domain\Booth\Models\BoothSession;
use App\Domain\Booth\Services\BoothSessionConferenceService;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        if (! class_exists(BoothSessionConferenceService::class)) {
            return;
        }

        $service = app(BoothSessionConferenceService::class);

        BoothSession::query()
            ->whereNull('company_meeting_id')
            ->orderBy('id')
            ->each(function (BoothSession $session) use ($service) {
                try {
                    $service->syncConferenceMeeting($session);
                } catch (\Throwable) {
                    // Keep migration resilient for incomplete booth data.
                }
            });
    }

    public function down(): void
    {
        // Non-destructive data backfill.
    }
};
