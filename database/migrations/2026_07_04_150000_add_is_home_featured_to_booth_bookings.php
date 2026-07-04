<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('booth_bookings')) {
            return;
        }

        if (! Schema::hasColumn('booth_bookings', 'is_home_featured')) {
            Schema::table('booth_bookings', function (Blueprint $table) {
                $table->boolean('is_home_featured')->default(false)->after('booth_setup_status');
            });
        }

        $this->seedFeaturedHomeBooth();
    }

    public function down(): void
    {
        if (Schema::hasTable('booth_bookings') && Schema::hasColumn('booth_bookings', 'is_home_featured')) {
            Schema::table('booth_bookings', function (Blueprint $table) {
                $table->dropColumn('is_home_featured');
            });
        }
    }

    private function seedFeaturedHomeBooth(): void
    {
        if (! Schema::hasTable('booth_profiles')) {
            return;
        }

        $bookingId = DB::table('booth_profiles')
            ->where(function ($query) {
                $query->where('company_name', 'like', '%Shubham Enterprises%')
                    ->orWhere('company_name', 'like', '%Shubham%');
            })
            ->orderByDesc('id')
            ->value('booth_booking_id');

        if (! $bookingId) {
            $bookingId = DB::table('booth_bookings')
                ->whereIn('booth_setup_status', ['published', 'approved', 'live'])
                ->where('payment_status', 'paid')
                ->orderByDesc('id')
                ->value('id');
        }

        if (! $bookingId) {
            return;
        }

        DB::table('booth_bookings')->update(['is_home_featured' => false]);
        DB::table('booth_bookings')->where('id', $bookingId)->update([
            'is_home_featured' => true,
            'updated_at' => now(),
        ]);
    }
};
