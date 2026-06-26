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
            ->where('booth_number', 'like', 'TMP%')
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('booth_bookings')
                    ->whereColumn('booth_bookings.booth_id', 'booths.id');
            })
            ->orderBy('id')
            ->chunkById(200, function ($rows) use ($now) {
                foreach ($rows as $row) {
                    if (! preg_match('/^TMP(\d+)$/', strtoupper((string) $row->booth_number), $matches)) {
                        DB::table('booths')->where('id', $row->id)->delete();

                        continue;
                    }

                    $targetNumber = 'B' . str_pad((string) (((int) $matches[1]) + 1), 2, '0', STR_PAD_LEFT);
                    $duplicateExists = DB::table('booths')
                        ->where('hall_id', $row->hall_id)
                        ->where('booth_number', $targetNumber)
                        ->where('id', '!=', $row->id)
                        ->exists();

                    if ($duplicateExists) {
                        DB::table('booths')->where('id', $row->id)->delete();

                        continue;
                    }

                    $layout = VisitorFloorMap::layoutForIndex(((int) $matches[1]));

                    DB::table('booths')
                        ->where('id', $row->id)
                        ->update([
                            'booth_number' => $targetNumber,
                            'position_x' => $layout['x'],
                            'position_y' => $layout['y'],
                            'updated_at' => $now,
                        ]);
                }
            });

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
    }

    public function down(): void
    {
        // Data cleanup migration; no rollback.
    }
};
