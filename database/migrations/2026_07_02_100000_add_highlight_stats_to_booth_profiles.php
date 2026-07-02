<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('booth_profiles')) {
            return;
        }

        if (! Schema::hasColumn('booth_profiles', 'highlight_stats')) {
            Schema::table('booth_profiles', function (Blueprint $table) {
                $table->json('highlight_stats')->nullable()->after('about_company');
            });
        }

        $defaultStats = json_encode([
            'years_experience' => '10+',
            'clients' => '250+',
            'countries' => '25+',
            'team_size' => '100+',
        ]);

        DB::table('booth_profiles')
            ->whereNull('highlight_stats')
            ->update([
                'highlight_stats' => $defaultStats,
                'updated_at' => now(),
            ]);
    }

    public function down(): void
    {
        if (Schema::hasTable('booth_profiles') && Schema::hasColumn('booth_profiles', 'highlight_stats')) {
            Schema::table('booth_profiles', function (Blueprint $table) {
                $table->dropColumn('highlight_stats');
            });
        }
    }
};
