<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('exhibitions', function (Blueprint $table) {
            $table->time('setup_start_time')->nullable()->after('end_date');
            $table->time('setup_end_time')->nullable()->after('setup_start_time');
            $table->time('show_start_time')->nullable()->after('setup_end_time');
            $table->time('show_end_time')->nullable()->after('show_start_time');
            $table->time('last_day_end_time')->nullable()->after('show_end_time');
        });

        DB::table('exhibitions')->update([
            'setup_start_time' => '08:00:00',
            'setup_end_time' => '16:00:00',
            'show_start_time' => '10:00:00',
            'show_end_time' => '18:00:00',
            'last_day_end_time' => '16:00:00',
        ]);
    }

    public function down(): void
    {
        Schema::table('exhibitions', function (Blueprint $table) {
            $table->dropColumn([
                'setup_start_time',
                'setup_end_time',
                'show_start_time',
                'show_end_time',
                'last_day_end_time',
            ]);
        });
    }
};
