<?php

namespace App\Support;

use App\Domain\Booth\Models\Booth;
use Illuminate\Support\Collection;

class SequentialBoothAllocation
{
    private const MAX_LAYOUT_INDEX = 40;

    /** @return Collection<int, Booth> */
    public static function boothsByLayoutIndex(Collection $hallBooths): Collection
    {
        return $hallBooths
            ->mapWithKeys(function (Booth $booth) {
                $index = VisitorFloorMap::layoutIndexForBoothNumber((string) $booth->booth_number);

                return $index === null ? [] : [$index => $booth];
            });
    }

    /** @param  array<int>  $blockedBoothIds */
    public static function contiguousFromIndex(
        Collection $boothsByIndex,
        int $startIndex,
        int $requiredSpaces,
        array $blockedBoothIds = [],
        bool $sameRowOnly = false,
        bool $requireAvailable = true,
    ): Collection {
        if ($requiredSpaces < 1 || $startIndex < 0 || $startIndex >= self::MAX_LAYOUT_INDEX) {
            return collect();
        }

        $selected = collect();
        $row = intdiv($startIndex, 10);

        for ($offset = 0; $offset < $requiredSpaces; $offset++) {
            $index = $startIndex + $offset;

            if ($index >= self::MAX_LAYOUT_INDEX) {
                break;
            }

            if ($sameRowOnly && intdiv($index, 10) !== $row) {
                break;
            }

            /** @var Booth|null $booth */
            $booth = $boothsByIndex->get($index);

            if (! $booth) {
                break;
            }

            if ($requireAvailable && $booth->status !== 'available') {
                break;
            }

            if (in_array((int) $booth->id, $blockedBoothIds, true)) {
                break;
            }

            $selected->push($booth);
        }

        return $selected->values();
    }

    public static function maxLayoutIndexForBoothIds(Collection $hallBooths, array $boothIds): ?int
    {
        $max = null;

        foreach ($boothIds as $boothId) {
            $booth = $hallBooths->firstWhere('id', (int) $boothId);

            if (! $booth) {
                continue;
            }

            $index = VisitorFloorMap::layoutIndexForBoothNumber((string) $booth->booth_number);

            if ($index === null) {
                continue;
            }

            $max = $max === null ? $index : max($max, $index);
        }

        return $max;
    }

    /** @param  array<int>  $blockedBoothIds */
    public static function minimumStartIndexAfterBlocked(Collection $hallBooths, array $blockedBoothIds): int
    {
        $maxIndex = self::maxLayoutIndexForBoothIds($hallBooths, $blockedBoothIds);

        return $maxIndex === null ? 0 : $maxIndex + 1;
    }

    /**
     * @param  array<int>  $blockedBoothIds
     * @return Collection<int, Booth>
     */
    public static function firstContiguousBlock(
        Collection $hallBooths,
        int $requiredSpaces,
        array $blockedBoothIds = [],
        ?int $preferredStartIndex = null,
        bool $requireAvailable = true,
        ?int $minimumStartIndex = null,
    ): Collection {
        if ($requiredSpaces < 1) {
            return collect();
        }

        $boothsByIndex = self::boothsByLayoutIndex($hallBooths);
        $maxStart = self::MAX_LAYOUT_INDEX - $requiredSpaces;
        $startAt = max(0, $minimumStartIndex ?? 0);
        $startCandidates = collect(range($startAt, $maxStart));

        if ($preferredStartIndex !== null) {
            $startCandidates = $startCandidates
                ->sortBy(fn (int $start) => abs($start - $preferredStartIndex))
                ->values();
        }

        foreach ($startCandidates as $start) {
            $block = self::contiguousFromIndex(
                $boothsByIndex,
                $start,
                $requiredSpaces,
                $blockedBoothIds,
                sameRowOnly: false,
                requireAvailable: $requireAvailable
            );

            if ($block->count() >= $requiredSpaces) {
                return $block->take($requiredSpaces)->values();
            }
        }

        return collect();
    }

    /**
     * @param  array<int>  $blockedBoothIds
     * @return Collection<int, Booth>
     */
    public static function footprintForAnchor(
        Collection $hallBooths,
        Booth $anchorBooth,
        int $requiredSpaces,
        array $blockedBoothIds = [],
        ?int $minimumStartIndex = null,
    ): Collection {
        if ($requiredSpaces <= 1) {
            if ($minimumStartIndex !== null) {
                $anchorIndex = VisitorFloorMap::layoutIndexForBoothNumber((string) $anchorBooth->booth_number);

                if ($anchorIndex !== null && $anchorIndex < $minimumStartIndex) {
                    return collect();
                }
            }

            return collect([$anchorBooth]);
        }

        $boothsByIndex = self::boothsByLayoutIndex($hallBooths);
        $anchorIndex = VisitorFloorMap::layoutIndexForBoothNumber((string) $anchorBooth->booth_number);

        if ($anchorIndex === null) {
            return collect([$anchorBooth]);
        }

        if ($minimumStartIndex !== null && $anchorIndex < $minimumStartIndex) {
            return collect();
        }

        foreach ([true, false] as $sameRowOnly) {
            $block = self::contiguousFromIndex(
                $boothsByIndex,
                $anchorIndex,
                $requiredSpaces,
                $blockedBoothIds,
                $sameRowOnly
            );

            if ($block->count() >= $requiredSpaces) {
                return $block->take($requiredSpaces)->values();
            }
        }

        $block = self::firstContiguousBlock(
            $hallBooths,
            $requiredSpaces,
            $blockedBoothIds,
            $anchorIndex,
            minimumStartIndex: $minimumStartIndex,
        );

        if ($block->count() >= $requiredSpaces) {
            return $block->take($requiredSpaces)->values();
        }

        return collect();
    }

    /**
     * @param  array<int>  $alreadyAssignedBoothIds
     * @return array{0:int,1:array<int>}|null
     */
    public static function assignBlockForBooking(
        Collection $hallBooths,
        int $requiredSpaces,
        ?int $preferredStartIndex,
        array $alreadyAssignedBoothIds = [],
        bool $packFromStart = false,
    ): ?array {
        $block = self::firstContiguousBlock(
            $hallBooths,
            $requiredSpaces,
            $alreadyAssignedBoothIds,
            $packFromStart ? null : $preferredStartIndex,
            requireAvailable: false,
            minimumStartIndex: $packFromStart ? 0 : null,
        );

        if ($block->count() < $requiredSpaces) {
            return null;
        }

        $ids = $block->take($requiredSpaces)->pluck('id')->map(fn ($id) => (int) $id)->values()->all();

        return [$ids[0], $ids];
    }

    /**
     * @param  array<int>|null  $selectedBoothIds
     */
    public static function preferredStartIndex(
        Collection $hallBooths,
        int $boothId,
        ?array $selectedBoothIds = null,
    ): ?int {
        $anchor = $hallBooths->firstWhere('id', $boothId);

        if ($anchor) {
            $index = VisitorFloorMap::layoutIndexForBoothNumber((string) $anchor->booth_number);

            if ($index !== null) {
                return $index;
            }
        }

        return collect($selectedBoothIds ?? [])
            ->map(fn ($id) => $hallBooths->firstWhere('id', (int) $id))
            ->filter()
            ->map(fn (Booth $booth) => VisitorFloorMap::layoutIndexForBoothNumber((string) $booth->booth_number))
            ->filter(fn ($index) => $index !== null)
            ->min();
    }
}
