<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('booth_sessions') && ! Schema::hasColumn('booth_sessions', 'company_meeting_id')) {
            Schema::table('booth_sessions', function (Blueprint $table) {
                $table->foreignId('company_meeting_id')
                    ->nullable()
                    ->after('booth_booking_id')
                    ->constrained('company_meetings')
                    ->nullOnDelete();
                $table->timestamp('pass_holders_notified_at')->nullable()->after('status');
            });
        }

        if (Schema::hasTable('company_meetings') && ! Schema::hasColumn('company_meetings', 'booth_session_id')) {
            Schema::table('company_meetings', function (Blueprint $table) {
                $table->foreignId('booth_session_id')
                    ->nullable()
                    ->after('company_id')
                    ->constrained('booth_sessions')
                    ->nullOnDelete();
                $table->index(['booth_session_id', 'company_id'], 'cm_session_company_idx');
            });
        }

        if (Schema::hasTable('meeting_notifications') && ! Schema::hasColumn('meeting_notifications', 'booth_session_id')) {
            Schema::table('meeting_notifications', function (Blueprint $table) {
                $table->foreignId('booth_session_id')
                    ->nullable()
                    ->after('visitor_meeting_booking_id')
                    ->constrained('booth_sessions')
                    ->nullOnDelete();
                $table->index(['visitor_id', 'booth_session_id', 'type'], 'mn_visitor_session_type_idx');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('meeting_notifications') && Schema::hasColumn('meeting_notifications', 'booth_session_id')) {
            Schema::table('meeting_notifications', function (Blueprint $table) {
                $table->dropForeign(['booth_session_id']);
                $table->dropColumn('booth_session_id');
            });
        }

        if (Schema::hasTable('company_meetings') && Schema::hasColumn('company_meetings', 'booth_session_id')) {
            Schema::table('company_meetings', function (Blueprint $table) {
                $table->dropForeign(['booth_session_id']);
                $table->dropColumn('booth_session_id');
            });
        }

        if (Schema::hasTable('booth_sessions') && Schema::hasColumn('booth_sessions', 'company_meeting_id')) {
            Schema::table('booth_sessions', function (Blueprint $table) {
                $table->dropForeign(['company_meeting_id']);
                $table->dropColumn(['company_meeting_id', 'pass_holders_notified_at']);
            });
        }
    }
};
