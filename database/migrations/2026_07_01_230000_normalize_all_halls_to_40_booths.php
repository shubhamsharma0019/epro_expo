<?php

use App\Domain\Event\Models\Hall;
use App\Support\DatabaseProjectSync;
use App\Support\HallBoothLayoutSync;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (! DB::getSchemaBuilder()->hasTable('halls') || ! DB::getSchemaBuilder()->hasTable('booths')) {
            return;
        }

        $boothSizes = HallBoothLayoutSync::resolveBoothSizes();

        if ($boothSizes->isEmpty()) {
            DB::table('halls')->update([
                'total_booths' => 40,
                'updated_at' => now(),
            ]);

            return;
        }

        Hall::query()
            ->orderBy('id')
            ->each(function (Hall $hall) use ($boothSizes) {
                HallBoothLayoutSync::sync($hall, $boothSizes);
            });

        DatabaseProjectSync::syncHallBoothCounts();
        DatabaseProjectSync::syncPavilionBoothCounts();
    }

    public function down(): void
    {
        // Layout normalization migration — no safe rollback.
    }
};
