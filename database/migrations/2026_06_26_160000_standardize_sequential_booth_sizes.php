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
        $sizeIdsByArea = [];

        foreach (SequentialBoothSizes::CATALOG as $area => $price) {
            [$width, $height] = SequentialBoothSizes::dimensionsForArea($area);
            $title = SequentialBoothSizes::titleForArea($area);

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
                        'status' => 'active',
                        'updated_at' => $now,
                    ]);

                $sizeIdsByArea[$area] = (int) $existing->id;

                continue;
            }

            $sizeIdsByArea[$area] = (int) DB::table('booth_sizes')->insertGetId([
                'title' => $title,
                'width' => $width,
                'height' => $height,
                'area' => $area,
                'price' => $price,
                'description' => sprintf('%d sq.m sequential booth size.', $area),
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        $legacyTwelve = DB::table('booth_sizes')->where('area', 12)->pluck('id')->all();
        $targetEighteen = $sizeIdsByArea[18] ?? null;

        if ($legacyTwelve !== [] && $targetEighteen) {
            if (Schema::hasTable('booth_bookings')) {
                DB::table('booth_bookings')
                    ->whereIn('booth_size_id', $legacyTwelve)
                    ->update(['booth_size_id' => $targetEighteen]);
            }

            if (Schema::hasTable('booths')) {
                DB::table('booths')
                    ->whereIn('booth_size_id', $legacyTwelve)
                    ->update(['booth_size_id' => $sizeIdsByArea[9] ?? $targetEighteen]);
            }
        }

        $duplicateEightyOne = DB::table('booth_sizes')
            ->where('area', 81)
            ->where('status', 'active')
            ->orderByDesc('id')
            ->pluck('id')
            ->all();

        $canonicalEightyOne = $sizeIdsByArea[81] ?? null;

        if ($canonicalEightyOne && count($duplicateEightyOne) > 1) {
            $duplicateIds = array_values(array_filter(
                $duplicateEightyOne,
                fn (int $id) => $id !== $canonicalEightyOne
            ));

            if ($duplicateIds !== []) {
                if (Schema::hasTable('booth_bookings')) {
                    DB::table('booth_bookings')
                        ->whereIn('booth_size_id', $duplicateIds)
                        ->update(['booth_size_id' => $canonicalEightyOne]);
                }

                if (Schema::hasTable('booths')) {
                    DB::table('booths')
                        ->whereIn('booth_size_id', $duplicateIds)
                        ->update(['booth_size_id' => $canonicalEightyOne]);
                }

                DB::table('booth_sizes')
                    ->whereIn('id', $duplicateIds)
                    ->update([
                        'status' => 'inactive',
                        'updated_at' => $now,
                    ]);
            }
        }

        $allowedAreas = array_keys(SequentialBoothSizes::CATALOG);

        DB::table('booth_sizes')
            ->whereNotIn('area', $allowedAreas)
            ->update([
                'status' => 'inactive',
                'updated_at' => $now,
            ]);
    }

    public function down(): void
    {
        // Data normalization is not reversed automatically.
    }
};
