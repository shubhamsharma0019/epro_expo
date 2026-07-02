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

        Schema::table('booth_profiles', function (Blueprint $table) {
            foreach ([
                'years_experience' => 'years_experience',
                'clients_count' => 'clients_count',
                'countries_served' => 'countries_served',
                'expert_team_size' => 'expert_team_size',
            ] as $column) {
                if (! Schema::hasColumn('booth_profiles', $column)) {
                    $table->string($column, 30)->nullable()->after('highlight_stats');
                }
            }
        });

        DB::table('booth_profiles')->orderBy('id')->each(function ($profile) {
            $stats = json_decode($profile->highlight_stats ?? '', true);
            if (! is_array($stats)) {
                $stats = [];
            }

            DB::table('booth_profiles')->where('id', $profile->id)->update([
                'years_experience' => $profile->years_experience ?: ($stats['years_experience'] ?? '10+'),
                'clients_count' => $profile->clients_count ?: ($stats['clients'] ?? '250+'),
                'countries_served' => $profile->countries_served ?: ($stats['countries'] ?? '25+'),
                'expert_team_size' => $profile->expert_team_size ?: ($stats['team_size'] ?? '100+'),
                'highlight_stats' => json_encode([
                    'years_experience' => $profile->years_experience ?: ($stats['years_experience'] ?? '10+'),
                    'clients' => $profile->clients_count ?: ($stats['clients'] ?? '250+'),
                    'countries' => $profile->countries_served ?: ($stats['countries'] ?? '25+'),
                    'team_size' => $profile->expert_team_size ?: ($stats['team_size'] ?? '100+'),
                ]),
                'updated_at' => now(),
            ]);
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('booth_profiles')) {
            return;
        }

        Schema::table('booth_profiles', function (Blueprint $table) {
            foreach (['years_experience', 'clients_count', 'countries_served', 'expert_team_size'] as $column) {
                if (Schema::hasColumn('booth_profiles', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
