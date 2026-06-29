<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('visitor_checkins')) {
            Schema::table('visitor_checkins', function (Blueprint $table) {
                if (! Schema::hasColumn('visitor_checkins', 'device_type')) {
                    $table->string('device_type')->nullable()->after('checkin_type');
                }
                if (! Schema::hasColumn('visitor_checkins', 'device_name')) {
                    $table->string('device_name')->nullable()->after('device_type');
                }
                if (! Schema::hasColumn('visitor_checkins', 'user_agent')) {
                    $table->text('user_agent')->nullable()->after('device_name');
                }
                if (! Schema::hasColumn('visitor_checkins', 'ip_address')) {
                    $table->string('ip_address', 45)->nullable()->after('user_agent');
                }
            });
        }

        if (! Schema::hasTable('ticket_scan_logs')) {
            Schema::create('ticket_scan_logs', function (Blueprint $table) {
                $table->id();
                $table->foreignId('ticket_id')->constrained('tickets')->cascadeOnDelete();
                $table->foreignId('visitor_id')->nullable()->constrained('users')->nullOnDelete();
                $table->foreignId('company_event_id')->nullable()->constrained('company_events')->nullOnDelete();
                $table->string('qr_token');
                $table->string('action')->default('verify');
                $table->string('device_type')->nullable();
                $table->string('device_name')->nullable();
                $table->text('user_agent')->nullable();
                $table->string('ip_address', 45)->nullable();
                $table->timestamp('scanned_at');
                $table->timestamps();

                $table->index(['ticket_id', 'scanned_at']);
                $table->index(['company_event_id', 'scanned_at']);
                $table->index('qr_token');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('ticket_scan_logs');

        if (Schema::hasTable('visitor_checkins')) {
            Schema::table('visitor_checkins', function (Blueprint $table) {
                foreach (['ip_address', 'user_agent', 'device_name', 'device_type'] as $column) {
                    if (Schema::hasColumn('visitor_checkins', $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        }
    }
};
