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
            if (! Schema::hasColumn('exhibitions', 'booth_booking_days')) {
                $table->unsignedTinyInteger('booth_booking_days')->default(1)->after('end_date');
            }
        });

        DB::table('exhibitions')->orderBy('id')->each(function ($exhibition) {
            $days = 1;

            if ($exhibition->start_date && $exhibition->end_date) {
                $start = \Illuminate\Support\Carbon::parse($exhibition->start_date)->startOfDay();
                $end = \Illuminate\Support\Carbon::parse($exhibition->end_date)->startOfDay();
                $days = max($start->diffInDays($end) + 1, 1);
            }

            DB::table('exhibitions')
                ->where('id', $exhibition->id)
                ->update([
                    'booth_booking_days' => min((int) $days, 60),
                    'updated_at' => now(),
                ]);
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('exhibitions') || ! Schema::hasColumn('exhibitions', 'booth_booking_days')) {
            return;
        }

        Schema::table('exhibitions', function (Blueprint $table) {
            $table->dropColumn('booth_booking_days');
        });
    }
};
