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
                    $index = VisitorFloorMap::layoutIndexForBoothNumber((string) $booth->booth_number);

                    if ($index === null) {
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
    }

    public function down(): void
    {
        // Grid positions are derived from booth numbers; no safe automatic rollback.
    }
};
