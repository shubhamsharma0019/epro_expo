<?php

namespace App\Support;

use App\Domain\Booth\Models\Booth;
use App\Domain\Booth\Models\BoothSize;
use Illuminate\Support\Collection;

class BoothFloorMap
{
    public const CELL_WIDTH = 48;

    public const CELL_HEIGHT = 44;

    public static function unitsForSize(?BoothSize $selectedSize): int
    {
        if (! $selectedSize) {
            return 1;
        }

        $width = (float) $selectedSize->width;
        $height = (float) $selectedSize->height;

        if ($width > 0 && $height > 0) {
            return max(1, (int) ceil($width / 3) * (int) ceil($height / 3));
        }

        $area = (float) ($selectedSize->area ?: 0);

        return max(1, (int) ceil($area / 9));
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

        $left = (int) ($booth->position_x ?? 0);
        $top = (int) ($booth->position_y ?? 0);

        if ($left > 0 || $top > 0) {
            $visual = self::hallCoordinateVisual($left, $top);

            $left = min($left, 720 - $visual['width'] - 16);
            $top = min($top, 400 - $visual['height'] - 16);

            return [
                'left' => $left,
                'top' => $top,
                'right' => $left + $visual['width'],
                'bottom' => $top + $visual['height'],
                'width' => $visual['width'],
                'height' => $visual['height'],
            ];
        }

        [$left, $top] = self::fallbackPositionForBooth($booth);

        $width = 60;
        $height = 68;

        $left = min($left, 720 - $width - 16);
        $top = min($top, 400 - $height - 16);

        return [
            'left' => $left,
            'top' => $top,
            'right' => $left + $width,
            'bottom' => $top + $height,
            'width' => $width,
            'height' => $height,
        ];
    }

    /** @return array{width:int,height:int} */
    private static function hallCoordinateVisual(int $left, int $top): array
    {
        $cornerPositions = [
            '18-28' => true,
            '18-304' => true,
            '640-304' => true,
        ];

        if (isset($cornerPositions["{$left}-{$top}"])) {
            return ['width' => 48, 'height' => 44];
        }

        if ($top === 122) {
            return ['width' => 86, 'height' => 70];
        }

        return ['width' => 48, 'height' => 44];
    }

    private static function fallbackPositionForBooth(Booth $booth): array
    {
        $number = (int) preg_replace('/\D+/', '', (string) $booth->booth_number);
        $index = max($number - 1, 0);
        $columns = 10;
        $column = $index % $columns;
        $row = intdiv($index, $columns);

        return [16 + ($column * 68), 30 + ($row * 88)];
    }

    public static function boundsForFootprint(Collection $footprint): array
    {
        if ($footprint->isEmpty()) {
            return ['left' => 0, 'top' => 0, 'width' => self::CELL_WIDTH, 'height' => self::CELL_HEIGHT];
        }

        $metrics = $footprint->map(fn (Booth $booth) => self::metricsForBooth($booth));

        $left = (int) $metrics->min('left');
        $top = (int) $metrics->min('top');
        $right = (int) $metrics->max('right');
        $bottom = (int) $metrics->max('bottom');

        return [
            'left' => $left,
            'top' => $top,
            'width' => max(self::CELL_WIDTH, $right - $left),
            'height' => max(self::CELL_HEIGHT, $bottom - $top),
        ];
    }
    public static function segmentsForFootprint(Collection $footprint): array
    {
        if ($footprint->isEmpty()) {
            return [];
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
        $rowTolerance = 8;
        $gapTolerance = 18;

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
                    'width' => max(self::CELL_WIDTH, (int) ($segment['right'] - $segment['left'])),
                    'height' => max(self::CELL_HEIGHT, (int) ($segment['bottom'] - $segment['top'])),
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

        $sequentialFootprint = self::sequentialFootprintForSize($hall, $anchorBooth, $requiredSpaces, $blockedBoothIds);
        if ($sequentialFootprint->count() >= $requiredSpaces) {
            return $sequentialFootprint;
        }

        $rectangularFootprint = self::rectangularFootprintForSize($hall, $anchorBooth, $selectedSize, $requiredSpaces, $blockedBoothIds);
        if ($rectangularFootprint->count() >= $requiredSpaces) {
            return $rectangularFootprint;
        }

        $touchScore = function (array $a, array $b) {
            $horizontalOverlap = $a['top'] <= $b['bottom'] && $a['bottom'] >= $b['top'];
            $verticalOverlap = $a['left'] <= $b['right'] && $a['right'] >= $b['left'];
            $horizontalGap = max($b['left'] - $a['right'], $a['left'] - $b['right'], 0);
            $verticalGap = max($b['top'] - $a['bottom'], $a['top'] - $b['bottom'], 0);

            if ($horizontalOverlap && $horizontalGap <= 32) {
                return $horizontalGap;
            }

            if ($verticalOverlap && $verticalGap <= 32) {
                return $verticalGap + 20;
            }

            return null;
        };

        $selectedBooths = collect([$anchorBooth]);
        $candidateBooths = $hall->booths()
            ->where('status', 'available')
            ->whereKeyNot($anchorBooth->id)
            ->whereNotIn('id', $blockedBoothIds)
            ->get();

        while ($selectedBooths->count() < $requiredSpaces && $candidateBooths->isNotEmpty()) {
            $best = null;

            foreach ($candidateBooths as $candidate) {
                $candidateMetrics = self::metricsForBooth($candidate);
                $candidateScore = null;

                foreach ($selectedBooths as $selectedBooth) {
                    $score = $touchScore(self::metricsForBooth($selectedBooth), $candidateMetrics);
                    $candidateScore = $score === null ? $candidateScore : min($candidateScore ?? $score, $score);
                }

                if ($candidateScore !== null && (! $best || $candidateScore < $best['score'])) {
                    $best = ['booth' => $candidate, 'score' => $candidateScore];
                }
            }

            if (! $best) {
                break;
            }

            $selectedBooths->push($best['booth']);
            $candidateBooths = $candidateBooths->reject(fn ($booth) => $booth->id === $best['booth']->id)->values();
        }

        return $selectedBooths->values();
    }

    private static function sequentialFootprintForSize($hall, Booth $anchorBooth, int $requiredSpaces, array $blockedBoothIds): Collection
    {
        $availableBooths = $hall->booths()
            ->where('status', 'available')
            ->whereNotIn('id', $blockedBoothIds)
            ->get()
            ->sortBy(function (Booth $booth) {
                $number = (int) preg_replace('/\D+/', '', (string) $booth->booth_number);

                return sprintf('%08d-%08d', $number ?: $booth->id, $booth->id);
            })
            ->values();

        $anchorIndex = $availableBooths->search(fn (Booth $booth) => $booth->id === $anchorBooth->id);
        if ($anchorIndex === false) {
            return collect([$anchorBooth]);
        }

        return $availableBooths
            ->slice($anchorIndex, $requiredSpaces)
            ->values();
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
        $cellX = 60;
        $cellY = 54;
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
