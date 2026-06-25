<?php

namespace App\Support;

use App\Domain\Booth\Models\Booth;
use App\Domain\Booth\Models\BoothBooking;
use App\Domain\Event\Models\Exhibition;
use App\Domain\Event\Models\Hall;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseProjectSync
{
    public static function run(): array
    {
        $summary = [];

        $summary['hall_booth_counts'] = self::syncHallBoothCounts();
        $summary['pavilion_booth_counts'] = self::syncPavilionBoothCounts();
        $summary['exhibition_company_counts'] = self::syncExhibitionCompanyCounts();
        $summary['booth_booking_statuses'] = self::syncBoothBookingStatuses();

        return $summary;
    }

    public static function syncHallBoothCounts(): int
    {
        if (! Schema::hasTable('halls') || ! Schema::hasTable('booths')) {
            return 0;
        }

        $updated = 0;

        foreach (Hall::query()->select('id')->cursor() as $hall) {
            $count = (int) Booth::query()->where('hall_id', $hall->id)->count();

            DB::table('halls')->where('id', $hall->id)->update([
                'total_booths' => $count,
                'updated_at' => now(),
            ]);

            $updated++;
        }

        return $updated;
    }

    public static function syncPavilionBoothCounts(): int
    {
        if (! Schema::hasTable('pavilions') || ! Schema::hasTable('halls')) {
            return 0;
        }

        $updated = 0;

        $pavilionIds = DB::table('pavilions')->pluck('id');

        foreach ($pavilionIds as $pavilionId) {
            $count = (int) DB::table('halls')
                ->where('pavilion_id', $pavilionId)
                ->sum('total_booths');

            if (! Schema::hasColumn('pavilions', 'total_booths')) {
                continue;
            }

            DB::table('pavilions')->where('id', $pavilionId)->update([
                'total_booths' => $count,
                'updated_at' => now(),
            ]);

            $updated++;
        }

        return $updated;
    }

    public static function syncExhibitionCompanyCounts(): int
    {
        if (! Schema::hasTable('exhibitions') || ! Schema::hasTable('booth_bookings')) {
            return 0;
        }

        if (! Schema::hasColumn('exhibitions', 'companies_count')) {
            return 0;
        }

        $updated = 0;

        foreach (Exhibition::query()->select('id')->cursor() as $exhibition) {
            $count = (int) BoothBooking::query()
                ->where('exhibition_id', $exhibition->id)
                ->where('payment_status', 'paid')
                ->whereIn('booking_status', ['confirmed', 'active'])
                ->whereIn('admin_status', ['pending', 'approved'])
                ->distinct('company_id')
                ->count('company_id');

            DB::table('exhibitions')->where('id', $exhibition->id)->update([
                'companies_count' => $count,
                'updated_at' => now(),
            ]);

            $updated++;
        }

        return $updated;
    }

    public static function syncBoothBookingStatuses(): int
    {
        if (! Schema::hasTable('booths') || ! Schema::hasTable('booth_bookings')) {
            return 0;
        }

        $occupiedBoothIds = BoothBooking::query()
            ->where('payment_status', 'paid')
            ->whereIn('booking_status', ['confirmed', 'active'])
            ->whereIn('admin_status', ['pending', 'approved'])
            ->get()
            ->flatMap(function (BoothBooking $booking) {
                return collect($booking->selected_booth_ids ?: [$booking->booth_id])
                    ->push($booking->booth_id)
                    ->filter()
                    ->map(fn ($id) => (int) $id);
            })
            ->unique()
            ->values()
            ->all();

        $booked = 0;

        if ($occupiedBoothIds !== []) {
            $booked = Booth::query()
                ->whereIn('id', $occupiedBoothIds)
                ->where('status', 'available')
                ->update(['status' => 'booked', 'updated_at' => now()]);
        }

        $released = Booth::query()
            ->when($occupiedBoothIds !== [], fn ($query) => $query->whereNotIn('id', $occupiedBoothIds))
            ->where('status', 'booked')
            ->whereDoesntHave('boothBooking', function ($query) {
                $query->where('payment_status', 'paid')
                    ->whereIn('booking_status', ['confirmed', 'active'])
                    ->whereIn('admin_status', ['pending', 'approved']);
            })
            ->update(['status' => 'available', 'updated_at' => now()]);

        return (int) $booked + (int) $released;
    }
}
