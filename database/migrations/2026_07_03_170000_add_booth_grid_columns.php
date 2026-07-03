<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('booths')) {
            return;
        }

        Schema::table('booths', function (Blueprint $table) {
            if (! Schema::hasColumn('booths', 'grid_row')) {
                $table->unsignedTinyInteger('grid_row')->nullable()->after('position_y');
            }

            if (! Schema::hasColumn('booths', 'grid_col')) {
                $table->unsignedTinyInteger('grid_col')->nullable()->after('grid_row');
            }
        });

        if (Schema::hasColumn('booths', 'grid_row') && Schema::hasColumn('booths', 'grid_col')) {
            $indexName = 'booths_hall_grid_position_unique';

            $indexes = collect(DB::select('SHOW INDEX FROM booths'))
                ->pluck('Key_name')
                ->unique();

            if (! $indexes->contains($indexName)) {
                Schema::table('booths', function (Blueprint $table) use ($indexName) {
                    $table->unique(['hall_id', 'grid_row', 'grid_col'], $indexName);
                });
            }
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('booths')) {
            return;
        }

        Schema::table('booths', function (Blueprint $table) {
            if (Schema::hasColumn('booths', 'grid_row')) {
                $table->dropUnique('booths_hall_grid_position_unique');
                $table->dropColumn(['grid_row', 'grid_col']);
            }
        });
    }
};
