<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('visitor_meeting_bookings')) {
            Schema::table('visitor_meeting_bookings', function (Blueprint $table) {
                if (! Schema::hasColumn('visitor_meeting_bookings', 'host_joined_at')) {
                    $table->timestamp('host_joined_at')->nullable()->after('join_requested_at');
                }
                if (! Schema::hasColumn('visitor_meeting_bookings', 'visitor_joined_at')) {
                    $table->timestamp('visitor_joined_at')->nullable()->after('host_joined_at');
                }
            });
        }

        if (Schema::hasTable('enquiries')) {
            Schema::table('enquiries', function (Blueprint $table) {
                if (! Schema::hasColumn('enquiries', 'visitor_meeting_booking_id')) {
                    $table->foreignId('visitor_meeting_booking_id')
                        ->nullable()
                        ->after('visitor_id')
                        ->constrained('visitor_meeting_bookings')
                        ->nullOnDelete();
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('enquiries') && Schema::hasColumn('enquiries', 'visitor_meeting_booking_id')) {
            Schema::table('enquiries', function (Blueprint $table) {
                $table->dropConstrainedForeignId('visitor_meeting_booking_id');
            });
        }

        if (Schema::hasTable('visitor_meeting_bookings')) {
            Schema::table('visitor_meeting_bookings', function (Blueprint $table) {
                foreach (['visitor_joined_at', 'host_joined_at'] as $column) {
                    if (Schema::hasColumn('visitor_meeting_bookings', $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        }
    }
};
