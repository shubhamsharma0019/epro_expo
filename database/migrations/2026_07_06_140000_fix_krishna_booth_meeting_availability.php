<?php

use App\Domain\Booth\Models\BoothBooking;
use App\Domain\Booth\Models\BoothMeetingAvailability;
use App\Domain\Booth\Models\BoothMeetingSlot;
use App\Domain\Booth\Services\BoothMeetingSlotService;
use App\Domain\Company\Models\CompanyMeeting;
use App\Support\BoothMeetingAvailabilityDefaults;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('booth_bookings')) {
            return;
        }

        $krishnaCompanyId = DB::table('companies')
            ->where('email', 'krishna@gmail.com')
            ->value('id');

        if (! $krishnaCompanyId) {
            $krishnaCompanyId = DB::table('companies')
                ->where('name', 'Krishna Enterprises')
                ->orderByDesc('id')
                ->value('id');
        }

        if (! $krishnaCompanyId) {
            return;
        }

        // Booth 481 was linked to a duplicate Krishna company without meeting availability.
        $booth481BookingId = DB::table('booth_bookings')
            ->where('booth_id', 481)
            ->where('payment_status', 'paid')
            ->value('id');

        if ($booth481BookingId) {
            DB::table('booth_bookings')
                ->where('id', $booth481BookingId)
                ->update([
                    'company_id' => $krishnaCompanyId,
                    'updated_at' => now(),
                ]);

            $this->ensureAvailabilityForBooking((int) $booth481BookingId, (int) $krishnaCompanyId);
        }

        // Re-home visitor requests that were saved against the duplicate company record.
        $duplicateCompanyId = DB::table('companies')
            ->where('id', '!=', $krishnaCompanyId)
            ->where(function ($query) {
                $query->where('name', 'Krishna Enterprises')
                    ->orWhere('company_name', 'Krishna Enterprises');
            })
            ->value('id');

        if ($duplicateCompanyId) {
            DB::table('visitor_meeting_bookings')
                ->where('company_id', $duplicateCompanyId)
                ->update([
                    'company_id' => $krishnaCompanyId,
                    'updated_at' => now(),
                ]);

            DB::table('company_meetings')
                ->where('company_id', $duplicateCompanyId)
                ->update([
                    'company_id' => $krishnaCompanyId,
                    'updated_at' => now(),
                ]);
        }

        $this->syncBookedSlotsForCompany((int) $krishnaCompanyId);
    }

    public function down(): void
    {
        // Data repair migration — no safe automatic rollback.
    }

    private function ensureAvailabilityForBooking(int $bookingId, int $companyId): void
    {
        if (! Schema::hasTable('booth_meeting_availabilities')) {
            return;
        }

        $booking = BoothBooking::query()->with('exhibition')->find($bookingId);

        if (! $booking) {
            return;
        }

        $existing = BoothMeetingAvailability::query()
            ->where('booth_booking_id', $bookingId)
            ->first();

        if (! $existing) {
            $template = BoothMeetingAvailability::query()
                ->where('company_id', $companyId)
                ->orderByDesc('id')
                ->first();

            $payload = $template
                ? collect($template->toArray())
                    ->except(['id', 'booth_booking_id', 'created_at', 'updated_at'])
                    ->all()
                : BoothMeetingAvailabilityDefaults::forBooking($booking);

            $payload['booth_booking_id'] = $bookingId;
            $payload['company_id'] = $companyId;

            $existing = BoothMeetingAvailability::query()->create($payload);
        } else {
            $existing->update(['company_id' => $companyId]);
        }

        app(BoothMeetingSlotService::class)->regenerate($existing);
    }

    private function syncBookedSlotsForCompany(int $companyId): void
    {
        if (! Schema::hasTable('booth_meeting_slots') || ! Schema::hasTable('company_meetings')) {
            return;
        }

        $meetings = CompanyMeeting::query()
            ->where('company_id', $companyId)
            ->whereIn('status', ['pending', 'confirmed', 'accepted', 'rescheduled'])
            ->get(['id', 'start_time', 'end_time', 'meeting_type']);

        foreach ($meetings as $meeting) {
            if (! $meeting->start_time) {
                continue;
            }

            $date = $meeting->start_time->toDateString();
            $time = $meeting->start_time->format('H:i:s');

            BoothMeetingSlot::query()
                ->where('company_id', $companyId)
                ->whereDate('date', $date)
                ->where('start_time', $time)
                ->update(['status' => 'booked']);
        }
    }
};
