<?php

use App\Domain\Booth\Models\BoothBooking;
use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private const SEED_MARKER = 'seed:dashboard-performance-30d';

    public function up(): void
    {
        if (! Schema::hasTable('booth_views') || ! Schema::hasTable('booth_bookings')) {
            return;
        }

        $bookings = BoothBooking::query()
            ->with('boothProfile')
            ->where('payment_status', 'paid')
            ->whereIn('booking_status', ['confirmed', 'active'])
            ->where('admin_status', 'approved')
            ->whereNotNull('company_id')
            ->get()
            ->unique('company_id');

        if ($bookings->isEmpty()) {
            return;
        }

        $today = Carbon::today();
        $start = $today->copy()->subDays(29)->startOfDay();

        foreach ($bookings as $booking) {
            $existingDays = (int) DB::table('booth_views')
                ->where('company_id', $booking->company_id)
                ->where(function ($query) use ($start) {
                    $query->where('viewed_at', '>=', $start)
                        ->orWhere(function ($fallback) use ($start) {
                            $fallback->whereNull('viewed_at')
                                ->where('created_at', '>=', $start);
                        });
                })
                ->selectRaw('COUNT(DISTINCT DATE(COALESCE(viewed_at, created_at))) as day_count')
                ->value('day_count');

            if ($existingDays >= 25) {
                continue;
            }

            DB::table('booth_views')
                ->where('company_id', $booking->company_id)
                ->where('user_agent', self::SEED_MARKER)
                ->delete();

            $rows = [];
            $now = now();

            for ($offset = 0; $offset < 30; $offset++) {
                $day = $start->copy()->addDays($offset);
                $dailyViews = match ($offset % 7) {
                    0 => 2,
                    1 => 3,
                    2 => 1,
                    3 => 4,
                    4 => 2,
                    5 => 5,
                    default => 3,
                };

                for ($viewIndex = 0; $viewIndex < $dailyViews; $viewIndex++) {
                    $viewedAt = $day->copy()->setTime(9 + ($viewIndex % 8), ($viewIndex * 11) % 60, 0);
                    $rows[] = [
                        'company_id' => $booking->company_id,
                        'booth_profile_id' => $booking->boothProfile?->id,
                        'booth_booking_id' => Schema::hasColumn('booth_views', 'booth_booking_id') ? $booking->id : null,
                        'visitor_id' => null,
                        'ip_address' => '127.0.0.1',
                        'user_agent' => self::SEED_MARKER,
                        'viewed_at' => $viewedAt,
                        'created_at' => $viewedAt,
                        'updated_at' => $viewedAt,
                    ];
                }
            }

            foreach (array_chunk($rows, 100) as $chunk) {
                DB::table('booth_views')->insert($chunk);
            }
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('booth_views')) {
            return;
        }

        DB::table('booth_views')
            ->where('user_agent', self::SEED_MARKER)
            ->delete();
    }
};
