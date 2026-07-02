<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('company_meetings')) {
            return;
        }

        Schema::table('company_meetings', function (Blueprint $table) {
            if (! Schema::hasColumn('company_meetings', 'host_email')) {
                $table->string('host_email', 255)->nullable()->after('zoom_start_url');
            }
            if (! Schema::hasColumn('company_meetings', 'attendee_email')) {
                $table->string('attendee_email', 255)->nullable()->after('host_email');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('company_meetings')) {
            return;
        }

        Schema::table('company_meetings', function (Blueprint $table) {
            foreach (['attendee_email', 'host_email'] as $column) {
                if (Schema::hasColumn('company_meetings', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
