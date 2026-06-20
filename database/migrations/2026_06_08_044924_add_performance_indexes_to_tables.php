<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $tablesAndIndexes = [
            'booth_bookings' => ['company_id', 'exhibition_id', 'booking_status', 'payment_status', 'admin_status'],
            'visitors' => ['email', 'mobile', 'exhibition_id', 'payment_status', 'booking_id'],
            'companies' => ['email', 'status'],
            'meetings' => ['exhibitor_id', 'booking_id', 'status'],
            'visitor_meeting_bookings' => ['visitor_id', 'booth_booking_id', 'status'],
            'booths' => ['hall_id', 'status'],
            'halls' => ['exhibition_id'],
            'pavilions' => ['exhibition_id'],
        ];

        foreach ($tablesAndIndexes as $tableName => $columns) {
            if (Schema::hasTable($tableName)) {
                Schema::table($tableName, function (Blueprint $table) use ($tableName, $columns) {
                    foreach ($columns as $column) {
                        if (Schema::hasColumn($tableName, $column)) {
                            try {
                                $table->index($column);
                            } catch (\Exception $e) {
                                // Already indexed or other database error
                            }
                        }
                    }
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tablesAndIndexes = [
            'booth_bookings' => ['company_id', 'exhibition_id', 'booking_status', 'payment_status', 'admin_status'],
            'visitors' => ['email', 'mobile', 'exhibition_id', 'payment_status', 'booking_id'],
            'companies' => ['email', 'status'],
            'meetings' => ['exhibitor_id', 'booking_id', 'status'],
            'visitor_meeting_bookings' => ['visitor_id', 'booth_booking_id', 'status'],
            'booths' => ['hall_id', 'status'],
            'halls' => ['exhibition_id'],
            'pavilions' => ['exhibition_id'],
        ];

        foreach ($tablesAndIndexes as $tableName => $columns) {
            if (Schema::hasTable($tableName)) {
                Schema::table($tableName, function (Blueprint $table) use ($tableName, $columns) {
                    foreach ($columns as $column) {
                        if (Schema::hasColumn($tableName, $column)) {
                            try {
                                $table->dropIndex([$column]);
                            } catch (\Exception $e) {
                                // Ignore failure
                            }
                        }
                    }
                });
            }
        }
    }
};
