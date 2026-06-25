<?php

namespace App\Support;

use App\Domain\Booth\Models\Booth;
use App\Domain\Booth\Models\BoothSize;
use App\Domain\Event\Models\Hall;
use Illuminate\Support\Collection;

class HallBoothLayoutSync
{
    /** Maps legacy seeded coordinates to the canonical VisitorFloorMap grid. */
    private const POSITION_ALIASES = [
        '386-30' => '378-30',
        '446-30' => '438-30',
        '506-30' => '498-30',
        '386-248' => '378-248',
        '446-248' => '438-248',
        '506-248' => '498-248',
        '386-306' => '378-306',
        '446-306' => '438-306',
        '506-306' => '498-306',
        '120-122' => '122-122',
        '250-122' => '252-122',
        '380-122' => '382-122',
        '510-122' => '512-122',
        // Legacy perimeter layout → sequential row layout
        '640-28' => '558-30',
        '640-82' => '18-248',
        '640-136' => '78-248',
        '640-190' => '138-248',
        '640-244' => '198-248',
        '18-82' => '558-190',
        '18-136' => '18-190',
        '18-190' => '78-190',
        '18-244' => '138-190',
    ];

    /** @return Collection<int, BoothSize> */
    public static function resolveBoothSizes(): Collection
    {
        $sizes = BoothSize::query()
            ->whereIn('title', ['3m x 3m', '3m x 4m', '6m x 3m', '6m x 6m', '9m x 9m'])
            ->orderBy('id')
            ->get()
            ->unique('title')
            ->values();

        if ($sizes->isNotEmpty()) {
            return $sizes;
        }

        return BoothSize::query()
            ->where('status', 'active')
            ->orderBy('id')
            ->get()
            ->unique('title')
            ->values();
    }

    public static function sizeIndexForLayoutPosition(int $positionIndex): int
    {
        return match ($positionIndex) {
            4 => 1,
            36 => 2,
            37 => 3,
            38 => 4,
            default => 0,
        };
    }

    public static function canonicalPositionKey(int $x, int $y): string
    {
        $key = $x . '-' . $y;

        return self::POSITION_ALIASES[$key] ?? $key;
    }

    /** @param Collection<int, BoothSize> $boothSizes */
    public static function sync(Hall $hall, Collection $boothSizes): int
    {
        $boothLayouts = VisitorFloorMap::layoutTemplate();

        if ($boothSizes->isEmpty()) {
            return 0;
        }

        $existingBooths = Booth::query()
            ->where('hall_id', $hall->id)
            ->with('boothBooking')
            ->get();

        $existingByPosition = $existingBooths->keyBy(function (Booth $booth) {
            return self::canonicalPositionKey((int) $booth->position_x, (int) $booth->position_y);
        });

        $keptBoothIds = [];
        $pendingUpdates = [];

        foreach ($boothLayouts as $positionIndex => $layout) {
            $x = (int) $layout['x'];
            $y = (int) $layout['y'];
            $defaultStatus = $layout['status'];
            $boothNumber = 'B' . str_pad((string) ($positionIndex + 1), 2, '0', STR_PAD_LEFT);
            $boothSize = $boothSizes[self::sizeIndexForLayoutPosition($positionIndex)] ?? $boothSizes[0];
            $existing = $existingByPosition->get("{$x}-{$y}");

            if ($existing) {
                $existing->update(['booth_number' => 'TMP' . str_pad((string) $positionIndex, 2, '0', STR_PAD_LEFT)]);
                $pendingUpdates[] = [
                    'booth' => $existing->fresh(),
                    'booth_number' => $boothNumber,
                    'x' => $x,
                    'y' => $y,
                    'defaultStatus' => $defaultStatus,
                    'boothSize' => $boothSize,
                ];
                $keptBoothIds[] = $existing->id;

                continue;
            }

            $created = Booth::updateOrCreate(
                [
                    'hall_id' => $hall->id,
                    'booth_number' => $boothNumber,
                ],
                [
                    'booth_size_id' => $boothSize->id,
                    'position_x' => $x,
                    'position_y' => $y,
                    'price' => $boothSize->price,
                    'status' => $defaultStatus,
                ]
            );

            $keptBoothIds[] = $created->id;
        }

        foreach ($pendingUpdates as $update) {
            $booth = $update['booth'];
            $payload = [
                'booth_number' => $update['booth_number'],
                'position_x' => $update['x'],
                'position_y' => $update['y'],
            ];

            if (! $booth->boothBooking) {
                $payload['booth_size_id'] = $booth->booth_size_id ?: $update['boothSize']->id;
                $payload['price'] = $booth->price > 0 ? $booth->price : $update['boothSize']->price;
                $payload['status'] = in_array($booth->status, ['booked', 'reserved'], true)
                    ? $booth->status
                    : $update['defaultStatus'];
            }

            $booth->update($payload);
        }

        Booth::query()
            ->where('hall_id', $hall->id)
            ->whereNotIn('id', $keptBoothIds)
            ->whereDoesntHave('boothBooking')
            ->delete();

        $layoutCount = count($boothLayouts);
        $hall->update(['total_booths' => $layoutCount]);

        return $layoutCount;
    }
}
