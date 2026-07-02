<?php

use App\Domain\Booth\Models\BoothBooking;
use App\Domain\Booth\Models\BoothMeetingAvailability;
use App\Domain\Booth\Services\BoothMeetingSlotService;
use App\Support\BoothMeetingAvailabilityDefaults;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('visitor_meeting_bookings') && ! Schema::hasColumn('visitor_meeting_bookings', 'booth_meeting_slot_id')) {
            Schema::table('visitor_meeting_bookings', function (Blueprint $table) {
                $table->foreignId('booth_meeting_slot_id')
                    ->nullable()
                    ->after('company_meeting_id')
                    ->constrained('booth_meeting_slots')
                    ->nullOnDelete();
            });
        }

        if (! Schema::hasTable('booth_meeting_availabilities')) {
            return;
        }

        DB::table('booth_meeting_availabilities')
            ->whereColumn('daily_end_time', '<=', 'daily_start_time')
            ->update([
                'daily_end_time' => '18:00:00',
                'updated_at' => now(),
            ]);

        if (! Schema::hasTable('booth_bookings')) {
            return;
        }

        $slotService = app(BoothMeetingSlotService::class);

        BoothBooking::query()
            ->with('exhibition')
            ->where('payment_status', 'paid')
            ->whereIn('booking_status', ['confirmed', 'active'])
            ->whereIn('admin_status', ['pending', 'approved'])
            ->whereDoesntHave('boothMeetingAvailability')
            ->orderBy('id')
            ->each(function (BoothBooking $booking) use ($slotService) {
                $availability = BoothMeetingAvailability::query()->create(
                    BoothMeetingAvailabilityDefaults::forBooking($booking)
                );
                $slotService->regenerate($availability);
            });

        BoothMeetingAvailability::query()
            ->with('boothBooking.exhibition')
            ->orderBy('id')
            ->each(function (BoothMeetingAvailability $availability) use ($slotService) {
                $slotService->regenerate($availability);
            });
    }

    public function down(): void
    {
        if (Schema::hasTable('visitor_meeting_bookings') && Schema::hasColumn('visitor_meeting_bookings', 'booth_meeting_slot_id')) {
            Schema::table('visitor_meeting_bookings', function (Blueprint $table) {
                $table->dropConstrainedForeignId('booth_meeting_slot_id');
            });
        }
    }
};
