<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /** @var list<string> */
    private array $reassignTables = [
        'booth_products',
        'booth_documents',
        'booth_catalogues',
        'booth_media',
        'booth_sessions',
        'booth_team_members',
        'booth_meeting_slots',
        'booth_views',
        'visitor_booth_hub_visits',
        'booking_services',
        'booth_booking_days',
        'products',
    ];

    /** @var list<string> */
    private array $uniqueChildTables = [
        'booth_profiles',
        'booth_brandings',
        'booth_setup_steps',
        'booth_meeting_availabilities',
        'booth_booking_summaries',
        'booth_publish_requests',
    ];

    public function up(): void
    {
        if (! Schema::hasTable('booth_bookings')) {
            return;
        }

        $bookings = DB::table('booth_bookings')
            ->where('payment_status', 'paid')
            ->whereIn('booking_status', ['confirmed', 'active'])
            ->whereIn('admin_status', ['pending', 'approved'])
            ->whereNotNull('company_id')
            ->whereNotNull('hall_id')
            ->orderBy('id')
            ->get();

        $groups = $bookings->groupBy(fn ($row) => implode(':', [
            (int) $row->hall_id,
            (int) $row->company_id,
            (int) ($row->exhibition_id ?? 0),
        ]));

        foreach ($groups as $group) {
            if ($group->count() <= 1) {
                continue;
            }

            $this->mergeBookingGroup($group);
        }
    }

    public function down(): void
    {
        // Merged booking consolidation is not reversed automatically.
    }

    private function mergeBookingGroup(Collection $group): void
    {
        $primary = $group->sortBy('id')->first();
        $duplicates = $group->where('id', '!=', $primary->id)->values();

        $boothIds = $group
            ->flatMap(fn ($booking) => $this->decodeBoothIds($booking))
            ->map(fn ($id) => (int) $id)
            ->filter()
            ->unique()
            ->sort()
            ->values();

        if ($boothIds->count() <= 1) {
            return;
        }

        $sortedPrimaryBoothId = $this->sortBoothIdsByNumber($boothIds)->first() ?: $primary->booth_id;

        DB::table('booth_bookings')
            ->where('id', $primary->id)
            ->update([
                'booth_id' => $sortedPrimaryBoothId,
                'selected_booth_ids' => json_encode($this->sortBoothIdsByNumber($boothIds)->values()->all()),
                'updated_at' => now(),
            ]);

        foreach ($duplicates as $duplicate) {
            $this->reassignChildren((int) $duplicate->id, (int) $primary->id);
            $this->dropUniqueChildren((int) $duplicate->id, (int) $primary->id);

            DB::table('booth_bookings')
                ->where('id', $duplicate->id)
                ->update([
                    'booking_status' => 'cancelled',
                    'admin_status' => 'rejected',
                    'notes' => trim(($duplicate->notes ?? '') . ' Merged into booking #' . $primary->id),
                    'updated_at' => now(),
                ]);
        }
    }

    /** @return list<int> */
    private function decodeBoothIds(object $booking): array
    {
        $selected = json_decode((string) ($booking->selected_booth_ids ?? '[]'), true);

        if (! is_array($selected)) {
            $selected = [];
        }

        return array_values(array_filter(array_merge($selected, [$booking->booth_id ?? null])));
    }

    /** @param  Collection<int, int>  $boothIds */
    private function sortBoothIdsByNumber(Collection $boothIds): Collection
    {
        if (! Schema::hasTable('booths')) {
            return $boothIds->sort()->values();
        }

        $numbers = DB::table('booths')
            ->whereIn('id', $boothIds->all())
            ->pluck('booth_number', 'id');

        return $boothIds
            ->sortBy(function (int $id) use ($numbers) {
                $number = (int) preg_replace('/\D+/', '', (string) ($numbers[$id] ?? $id));

                return sprintf('%08d-%08d', $number ?: $id, $id);
            })
            ->values();
    }

    private function reassignChildren(int $fromId, int $toId): void
    {
        foreach ($this->reassignTables as $table) {
            if (! Schema::hasTable($table) || ! Schema::hasColumn($table, 'booth_booking_id')) {
                continue;
            }

            DB::table($table)
                ->where('booth_booking_id', $fromId)
                ->update(['booth_booking_id' => $toId]);
        }
    }

    private function dropUniqueChildren(int $fromId, int $toId): void
    {
        foreach ($this->uniqueChildTables as $table) {
            if (! Schema::hasTable($table) || ! Schema::hasColumn($table, 'booth_booking_id')) {
                continue;
            }

            $duplicateRows = DB::table($table)->where('booth_booking_id', $fromId)->get();
            $primaryExists = DB::table($table)->where('booth_booking_id', $toId)->exists();

            foreach ($duplicateRows as $row) {
                if ($primaryExists) {
                    DB::table($table)->where('id', $row->id)->delete();
                } else {
                    DB::table($table)->where('id', $row->id)->update(['booth_booking_id' => $toId]);
                    $primaryExists = true;
                }
            }
        }
    }
};
