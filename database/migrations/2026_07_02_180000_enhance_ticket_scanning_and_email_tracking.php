<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('visitor_tickets') && ! Schema::hasColumn('visitor_tickets', 'email_sent_at')) {
            Schema::table('visitor_tickets', function (Blueprint $table) {
                $table->timestamp('email_sent_at')->nullable()->after('qr_code_path');
            });
        }

        if (Schema::hasTable('visitor_checkins')) {
            Schema::table('visitor_checkins', function (Blueprint $table) {
                if (! Schema::hasColumn('visitor_checkins', 'scanner_username')) {
                    $table->string('scanner_username', 100)->nullable()->after('verified_by');
                }
                if (! Schema::hasColumn('visitor_checkins', 'checkin_date')) {
                    $table->date('checkin_date')->nullable()->after('checked_in_at');
                }
            });
        }

        if (Schema::hasTable('ticket_scan_logs') && ! Schema::hasColumn('ticket_scan_logs', 'scanner_username')) {
            Schema::table('ticket_scan_logs', function (Blueprint $table) {
                $table->string('scanner_username', 100)->nullable()->after('action');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('ticket_scan_logs') && Schema::hasColumn('ticket_scan_logs', 'scanner_username')) {
            Schema::table('ticket_scan_logs', function (Blueprint $table) {
                $table->dropColumn('scanner_username');
            });
        }

        if (Schema::hasTable('visitor_checkins')) {
            Schema::table('visitor_checkins', function (Blueprint $table) {
                foreach (['checkin_date', 'scanner_username'] as $column) {
                    if (Schema::hasColumn('visitor_checkins', $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        }

        if (Schema::hasTable('visitor_tickets') && Schema::hasColumn('visitor_tickets', 'email_sent_at')) {
            Schema::table('visitor_tickets', function (Blueprint $table) {
                $table->dropColumn('email_sent_at');
            });
        }
    }
};
