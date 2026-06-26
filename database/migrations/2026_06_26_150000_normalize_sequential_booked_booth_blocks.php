<?php

use App\Domain\Booth\Models\Booth;
use App\Domain\Booth\Models\BoothBooking;
use App\Domain\Event\Models\Hall;
use App\Support\SequentialBoothAllocation;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $now = now();

        Hall::query()
            ->orderBy('id')
            ->each(function (Hall $hall) use ($now) {
                $hallBooths = Booth::query()->where('hall_id', $hall->id)->get();

                if ($hallBooths->isEmpty()) {
                    return;
                }

                $bookings = BoothBooking::query()
                    ->where('hall_id', $hall->id)
                    ->where('payment_status', 'paid')
                    ->whereIn('booking_status', ['confirmed', 'active'])
                    ->whereIn('admin_status', ['pending', 'approved'])
                    ->orderBy('created_at')
                    ->orderBy('id')
                    ->get();

                $assignedBoothIds = [];

                foreach ($bookings as $booking) {
                    $requiredSpaces = max(
                        collect($booking->selected_booth_ids ?: [$booking->booth_id])
                            ->filter()
                            ->map(fn ($id) => (int) $id)
                            ->unique()
                            ->count(),
                        1
                    );

                    $preferredStart = SequentialBoothAllocation::preferredStartIndex(
                        $hallBooths,
                        (int) $booking->booth_id,
                        $booking->selected_booth_ids
                    );

                    $assignment = SequentialBoothAllocation::assignBlockForBooking(
                        $hallBooths,
                        $requiredSpaces,
                        $preferredStart,
                        $assignedBoothIds
                    );

                    if ($assignment === null) {
                        continue;
                    }

                    [$primaryBoothId, $selectedBoothIds] = $assignment;

                    DB::table('booth_bookings')
                        ->where('id', $booking->id)
                        ->update([
                            'booth_id' => $primaryBoothId,
                            'selected_booth_ids' => json_encode(array_values($selectedBoothIds)),
                            'updated_at' => $now,
                        ]);

                    $assignedBoothIds = array_values(array_unique(array_merge($assignedBoothIds, $selectedBoothIds)));
                }

                if ($assignedBoothIds === []) {
                    return;
                }

                DB::table('booths')
                    ->where('hall_id', $hall->id)
                    ->whereIn('id', $assignedBoothIds)
                    ->update([
                        'status' => 'booked',
                        'updated_at' => $now,
                    ]);

                DB::table('booths')
                    ->where('hall_id', $hall->id)
                    ->whereNotIn('id', $assignedBoothIds)
                    ->where('status', 'booked')
                    ->whereNotExists(function ($query) {
                        $query->select(DB::raw(1))
                            ->from('booth_bookings')
                            ->whereColumn('booth_bookings.booth_id', 'booths.id')
                            ->where('booth_bookings.payment_status', 'paid')
                            ->whereIn('booth_bookings.booking_status', ['confirmed', 'active']);
                    })
                    ->update([
                        'status' => 'available',
                        'updated_at' => $now,
                    ]);
            });
    }

    public function down(): void
    {
        // Booking booth allocations are business data; no safe automatic rollback.
    }
};
