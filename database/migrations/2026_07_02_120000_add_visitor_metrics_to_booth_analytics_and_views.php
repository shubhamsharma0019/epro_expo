<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('booth_views')) {
            Schema::table('booth_views', function (Blueprint $table) {
                if (! Schema::hasColumn('booth_views', 'booth_booking_id')) {
                    $table->foreignId('booth_booking_id')->nullable()->after('booth_profile_id')->constrained()->nullOnDelete();
                }
                if (! Schema::hasColumn('booth_views', 'time_spent_seconds')) {
                    $table->unsignedInteger('time_spent_seconds')->nullable()->after('viewed_at');
                }
            });
        }

        if (Schema::hasTable('booth_analytics')) {
            Schema::table('booth_analytics', function (Blueprint $table) {
                if (! Schema::hasColumn('booth_analytics', 'unique_visitors')) {
                    $table->unsignedInteger('unique_visitors')->default(0)->after('booth_views');
                }
                if (! Schema::hasColumn('booth_analytics', 'returning_visitors')) {
                    $table->unsignedInteger('returning_visitors')->default(0)->after('unique_visitors');
                }
                if (! Schema::hasColumn('booth_analytics', 'avg_time_spent_seconds')) {
                    $table->unsignedInteger('avg_time_spent_seconds')->default(0)->after('returning_visitors');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('booth_views')) {
            Schema::table('booth_views', function (Blueprint $table) {
                if (Schema::hasColumn('booth_views', 'booth_booking_id')) {
                    $table->dropConstrainedForeignId('booth_booking_id');
                }
                if (Schema::hasColumn('booth_views', 'time_spent_seconds')) {
                    $table->dropColumn('time_spent_seconds');
                }
            });
        }

        if (Schema::hasTable('booth_analytics')) {
            Schema::table('booth_analytics', function (Blueprint $table) {
                foreach (['unique_visitors', 'returning_visitors', 'avg_time_spent_seconds'] as $column) {
                    if (Schema::hasColumn('booth_analytics', $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        }
    }
};
