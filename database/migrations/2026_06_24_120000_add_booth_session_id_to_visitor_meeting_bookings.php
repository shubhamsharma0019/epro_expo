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
            if (! Schema::hasColumn('visitor_meeting_bookings', 'booth_session_id')) {
                $table->foreignId('booth_session_id')
                    ->nullable()
                    ->after('company_meeting_id')
                    ->constrained('booth_sessions')
                    ->nullOnDelete();
                $table->index(['booth_session_id', 'visitor_id'], 'vmb_session_visitor_idx');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('visitor_meeting_bookings')) {
            return;
        }

        Schema::table('visitor_meeting_bookings', function (Blueprint $table) {
            if (Schema::hasColumn('visitor_meeting_bookings', 'booth_session_id')) {
                $table->dropForeign(['booth_session_id']);
                $table->dropIndex('vmb_session_visitor_idx');
                $table->dropColumn('booth_session_id');
            }
        });
    }
};
