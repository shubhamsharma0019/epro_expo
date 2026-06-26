<?php

use App\Support\VisitorFloorMap;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $now = now();

        DB::table('booths')
            ->select(['id', 'booth_number'])
            ->orderBy('id')
            ->chunkById(200, function ($booths) use ($now) {
                foreach ($booths as $booth) {
                    $boothNumber = strtoupper(trim((string) $booth->booth_number));

                    if (! preg_match('/^B0*(\d+)([A-Z]*)$/', $boothNumber, $matches)) {
                        continue;
                    }

                    $index = ((int) $matches[1]) - 1;

                    if ($index < 0 || $index >= 40) {
                        continue;
                    }

                    $layout = VisitorFloorMap::layoutForIndex($index);

                    DB::table('booths')
                        ->where('id', $booth->id)
                        ->update([
                            'position_x' => $layout['x'],
                            'position_y' => $layout['y'],
                            'updated_at' => $now,
                        ]);
                }
            });

        DB::table('halls')
            ->where('total_booths', '>', 0)
            ->update([
                'total_booths' => 40,
                'updated_at' => $now,
            ]);
    }

    public function down(): void
    {
        // Positions are derived from booth numbers; no safe automatic rollback.
    }
};
