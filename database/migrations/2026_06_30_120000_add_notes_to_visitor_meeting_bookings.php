<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('visitor_meeting_bookings')) {
            return;
        }

        Schema::table('visitor_meeting_bookings', function (Blueprint $table) {
            if (! Schema::hasColumn('visitor_meeting_bookings', 'notes')) {
                $table->text('notes')->nullable()->after('message');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('visitor_meeting_bookings')) {
            return;
        }

        Schema::table('visitor_meeting_bookings', function (Blueprint $table) {
            if (Schema::hasColumn('visitor_meeting_bookings', 'notes')) {
                $table->dropColumn('notes');
            }
        });
    }
};
