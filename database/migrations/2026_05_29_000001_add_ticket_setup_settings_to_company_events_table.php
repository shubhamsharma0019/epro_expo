<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('company_events', function (Blueprint $table) {
            $table->json('ticket_attendee_fields')->nullable()->after('capacity');
            $table->boolean('allow_group_registrations')->default(true)->after('ticket_attendee_fields');
            $table->boolean('show_remaining_ticket_count')->default(true)->after('allow_group_registrations');
            $table->boolean('enable_waiting_list')->default(false)->after('show_remaining_ticket_count');
        });
    }

    public function down(): void
    {
        Schema::table('company_events', function (Blueprint $table) {
            $table->dropColumn([
                'ticket_attendee_fields',
                'allow_group_registrations',
                'show_remaining_ticket_count',
                'enable_waiting_list',
            ]);
        });
    }
};
