<?php

namespace App\Support;

use App\Domain\Booth\Models\Booth;
use App\Domain\Booth\Models\BoothSize;
use App\Domain\Event\Models\Hall;
use Illuminate\Support\Collection;

class HallBoothLayoutSync
{
    /** Maps legacy coordinates to the canonical sequential 10-per-row grid. */
    private const POSITION_ALIASES = [
        '12-12' => '10-10',
        '642-12' => '640-10',
        '12-109' => '10-105',
        '642-109' => '640-105',
        '12-206' => '10-200',
        '642-206' => '640-200',
        '12-303' => '10-295',
        '642-303' => '640-295',
        '18-28' => '10-10',
        '558-28' => '640-10',
        '18-128' => '10-105',
        '558-128' => '640-105',
        '18-228' => '10-200',
        '558-228' => '640-200',
        '18-328' => '10-295',
        '558-328' => '640-295',
        '642-303' => '640-295',
        '386-30' => '360-10',
        '446-30' => '430-10',
        '506-30' => '500-10',
        '640-28' => '640-10',
        '640-82' => '80-105',
        '640-136' => '150-105',
        '640-190' => '220-105',
        '640-244' => '290-105',
        '640-304' => '640-200',
        '18-82' => '10-105',
        '18-136' => '80-105',
        '18-190' => '150-105',
        '18-244' => '220-105',
        '18-304' => '10-200',
        '386-248' => '360-105',
        '446-248' => '430-105',
        '506-248' => '500-105',
        '120-122' => '10-200',
        '250-122' => '80-200',
        '380-122' => '150-200',
        '510-122' => '220-200',
    ];

    /** @return Collection<int, BoothSize> */
    public static function resolveBoothSizes(): Collection
    {
        $sizes = SequentialBoothSizes::activeOrdered();

        if ($sizes->isNotEmpty()) {
            return $sizes;
        }

        return BoothSize::query()
            ->where('status', 'active')
            ->orderBy('area')
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
