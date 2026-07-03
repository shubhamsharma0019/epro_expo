<?php

namespace App\Support;

use App\Domain\Booth\Models\Booth;
use App\Domain\Event\Models\Hall;
use Illuminate\Support\Str;

class BoothNumbering
{
    public static function nextForHall(Hall|int $hall): string
    {
        $hallId = $hall instanceof Hall ? (int) $hall->id : (int) $hall;

        $existing = Booth::query()
            ->where('hall_id', $hallId)
            ->pluck('booth_number')
            ->map(fn ($number) => self::normalize((string) $number))
            ->filter()
            ->values();

        for ($index = 1; $index <= 999; $index++) {
            $candidate = 'B' . str_pad((string) $index, 2, '0', STR_PAD_LEFT);

            if (! $existing->contains(self::normalize($candidate))) {
                return $candidate;
            }
        }

        return 'B' . str_pad((string) ($existing->count() + 1), 2, '0', STR_PAD_LEFT);
    }

    public static function normalize(string $number): string
    {
        $value = strtoupper(trim($number));
        $value = Str::startsWith($value, 'B') ? substr($value, 1) : $value;

        if (preg_match('/^0*(\d+)([A-Z]*)$/', $value, $matches)) {
            return 'B' . str_pad((string) ((int) $matches[1]), 2, '0', STR_PAD_LEFT) . ($matches[2] ?? '');
        }

        return strtoupper(trim($number));
    }

    public static function existsInHall(Hall|int $hall, string $boothNumber, ?int $ignoreBoothId = null): bool
    {
        $hallId = $hall instanceof Hall ? (int) $hall->id : (int) $hall;
        $normalized = self::normalize($boothNumber);

        return Booth::query()
            ->where('hall_id', $hallId)
            ->when($ignoreBoothId, fn ($query) => $query->where('id', '!=', $ignoreBoothId))
            ->get(['id', 'booth_number'])
            ->contains(fn (Booth $booth) => self::normalize((string) $booth->booth_number) === $normalized);
    }
}
