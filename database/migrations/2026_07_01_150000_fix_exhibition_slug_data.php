<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (! DB::getSchemaBuilder()->hasTable('exhibitions')) {
            return;
        }

        // Avoid unique-slug conflicts while reassigning corrupted rows.
        $temps = [
            1 => 'exh-fix-temp-1',
            2 => 'exh-fix-temp-2',
            3 => 'exh-fix-temp-3',
            4 => 'exh-fix-temp-4',
        ];

        foreach ($temps as $id => $slug) {
            DB::table('exhibitions')->where('id', $id)->update(['slug' => $slug]);
        }

        DB::table('exhibitions')->where('id', 1)->update([
            'name' => 'Global Tech Summit 2024',
            'title' => 'Global Tech Expo 2024',
            'slug' => 'global-tech-expo-2024',
            'location' => 'Jio World Convention Centre',
            'venue' => 'Jio World Convention Centre, Mumbai, India',
            'start_date' => '2026-06-12',
            'end_date' => '2026-06-14',
            'status' => 'active',
        ]);

        DB::table('exhibitions')->where('id', 2)->update([
            'name' => 'Future of AI Expo',
            'title' => 'Future of AI Expo',
            'slug' => 'future-of-ai-expo',
            'location' => 'Bengaluru Convention Centre',
            'venue' => 'Bengaluru Convention Centre, Bengaluru, India',
            'start_date' => '2026-06-10',
            'end_date' => '2026-06-12',
            'status' => 'active',
        ]);

        DB::table('exhibitions')->where('id', 3)->update([
            'name' => 'Sustainability World Expo',
            'title' => 'Sustainability World Expo',
            'slug' => 'sustainability-world-expo',
            'location' => 'Pune International Exhibition Centre',
            'venue' => 'Pune International Exhibition Centre, Pune, India',
            'start_date' => '2026-08-08',
            'end_date' => '2026-08-10',
            'status' => 'active',
        ]);

        // Duplicate row — keep for FK safety but hide from visitor browse.
        DB::table('exhibitions')->where('id', 4)->update([
            'slug' => 'global-tech-expo-2024-archived',
            'status' => 'archived',
        ]);
    }

    public function down(): void
    {
        // Data repair migration — no safe rollback.
    }
};
