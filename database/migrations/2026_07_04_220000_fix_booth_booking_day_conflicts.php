<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('booth_bookings') || ! Schema::hasTable('booth_booking_days') || ! Schema::hasTable('booths')) {
            return;
        }

        $bookings = DB::table('booth_bookings')
            ->whereNotNull('company_id')
            ->whereNotNull('hall_id')
            ->orderBy('id')
            ->get();

        foreach ($bookings as $booking) {
            $hallId = (int) $booking->hall_id;
            $canonicalBoothId = $this->resolveCanonicalBoothId($booking, $hallId);

            if (! $canonicalBoothId) {
                continue;
            }

            DB::table('booth_bookings')
                ->where('id', $booking->id)
                ->update([
                    'booth_id' => $canonicalBoothId,
                    'selected_booth_ids' => json_encode([$canonicalBoothId]),
                    'updated_at' => now(),
                ]);

            DB::table('booth_booking_days')
                ->where('booth_booking_id', $booking->id)
                ->update([
                    'booth_id' => $canonicalBoothId,
                    'updated_at' => now(),
                ]);
        }

        $activeBoothIds = DB::table('booth_bookings')
            ->where('payment_status', 'paid')
            ->whereIn('booking_status', ['confirmed', 'active'])
            ->whereIn('admin_status', ['pending', 'approved'])
            ->get()
            ->flatMap(function ($booking) {
                $ids = json_decode($booking->selected_booth_ids ?? '[]', true) ?: [];

                return collect($ids)
                    ->push($booking->booth_id)
                    ->map(fn ($id) => (int) $id)
                    ->filter()
                    ->unique()
                    ->values()
                    ->all();
            })
            ->unique()
            ->values()
            ->all();

        if ($activeBoothIds !== []) {
            DB::table('booths')
                ->whereIn('id', $activeBoothIds)
                ->where('status', 'available')
                ->update([
                    'status' => 'booked',
                    'updated_at' => now(),
                ]);
        }

        $this->removeDuplicateBookingDays();
    }

    public function down(): void
    {
        // Data repair migration is not reversed automatically.
    }

    private function resolveCanonicalBoothId(object $booking, int $hallId): ?int
    {
        $selectedIds = collect(json_decode($booking->selected_booth_ids ?? '[]', true) ?: [])
            ->map(fn ($id) => (int) $id)
            ->filter()
            ->unique()
            ->values();

        $candidateIds = $selectedIds
            ->push((int) $booking->booth_id)
            ->filter()
            ->unique()
            ->values();

        foreach ($candidateIds as $candidateId) {
            $booth = DB::table('booths')
                ->where('id', $candidateId)
                ->where('hall_id', $hallId)
                ->first();

            if ($booth) {
                return (int) $booth->id;
            }
        }

        $primaryBooth = DB::table('booths')
            ->where('id', (int) $booking->booth_id)
            ->where('hall_id', $hallId)
            ->first();

        return $primaryBooth ? (int) $primaryBooth->id : null;
    }

    private function removeDuplicateBookingDays(): void
    {
        $duplicateGroups = DB::table('booth_booking_days')
            ->select('booth_id', 'booking_date', DB::raw('MIN(id) as keep_id'), DB::raw('COUNT(*) as total'))
            ->groupBy('booth_id', 'booking_date')
            ->having('total', '>', 1)
            ->get();

        foreach ($duplicateGroups as $group) {
            DB::table('booth_booking_days')
                ->where('booth_id', $group->booth_id)
                ->whereDate('booking_date', $group->booking_date)
                ->where('id', '!=', $group->keep_id)
                ->delete();
        }
    }
};
