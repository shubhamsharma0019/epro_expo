<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('visitor_meeting_bookings')) {
            return;
        }

        DB::table('visitor_meeting_bookings')
            ->where('status', 'completed')
            ->whereNull('completed_at')
            ->update(['completed_at' => now()]);

        Schema::table('visitor_meeting_bookings', function (Blueprint $table) {
            if (! $this->indexExists('visitor_meeting_bookings', 'visitor_meeting_bookings_visitor_id_status_index')) {
                $table->index(['visitor_id', 'status'], 'visitor_meeting_bookings_visitor_id_status_index');
            }
            if (! $this->indexExists('visitor_meeting_bookings', 'visitor_meeting_bookings_visitor_email_status_index')) {
                $table->index(['visitor_email', 'status'], 'visitor_meeting_bookings_visitor_email_status_index');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('visitor_meeting_bookings')) {
            return;
        }

        Schema::table('visitor_meeting_bookings', function (Blueprint $table) {
            if ($this->indexExists('visitor_meeting_bookings', 'visitor_meeting_bookings_visitor_id_status_index')) {
                $table->dropIndex('visitor_meeting_bookings_visitor_id_status_index');
            }
            if ($this->indexExists('visitor_meeting_bookings', 'visitor_meeting_bookings_visitor_email_status_index')) {
                $table->dropIndex('visitor_meeting_bookings_visitor_email_status_index');
            }
        });
    }

    private function indexExists(string $table, string $index): bool
    {
        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'sqlite') {
            $indexes = DB::select("PRAGMA index_list('{$table}')");

            return collect($indexes)->contains(fn ($row) => ($row->name ?? null) === $index);
        }

        $indexes = DB::select("SHOW INDEX FROM {$table} WHERE Key_name = ?", [$index]);

        return count($indexes) > 0;
    }
};
