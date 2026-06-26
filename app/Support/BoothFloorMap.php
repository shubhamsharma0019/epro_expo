<?php

namespace App\Support;

use App\Domain\Booth\Models\Booth;
use App\Domain\Booth\Models\BoothSize;
use Illuminate\Support\Collection;

class BoothFloorMap
{
    public static function cellWidth(): int
    {
        return VisitorFloorMap::boothWidth();
    }

    public static function cellHeight(): int
    {
        return VisitorFloorMap::boothHeight();
    }

    public static function unitsForSize(?BoothSize $selectedSize): int
    {
        if (! $selectedSize) {
            return 1;
        }

        $area = (float) ($selectedSize->area ?: 0);

        if ($area > 0 && SequentialBoothSizes::isSequentialArea($area)) {
            return max(1, (int) round($area / SequentialBoothSizes::UNIT_AREA));
        }

        $width = (float) $selectedSize->width;
        $height = (float) $selectedSize->height;

        if ($width > 0 && $height > 0) {
            return max(1, (int) ceil($width / 3) * (int) ceil($height / 3));
        }

        return max(1, (int) ceil($area / SequentialBoothSizes::UNIT_AREA));
    }

    public static function visualForArea(float $area): array
    {
        return match (true) {
            $area >= 81 => ['width' => 150, 'height' => 130, 'font' => 24],
            $area >= 36 => ['width' => 120, 'height' => 110, 'font' => 22],
            $area >= 18 => ['width' => 96, 'height' => 76, 'font' => 19],
            $area >= 12 => ['width' => 72, 'height' => 56, 'font' => 16],
            default => ['width' => 48, 'height' => 44, 'font' => 14],
        };
    }

    public static function metricsForBooth(Booth $booth): array
    {
        $booth->loadMissing('boothSize');
        $metrics = VisitorFloorMap::metricsForBooth($booth);

        return [
            'left' => $metrics['left'],
            'top' => $metrics['top'],
            'right' => $metrics['right'],
            'bottom' => $metrics['bottom'],
            'width' => $metrics['width'],
            'height' => $metrics['height'],
        ];
    }

    public static function boundsForFootprint(Collection $footprint): array
    {
        if ($footprint->isEmpty()) {
            return ['left' => 0, 'top' => 0, 'width' => self::cellWidth(), 'height' => self::cellHeight()];
        }

        $metrics = $footprint->map(fn (Booth $booth) => self::metricsForBooth($booth));

        $left = (int) $metrics->min('left');
        $top = (int) $metrics->min('top');
        $right = (int) $metrics->max('right');
        $bottom = (int) $metrics->max('bottom');

        return [
            'left' => $left,
            'top' => $top,
            'width' => max(self::cellWidth(), $right - $left),
            'height' => max(self::cellHeight(), $bottom - $top),
        ];
    }
    public static function segmentsForFootprint(Collection $footprint): array
    {
        if ($footprint->isEmpty()) {
            return [];
        }

        $cells = $footprint
            ->map(function (Booth $booth) {
                $index = VisitorFloorMap::layoutIndexForBoothNumber((string) $booth->booth_number);

                if ($index === null) {
                    return null;
                }

                return [
                    'id' => $booth->id,
                    'number' => $booth->booth_number,
                    'index' => $index,
                    'row' => intdiv($index, 10),
                    'col' => $index % 10,
                ];
            })
            ->filter()
            ->sortBy('index')
            ->values();

        if ($cells->isNotEmpty()) {
            $segments = [];

            foreach ($cells as $cell) {
                $lastIndex = count($segments) - 1;
                $last = $lastIndex >= 0 ? $segments[$lastIndex] : null;

                if ($last && $last['row'] === $cell['row'] && $cell['col'] === ($last['endCol'] + 1)) {
                    $segments[$lastIndex]['endCol'] = $cell['col'];
                    $segments[$lastIndex]['ids'][] = $cell['id'];
                    $segments[$lastIndex]['numbers'][] = $cell['number'];

                    continue;
                }

                $segments[] = [
                    'row' => $cell['row'],
                    'startCol' => $cell['col'],
                    'endCol' => $cell['col'],
                    'ids' => [$cell['id']],
                    'numbers' => [$cell['number']],
                ];
            }

            return collect($segments)
                ->map(function (array $segment) {
                    $bounds = VisitorFloorMap::boundsForGridRange(
                        $segment['row'],
                        $segment['startCol'],
                        $segment['endCol']
                    );

                    return [
                        'ids' => $segment['ids'],
                        'numbers' => $segment['numbers'],
                        'left' => $bounds['left'],
                        'top' => $bounds['top'],
                        'width' => $bounds['width'],
                        'height' => $bounds['height'],
                    ];
                })
                ->values()
                ->all();
        }

        $items = $footprint
            ->map(function (Booth $booth) {
                $metrics = self::metricsForBooth($booth);

                return [
                    'id' => $booth->id,
                    'number' => $booth->booth_number,
                    'left' => $metrics['left'],
                    'top' => $metrics['top'],
                    'right' => $metrics['right'],
                    'bottom' => $metrics['bottom'],
                ];
            })
            ->sortBy(fn (array $item) => sprintf('%04d-%04d', $item['top'], $item['left']))
            ->values();

        $segments = [];
        $rowTolerance = 12;
        $gapTolerance = VisitorFloorMap::gridColumnStep();

        foreach ($items as $item) {
            $lastIndex = count($segments) - 1;
            $last = $lastIndex >= 0 ? $segments[$lastIndex] : null;

            if ($last && abs($last['top'] - $item['top']) <= $rowTolerance && $item['left'] <= $last['right'] + $gapTolerance) {
                $segments[$lastIndex]['ids'][] = $item['id'];
                $segments[$lastIndex]['numbers'][] = $item['number'];
                $segments[$lastIndex]['left'] = min($last['left'], $item['left']);
                $segments[$lastIndex]['top'] = min($last['top'], $item['top']);
                $segments[$lastIndex]['right'] = max($last['right'], $item['right']);
                $segments[$lastIndex]['bottom'] = max($last['bottom'], $item['bottom']);

                continue;
            }

            $segments[] = [
                'ids' => [$item['id']],
                'numbers' => [$item['number']],
                'left' => $item['left'],
                'top' => $item['top'],
                'right' => $item['right'],
                'bottom' => $item['bottom'],
            ];
        }

        return collect($segments)
            ->map(function (array $segment) {
                return [
                    'ids' => $segment['ids'],
                    'numbers' => $segment['numbers'],
                    'left' => max((int) $segment['left'], 0),
                    'top' => max((int) $segment['top'], 0),
                    'width' => max(self::cellWidth(), (int) ($segment['right'] - $segment['left'])),
                    'height' => max(self::cellHeight(), (int) ($segment['bottom'] - $segment['top'])),
                ];
            })
            ->values()
            ->all();
    }

    public static function footprintForSize($hall, Booth $anchorBooth, ?BoothSize $selectedSize, array $blockedBoothIds = []): Collection
    {
        if ($anchorBooth->status !== 'available' || in_array((int) $anchorBooth->id, $blockedBoothIds, true)) {
            return collect();
        }

        $requiredSpaces = self::unitsForSize($selectedSize);
        if ($requiredSpaces === 1) {
            return collect([$anchorBooth]);
        }

        $hallBooths = $hall->booths()->get();
        $minimumStartIndex = SequentialBoothAllocation::minimumStartIndexAfterBlocked($hallBooths, $blockedBoothIds);

        $sequentialFootprint = SequentialBoothAllocation::footprintForAnchor(
            $hallBooths,
            $anchorBooth,
            $requiredSpaces,
            $blockedBoothIds,
            $minimumStartIndex
        );

        if ($sequentialFootprint->count() >= $requiredSpaces) {
            return $sequentialFootprint->take($requiredSpaces)->values();
        }

        $rectangularFootprint = self::rectangularFootprintForSize($hall, $anchorBooth, $selectedSize, $requiredSpaces, $blockedBoothIds);
        if ($rectangularFootprint->count() >= $requiredSpaces) {
            return $rectangularFootprint->take($requiredSpaces)->values();
        }

        return collect();
    }

    private static function sequentialFootprintForSize($hall, Booth $anchorBooth, int $requiredSpaces, array $blockedBoothIds): Collection
    {
        return SequentialBoothAllocation::footprintForAnchor(
            $hall->booths()->get(),
            $anchorBooth,
            $requiredSpaces,
            $blockedBoothIds,
            SequentialBoothAllocation::minimumStartIndexAfterBlocked($hall->booths()->get(), $blockedBoothIds)
        );
    }
    private static function rectangularFootprintForSize($hall, Booth $anchorBooth, ?BoothSize $selectedSize, int $requiredSpaces, array $blockedBoothIds): Collection
    {
        $targetCols = (int) ceil(sqrt($requiredSpaces));
        $targetRows = (int) ceil($requiredSpaces / max($targetCols, 1));

        $shapes = collect([
            [$targetCols, $targetRows],
            [$targetRows, $targetCols],
            [$requiredSpaces, 1],
            [1, $requiredSpaces],
        ])->unique(fn (array $shape) => $shape[0] . 'x' . $shape[1])->values();

        $availableBooths = $hall->booths()
            ->where('status', 'available')
            ->whereNotIn('id', $blockedBoothIds)
            ->get()
            ->keyBy('id');

        $anchorMetrics = self::metricsForBooth($anchorBooth);
        $cellX = VisitorFloorMap::gridColumnStep();
        $cellY = VisitorFloorMap::gridRowStep();
        $best = null;

        foreach ($shapes as [$cols, $rows]) {
            foreach ([[1, 1], [-1, 1], [1, -1], [-1, -1]] as [$xDirection, $yDirection]) {
                $selected = collect([$anchorBooth->id => $anchorBooth]);
                $score = 0;

                for ($row = 0; $row < $rows; $row++) {
                    for ($col = 0; $col < $cols; $col++) {
                        if ($row === 0 && $col === 0) {
                            continue;
                        }

                        $targetLeft = $anchorMetrics['left'] + ($col * $cellX * $xDirection);
                        $targetTop = $anchorMetrics['top'] + ($row * $cellY * $yDirection);
                        $candidate = $availableBooths
                            ->reject(fn (Booth $booth) => $selected->has($booth->id))
                            ->map(function (Booth $booth) use ($targetLeft, $targetTop) {
                                $metrics = self::metricsForBooth($booth);
                                $distance = abs($metrics['left'] - $targetLeft) + abs($metrics['top'] - $targetTop);

                                return compact('booth', 'metrics', 'distance');
                            })
                            ->filter(fn (array $item) => abs($item['metrics']['left'] - $targetLeft) <= 40 && abs($item['metrics']['top'] - $targetTop) <= 34)
                            ->sortBy('distance')
                            ->first();

                        if (! $candidate) {
                            continue 3;
                        }

                        $score += $candidate['distance'];
                        $selected->put($candidate['booth']->id, $candidate['booth']);

                        if ($selected->count() >= $requiredSpaces) {
                            break 2;
                        }
                    }
                }

                if ($selected->count() >= $requiredSpaces && (! $best || $score < $best['score'])) {
                    $best = ['score' => $score, 'booths' => $selected->values()->take($requiredSpaces)];
                }
            }
        }

        return $best ? $best['booths']->values() : collect();
    }
}
