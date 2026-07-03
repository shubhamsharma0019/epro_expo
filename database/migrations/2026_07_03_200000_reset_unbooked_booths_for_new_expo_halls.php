<?php

use App\Domain\Booth\Models\Booth;
use App\Domain\Event\Models\Exhibition;
use App\Domain\Event\Models\Hall;
use App\Support\DatabaseProjectSync;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (! DB::getSchemaBuilder()->hasTable('exhibitions') || ! DB::getSchemaBuilder()->hasTable('halls') || ! DB::getSchemaBuilder()->hasTable('booths')) {
            return;
        }

        $exhibitionIds = Exhibition::query()
            ->whereIn('slug', ['new-expo'])
            ->orWhere('title', 'like', 'new Expo%')
            ->pluck('id');

        if ($exhibitionIds->isEmpty()) {
            return;
        }

        $hallIds = Hall::query()
            ->whereHas('pavilion', fn ($query) => $query->whereIn('exhibition_id', $exhibitionIds))
            ->pluck('id');

        foreach ($hallIds as $hallId) {
            $deleted = Booth::query()
                ->where('hall_id', $hallId)
                ->whereDoesntHave('boothBooking')
                ->delete();

            if ($deleted > 0) {
                Hall::query()->whereKey($hallId)->update([
                    'total_booths' => Booth::query()->where('hall_id', $hallId)->count(),
                    'updated_at' => now(),
                ]);
            }
        }

        if (class_exists(DatabaseProjectSync::class)) {
            DatabaseProjectSync::syncHallBoothCounts();
            DatabaseProjectSync::syncPavilionBoothCounts();
        }
    }

    public function down(): void
    {
        // Cleanup is not reversed automatically.
    }
};
