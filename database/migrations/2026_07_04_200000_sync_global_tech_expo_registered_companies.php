<?php

use App\Domain\Booth\Models\Booth;
use App\Domain\Booth\Models\BoothBooking;
use App\Domain\Event\Models\Exhibition;
use App\Domain\Event\Models\Hall;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('booth_bookings') || ! Schema::hasTable('exhibitions')) {
            return;
        }

        $exhibition = Exhibition::query()->where('slug', 'global-tech-expo-2024')->first();

        if (! $exhibition) {
            return;
        }

        $hall = Hall::query()
            ->whereHas('pavilion', fn ($query) => $query->where('exhibition_id', $exhibition->id))
            ->where('status', 'active')
            ->orderBy('id')
            ->first();

        if (! $hall) {
            return;
        }

        $boothIds = Booth::query()
            ->where('hall_id', $hall->id)
            ->orderBy('id')
            ->pluck('id')
            ->values();

        $registeredBookings = BoothBooking::query()
            ->with('boothProfile')
            ->registeredExhibitor()
            ->orderBy('id')
            ->get();

        if ($registeredBookings->isEmpty()) {
            return;
        }

        $assignedOnExhibition = 0;

        foreach ($registeredBookings as $index => $booking) {
            if ($booking->exhibition_id === $exhibition->id) {
                if (! in_array($booking->booth_setup_status, ['published', 'approved', 'live'], true)) {
                    $booking->update(['booth_setup_status' => 'published']);
                }

                $assignedOnExhibition++;

                continue;
            }

            $boothId = $boothIds[$index] ?? $boothIds->first();

            $booking->update([
                'exhibition_id' => $exhibition->id,
                'pavilion_id' => $hall->pavilion_id,
                'hall_id' => $hall->id,
                'booth_id' => $boothId,
                'booth_setup_status' => 'published',
            ]);

            $assignedOnExhibition++;
        }

        if (Schema::hasColumn('exhibitions', 'companies_count')) {
            $exhibition->update(['companies_count' => $assignedOnExhibition]);
        }
    }

    public function down(): void
    {
        // Non-destructive data sync; no rollback.
    }
};
