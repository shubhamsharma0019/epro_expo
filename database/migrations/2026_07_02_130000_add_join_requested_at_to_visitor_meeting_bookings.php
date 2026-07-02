<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('visitor_meeting_bookings') && ! Schema::hasColumn('visitor_meeting_bookings', 'join_requested_at')) {
            Schema::table('visitor_meeting_bookings', function (Blueprint $table) {
                $table->timestamp('join_requested_at')->nullable()->after('status');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('visitor_meeting_bookings') && Schema::hasColumn('visitor_meeting_bookings', 'join_requested_at')) {
            Schema::table('visitor_meeting_bookings', function (Blueprint $table) {
                $table->dropColumn('join_requested_at');
            });
        }
    }
};
