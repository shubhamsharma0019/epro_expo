<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (! DB::getSchemaBuilder()->hasTable('halls')) {
            return;
        }

        DB::table('halls')
            ->where('slug', 'hall-a')
            ->update(['total_booths' => 48]);
    }

    public function down(): void
    {
        // Data repair migration — no safe rollback.
    }
};
