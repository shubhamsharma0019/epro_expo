<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('exhibitions')) {
            return;
        }

        Schema::table('exhibitions', function (Blueprint $table) {
            if (! Schema::hasColumn('exhibitions', 'duration_days')) {
                $table->unsignedTinyInteger('duration_days')->nullable()->after('end_date');
            }
        });

        DB::table('exhibitions')->orderBy('id')->each(function ($exhibition) {
            $days = (int) ($exhibition->duration_days ?? 0);

            if ($days <= 0 && isset($exhibition->booth_booking_days) && (int) $exhibition->booth_booking_days > 0) {
                $days = (int) $exhibition->booth_booking_days;
            }

            if ($days <= 0 && $exhibition->start_date && $exhibition->end_date) {
                $start = \Illuminate\Support\Carbon::parse($exhibition->start_date)->startOfDay();
                $end = \Illuminate\Support\Carbon::parse($exhibition->end_date)->startOfDay();
                $days = max($start->diffInDays($end) + 1, 1);
            }

            if ($days <= 0) {
                $days = 1;
            }

            $days = min($days, 60);

            DB::table('exhibitions')->where('id', $exhibition->id)->update([
                'duration_days' => $days,
                'booth_booking_days' => $days,
                'updated_at' => now(),
            ]);
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('exhibitions') || ! Schema::hasColumn('exhibitions', 'duration_days')) {
            return;
        }

        Schema::table('exhibitions', function (Blueprint $table) {
            $table->dropColumn('duration_days');
        });
    }
};
