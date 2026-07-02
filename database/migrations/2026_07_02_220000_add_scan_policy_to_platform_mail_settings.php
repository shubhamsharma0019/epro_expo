<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('platform_mail_settings')) {
            return;
        }

        Schema::table('platform_mail_settings', function (Blueprint $table) {
            if (! Schema::hasColumn('platform_mail_settings', 'scanner_login_required')) {
                $table->boolean('scanner_login_required')->default(false)->after('ticket_scanner_password');
            }

            if (! Schema::hasColumn('platform_mail_settings', 'auto_checkin_on_scan')) {
                $table->boolean('auto_checkin_on_scan')->default(true)->after('scanner_login_required');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('platform_mail_settings')) {
            return;
        }

        Schema::table('platform_mail_settings', function (Blueprint $table) {
            foreach (['scanner_login_required', 'auto_checkin_on_scan'] as $column) {
                if (Schema::hasColumn('platform_mail_settings', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
