<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private const PAVILION_FILES = [
        'automotive-pavilion.png',
        'business-pavilion.png',
        'education-pavilion.png',
        'healthcare-pavilion.png',
        'innovation-pavilion.png',
        'sustainability-pavilion.png',
    ];

    public function up(): void
    {
        if (! Schema::hasTable('halls') || ! Schema::hasColumn('halls', 'image')) {
            return;
        }

        $this->syncHallImagesToStorage();

        DB::table('halls')
            ->where('image', 'like', 'assets/images/pavilions/%')
            ->update([
                'image' => DB::raw("REPLACE(image, 'assets/images/pavilions/', 'halls/')"),
                'updated_at' => now(),
            ]);

        DB::table('halls')
            ->where(function ($query) {
                $query->whereNull('image')->orWhere('image', '');
            })
            ->update([
                'image' => 'halls/innovation-pavilion.png',
                'updated_at' => now(),
            ]);
    }

    public function down(): void
    {
        if (! Schema::hasTable('halls') || ! Schema::hasColumn('halls', 'image')) {
            return;
        }

        DB::table('halls')
            ->where('image', 'like', 'halls/%')
            ->update([
                'image' => DB::raw("REPLACE(image, 'halls/', 'assets/images/pavilions/')"),
                'updated_at' => now(),
            ]);
    }

    private function syncHallImagesToStorage(): void
    {
        $sourceDir = public_path('assets/images/pavilions');
        $destDir = storage_path('app/public/halls');

        if (! File::isDirectory($sourceDir)) {
            return;
        }

        if (! File::isDirectory($destDir)) {
            File::makeDirectory($destDir, 0755, true);
        }

        foreach (self::PAVILION_FILES as $filename) {
            $source = $sourceDir . DIRECTORY_SEPARATOR . $filename;
            $dest = $destDir . DIRECTORY_SEPARATOR . $filename;

            if (File::exists($source) && ! File::exists($dest)) {
                File::copy($source, $dest);
            }
        }
    }
};
