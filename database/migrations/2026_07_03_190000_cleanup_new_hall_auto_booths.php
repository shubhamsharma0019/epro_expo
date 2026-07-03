<?php

use App\Domain\Booth\Models\Booth;
use App\Domain\Event\Models\Hall;
use App\Support\DatabaseProjectSync;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (! DB::getSchemaBuilder()->hasTable('halls') || ! DB::getSchemaBuilder()->hasTable('booths')) {
            return;
        }

        $hall = Hall::query()->where('slug', 'new-hall')->first();

        if (! $hall) {
            return;
        }

        Booth::query()
            ->where('hall_id', $hall->id)
            ->whereDoesntHave('boothBooking')
            ->delete();

        $remaining = Booth::query()->where('hall_id', $hall->id)->count();

        $hall->update([
            'total_booths' => $remaining,
            'updated_at' => now(),
        ]);

        if (class_exists(DatabaseProjectSync::class)) {
            DatabaseProjectSync::syncHallBoothCounts();
            DatabaseProjectSync::syncPavilionBoothCounts();
        }
    }

    public function down(): void
    {
        // Data cleanup is not reversed automatically.
    }
};
