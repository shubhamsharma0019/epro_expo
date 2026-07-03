<?php

use App\Support\SequentialBoothSizes;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('booth_sizes')) {
            return;
        }

        $now = now();

        foreach (SequentialBoothSizes::CATALOG as $area => $price) {
            [$width, $height] = SequentialBoothSizes::dimensionsForArea($area);
            $title = SequentialBoothSizes::titleForArea($area);
            $units = max(1, (int) round($area / SequentialBoothSizes::UNIT_AREA));
            $description = $units === 1
                ? 'Base booth size: 9 sq.m (one 9 sq.m block).'
                : sprintf('%d sq.m booth size (%d × 9 sq.m blocks).', $area, $units);

            $existing = DB::table('booth_sizes')
                ->where('area', $area)
                ->where('status', 'active')
                ->orderBy('id')
                ->first();

            if ($existing) {
                DB::table('booth_sizes')
                    ->where('id', $existing->id)
                    ->update([
                        'title' => $title,
                        'width' => $width,
                        'height' => $height,
                        'area' => $area,
                        'price' => $price,
                        'description' => $description,
                        'status' => 'active',
                        'updated_at' => $now,
                    ]);

                continue;
            }

            DB::table('booth_sizes')->insert([
                'title' => $title,
                'width' => $width,
                'height' => $height,
                'area' => $area,
                'price' => $price,
                'description' => $description,
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    public function down(): void
    {
        // Size catalog normalization is not reversed automatically.
    }
};
