<?php

use App\Domain\Visitor\Services\SessionRegistrationMeetingService;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        if (! class_exists(SessionRegistrationMeetingService::class)) {
            return;
        }

        app(SessionRegistrationMeetingService::class)->backfillExistingRegistrations();
    }

    public function down(): void
    {
        // Data backfill only — no rollback.
    }
};
