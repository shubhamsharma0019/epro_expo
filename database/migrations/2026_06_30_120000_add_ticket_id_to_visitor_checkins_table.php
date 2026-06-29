<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('visitor_checkins') && ! Schema::hasColumn('visitor_checkins', 'ticket_id')) {
            Schema::table('visitor_checkins', function (Blueprint $table) {
                $table->foreignId('ticket_id')
                    ->nullable()
                    ->after('visitor_ticket_id')
                    ->constrained('tickets')
                    ->nullOnDelete();

                $table->index(['ticket_id', 'checked_in_at']);
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('visitor_checkins', 'ticket_id')) {
            Schema::table('visitor_checkins', function (Blueprint $table) {
                $table->dropConstrainedForeignId('ticket_id');
            });
        }
    }
};
