<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('booth_bookings')) {
            return;
        }

        Schema::table('booth_bookings', function (Blueprint $table) {
            try {
                $table->index('booth_id', 'booth_bookings_booth_id_index');
            } catch (Throwable) {
                // The supporting non-unique index may already exist.
            }

            try {
                $table->dropUnique(['booth_id']);
            } catch (Throwable) {
                // Fresh or manually adjusted databases may not have this index.
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('booth_bookings')) {
            return;
        }

        Schema::table('booth_bookings', function (Blueprint $table) {
            try {
                $table->unique('booth_id');
            } catch (Throwable) {
                // Keep rollback tolerant across database engines.
            }
        });
    }
};
