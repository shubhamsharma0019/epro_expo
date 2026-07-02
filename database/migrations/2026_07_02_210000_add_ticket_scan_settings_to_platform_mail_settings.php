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
            if (! Schema::hasColumn('platform_mail_settings', 'ticket_qr_base_url')) {
                $table->string('ticket_qr_base_url')->nullable()->after('mail_from_name');
            }

            if (! Schema::hasColumn('platform_mail_settings', 'ticket_scanner_username')) {
                $table->string('ticket_scanner_username')->nullable()->after('ticket_qr_base_url');
            }

            if (! Schema::hasColumn('platform_mail_settings', 'ticket_scanner_password')) {
                $table->text('ticket_scanner_password')->nullable()->after('ticket_scanner_username');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('platform_mail_settings')) {
            return;
        }

        Schema::table('platform_mail_settings', function (Blueprint $table) {
            foreach (['ticket_qr_base_url', 'ticket_scanner_username', 'ticket_scanner_password'] as $column) {
                if (Schema::hasColumn('platform_mail_settings', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
