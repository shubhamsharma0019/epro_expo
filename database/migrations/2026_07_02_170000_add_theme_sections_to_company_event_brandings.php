<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('company_event_brandings')) {
            return;
        }

        Schema::table('company_event_brandings', function (Blueprint $table) {
            if (! Schema::hasColumn('company_event_brandings', 'theme_sections')) {
                $table->json('theme_sections')->nullable()->after('social_links');
            }
        });

        DB::table('company_event_brandings')
            ->orderBy('id')
            ->chunkById(100, function ($rows) {
                foreach ($rows as $row) {
                    $socialLinks = json_decode($row->social_links ?? 'null', true);
                    $themeSections = null;

                    if (is_array($socialLinks) && isset($socialLinks['theme_sections'])) {
                        $themeSections = json_encode($socialLinks['theme_sections']);
                    }

                    $payload = [];
                    if ($themeSections !== null) {
                        $payload['theme_sections'] = $themeSections;
                    }

                    if (is_array($socialLinks)) {
                        $cleanSocial = collect($socialLinks)
                            ->except(['theme_sections', 'facebook', 'twitter', 'linkedin', 'instagram', 'youtube', 'social'])
                            ->filter(fn ($value) => filled($value))
                            ->all();

                        $payload['social_links'] = $cleanSocial === [] ? null : json_encode($cleanSocial);
                    }

                    if ($payload !== []) {
                        DB::table('company_event_brandings')->where('id', $row->id)->update($payload);
                    }
                }
            });
    }

    public function down(): void
    {
        if (! Schema::hasTable('company_event_brandings')) {
            return;
        }

        Schema::table('company_event_brandings', function (Blueprint $table) {
            if (Schema::hasColumn('company_event_brandings', 'theme_sections')) {
                $table->dropColumn('theme_sections');
            }
        });
    }
};
