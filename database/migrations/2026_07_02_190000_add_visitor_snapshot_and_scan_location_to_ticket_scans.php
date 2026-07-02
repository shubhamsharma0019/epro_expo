<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        foreach (['ticket_scan_logs', 'visitor_checkins'] as $tableName) {
            if (! Schema::hasTable($tableName)) {
                continue;
            }

            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                if (! Schema::hasColumn($tableName, 'visitor_name')) {
                    $table->string('visitor_name')->nullable()->after('company_event_id');
                }
                if (! Schema::hasColumn($tableName, 'visitor_email')) {
                    $table->string('visitor_email')->nullable()->after('visitor_name');
                }
                if (! Schema::hasColumn($tableName, 'visitor_phone')) {
                    $table->string('visitor_phone', 30)->nullable()->after('visitor_email');
                }
                if (! Schema::hasColumn($tableName, 'scan_location')) {
                    $after = $tableName === 'ticket_scan_logs' ? 'scanner_username' : 'scanner_username';
                    $table->string('scan_location')->nullable()->after($after);
                }
            });
        }

        if (Schema::hasTable('visitor_checkins') && Schema::hasColumn('visitor_checkins', 'checkin_date')) {
            DB::table('visitor_checkins')
                ->whereNull('checkin_date')
                ->whereNotNull('checked_in_at')
                ->orderBy('id')
                ->chunkById(200, function ($rows) {
                    foreach ($rows as $row) {
                        DB::table('visitor_checkins')
                            ->where('id', $row->id)
                            ->update(['checkin_date' => date('Y-m-d', strtotime($row->checked_in_at))]);
                    }
                });
        }
    }

    public function down(): void
    {
        foreach (['ticket_scan_logs', 'visitor_checkins'] as $tableName) {
            if (! Schema::hasTable($tableName)) {
                continue;
            }

            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                foreach (['scan_location', 'visitor_phone', 'visitor_email', 'visitor_name'] as $column) {
                    if (Schema::hasColumn($tableName, $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        }
    }
};
