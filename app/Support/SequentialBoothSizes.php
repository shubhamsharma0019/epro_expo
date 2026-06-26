<?php

namespace App\Support;

use App\Domain\Booth\Models\Booth;
use App\Domain\Booth\Models\BoothSize;
use App\Domain\Event\Models\Hall;
use Illuminate\Support\Collection;

class SequentialBoothSizes
{
    public const UNIT_AREA = 9;

    /** @var array<int, float> area (sq.m) => price (INR) */
    public const CATALOG = [
        9 => 499,
        18 => 1499,
        27 => 1299,
        36 => 1999,
        45 => 1799,
        54 => 2099,
        63 => 2299,
        72 => 2399,
        81 => 2499,
    ];

    /** @return array<int, int> */
    public static function dimensionsForArea(int $area): array
    {
        $units = max(1, (int) round($area / self::UNIT_AREA));

        return match ($units) {
            1 => [3, 3],
            2 => [6, 3],
            3 => [9, 3],
            4 => [6, 6],
            5 => [15, 3],
            6 => [9, 6],
            7 => [21, 3],
            8 => [12, 6],
            9 => [9, 9],
            default => [3 * $units, 3],
        };
    }

    public static function titleForArea(int $area): string
    {
        [$width, $height] = self::dimensionsForArea($area);

        return sprintf('%dm x %dm', $width, $height);
    }

    public static function isSequentialArea(float $area): bool
    {
        if ($area <= 0) {
            return false;
        }

        $units = $area / self::UNIT_AREA;

        return abs($units - round($units)) < 0.001;
    }

    /** @return Collection<int, BoothSize> */
    public static function activeOrdered(): Collection
    {
        $areas = array_keys(self::CATALOG);

        return BoothSize::query()
            ->where('status', 'active')
            ->whereIn('area', $areas)
            ->get()
            ->filter(fn (BoothSize $size) => self::isSequentialArea((float) $size->area))
            ->sortBy(fn (BoothSize $size) => (float) $size->area)
            ->groupBy(fn (BoothSize $size) => (int) round((float) $size->area))
            ->map(fn (Collection $sizes) => $sizes->first())
            ->sortBy(fn (BoothSize $size) => (float) $size->area)
            ->values();
    }

    /** @return Collection<int, BoothSize> */
    public static function availableForHall(Hall $hall): Collection
    {
        $hallBooths = Booth::query()
            ->where('hall_id', $hall->id)
            ->get();

        if ($hallBooths->isEmpty()) {
            return collect();
        }

        $bookedGroups = HallBookedBoothGroups::forHall($hall, $hallBooths);
        $blockedBoothIds = HallBookedBoothGroups::groupedBoothIds($bookedGroups);
        $minimumStartIndex = SequentialBoothAllocation::minimumStartIndexAfterBlocked($hallBooths, $blockedBoothIds);

        return self::activeOrdered()
            ->filter(function (BoothSize $size) use ($hallBooths, $blockedBoothIds, $minimumStartIndex) {
                $units = BoothFloorMap::unitsForSize($size);

                if ($units < 1) {
                    return false;
                }

                $block = SequentialBoothAllocation::firstContiguousBlock(
                    $hallBooths,
                    $units,
                    $blockedBoothIds,
                    null,
                    true,
                    $minimumStartIndex
                );

                return $block->count() >= $units;
            })
            ->values();
    }
}
