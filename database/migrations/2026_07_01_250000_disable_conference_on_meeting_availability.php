<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('booth_meeting_availabilities') && Schema::hasColumn('booth_meeting_availabilities', 'allow_conference')) {
            DB::table('booth_meeting_availabilities')->update([
                'allow_conference' => false,
                'updated_at' => now(),
            ]);
        }

        if (Schema::hasTable('booth_meeting_slots') && Schema::hasColumn('booth_meeting_slots', 'allow_conference')) {
            DB::table('booth_meeting_slots')->update([
                'allow_conference' => false,
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        // Data-only cleanup migration.
    }
};
