<?php

namespace App\Support;

use App\Domain\Booth\Models\Booth;
use App\Domain\Booth\Models\BoothBooking;
use App\Domain\Event\Models\Hall;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class VisitorFloorMap
{
    private const CANVAS_WIDTH = 720;

    private const CANVAS_HEIGHT = 400;

    private const CORNER_POSITIONS = [
        '18-28' => true,
        '18-304' => true,
        '640-304' => true,
    ];

    private const CATEGORY_COLORS = [
        'technology' => '#5b2eff',
        'cloud' => '#246BFF',
        'sustainability' => '#16A34A',
        'healthcare' => '#EC4899',
        'finance' => '#F59E0B',
        'education' => '#0F766E',
        'ai' => '#7C3AED',
        'manufacturing' => '#DC2626',
        'retail' => '#0891B2',
    ];

    /** @var array<int, array{x:int,y:int,status:string}> */
    private static array $layoutByIndex = [
        // B01–B10: top row, left → right
        ['x' => 18, 'y' => 28, 'status' => 'reserved'],
        ['x' => 78, 'y' => 30, 'status' => 'reserved'],
        ['x' => 138, 'y' => 30, 'status' => 'reserved'],
        ['x' => 198, 'y' => 30, 'status' => 'reserved'],
        ['x' => 258, 'y' => 30, 'status' => 'reserved'],
        ['x' => 318, 'y' => 30, 'status' => 'reserved'],
        ['x' => 378, 'y' => 30, 'status' => 'available'],
        ['x' => 438, 'y' => 30, 'status' => 'available'],
        ['x' => 498, 'y' => 30, 'status' => 'available'],
        ['x' => 558, 'y' => 30, 'status' => 'reserved'],
        // B11–B20: middle row, left → right
        ['x' => 18, 'y' => 248, 'status' => 'available'],
        ['x' => 78, 'y' => 248, 'status' => 'available'],
        ['x' => 138, 'y' => 248, 'status' => 'available'],
        ['x' => 198, 'y' => 248, 'status' => 'available'],
        ['x' => 258, 'y' => 248, 'status' => 'reserved'],
        ['x' => 318, 'y' => 248, 'status' => 'reserved'],
        ['x' => 378, 'y' => 248, 'status' => 'reserved'],
        ['x' => 438, 'y' => 248, 'status' => 'reserved'],
        ['x' => 498, 'y' => 248, 'status' => 'available'],
        ['x' => 558, 'y' => 248, 'status' => 'available'],
        // B21–B30: bottom row, left → right
        ['x' => 18, 'y' => 304, 'status' => 'reserved'],
        ['x' => 78, 'y' => 306, 'status' => 'available'],
        ['x' => 138, 'y' => 306, 'status' => 'available'],
        ['x' => 198, 'y' => 306, 'status' => 'available'],
        ['x' => 258, 'y' => 306, 'status' => 'reserved'],
        ['x' => 318, 'y' => 306, 'status' => 'reserved'],
        ['x' => 378, 'y' => 306, 'status' => 'available'],
        ['x' => 438, 'y' => 306, 'status' => 'available'],
        ['x' => 498, 'y' => 306, 'status' => 'available'],
        ['x' => 640, 'y' => 304, 'status' => 'reserved'],
        // B31–B36: side row below top aisle, left → right (flanking center)
        ['x' => 18, 'y' => 190, 'status' => 'available'],
        ['x' => 78, 'y' => 190, 'status' => 'available'],
        ['x' => 138, 'y' => 190, 'status' => 'available'],
        ['x' => 438, 'y' => 190, 'status' => 'available'],
        ['x' => 498, 'y' => 190, 'status' => 'available'],
        ['x' => 558, 'y' => 190, 'status' => 'available'],
        // B37–B40: large center booths
        ['x' => 122, 'y' => 122, 'status' => 'available'],
        ['x' => 252, 'y' => 122, 'status' => 'available'],
        ['x' => 382, 'y' => 122, 'status' => 'available'],
        ['x' => 512, 'y' => 122, 'status' => 'booked'],
    ];

    /** @return array<int, array{x:int,y:int,status:string}> */
    public static function layoutTemplate(): array
    {
        return self::$layoutByIndex;
    }

    public static function syncBoothLayout(Booth $booth): void
    {
        self::applyLayoutFallback($booth);
    }

    public static function prepare(Hall $hall): array
    {
        $dbBooths = self::resolveBoothCollection($hall)
            ->sortBy(fn (Booth $booth) => self::boothNumberSortKey($booth))
            ->values();

        $bookingMetaByBoothId = self::bookingMetaByBoothId($hall);

        $booths = $dbBooths->map(function (Booth $booth) use ($bookingMetaByBoothId) {
            $metrics = self::metricsForBooth($booth);
            $meta = $bookingMetaByBoothId->get((int) $booth->id, []);
            $state = self::resolveBoothState($booth, $meta);

            return [
                'label' => self::formatBoothLabel($booth->booth_number),
                'shape' => $metrics['shape'],
                'left' => $metrics['left'],
                'top' => $metrics['top'],
                'state' => $state,
                'company' => $meta['company_name'] ?? null,
                'width' => $metrics['width'],
                'height' => $metrics['height'],
                'font' => $metrics['font'],
                'category' => $meta['category'] ?? null,
                'is_hidden' => false,
            ];
        })->values()->all();

        $bookedGroups = self::bookedGroupsFromMeta($bookingMetaByBoothId, $dbBooths);

        return [
            'booths' => $booths,
            'overlayBookedBoothGroups' => [],
            'totalBoothsCount' => $dbBooths->count(),
            'availableBoothsCount' => collect($booths)->where('state', 'available')->count(),
            'selectedBoothsCount' => collect($booths)->where('state', 'selected')->count(),
            'bookedBoothsCount' => collect($booths)->where('state', 'booked')->count(),
            'reservedBoothsCount' => collect($booths)->where('state', 'reserved')->count(),
            'categoryLegend' => self::categoryLegendForHall($hall, $bookedGroups),
        ];
    }

    public static function metricsForBooth(Booth $booth): array
    {
        $left = (int) ($booth->position_x ?? 0);
        $top = (int) ($booth->position_y ?? 0);

        if ($left <= 0 && $top <= 0) {
            $layout = self::layoutForBoothNumber($booth->booth_number);
            $left = (int) ($layout['x'] ?? 16);
            $top = (int) ($layout['y'] ?? 30);
        }

        $positionKey = $left . '-' . $top;

        if (isset(self::CORNER_POSITIONS[$positionKey])) {
            $width = 48;
            $height = 44;
            $shape = 'circle';
            $font = 14;
        } elseif ($top === 122) {
            $width = 86;
            $height = 70;
            $shape = 'large';
            $font = 18;
        } else {
            $width = 48;
            $height = 44;
            $shape = 'square';
            $font = 14;
        }

        $left = min($left, self::CANVAS_WIDTH - $width - 8);
        $top = min($top, self::CANVAS_HEIGHT - $height - 8);

        return [
            'left' => $left,
            'top' => $top,
            'width' => $width,
            'height' => $height,
            'shape' => $shape,
            'font' => $font,
            'right' => $left + $width,
            'bottom' => $top + $height,
        ];
    }

    /** @return array{label:string,color:string} */
    public static function colorForCategory(?string $category): array
    {
        $label = filled($category) ? trim($category) : 'General';
        $key = Str::lower($label);

        foreach (self::CATEGORY_COLORS as $needle => $color) {
            if (str_contains($key, $needle)) {
                return ['label' => $label, 'color' => $color];
            }
        }

        $palette = array_values(self::CATEGORY_COLORS);

        return [
            'label' => $label,
            'color' => $palette[crc32($key) % count($palette)],
        ];
    }

    /** @return Collection<int, Booth> */
    private static function resolveBoothCollection(Hall $hall): Collection
    {
        $dbBooths = $hall->booths()->with('boothSize')->get();

        if ($dbBooths->isNotEmpty()) {
            return $dbBooths
                ->filter(fn (Booth $booth) => self::isValidFloorBooth($booth))
                ->sortBy(fn (Booth $booth) => self::sortKey($booth))
                ->values();
        }

        return self::templateBoothCollection($hall);
    }

    private static function isValidFloorBooth(Booth $booth): bool
    {
        if ((int) ($booth->position_x ?? 0) > 0 || (int) ($booth->position_y ?? 0) > 0) {
            return true;
        }

        return (bool) preg_match('/^B\d+/i', (string) $booth->booth_number);
    }

    /** @return Collection<int, array{company_name:?string,category:?string}> */
    private static function bookingMetaByBoothId(Hall $hall): Collection
    {
        $hallBoothIds = $hall->booths()->pluck('id')->map(fn ($id) => (int) $id);
        $meta = collect();

        BoothBooking::query()
            ->with(['company', 'boothProfile'])
            ->where('hall_id', $hall->id)
            ->where('payment_status', 'paid')
            ->whereIn('booking_status', ['confirmed', 'active'])
            ->whereIn('admin_status', ['pending', 'approved'])
            ->orderBy('created_at')
            ->get()
            ->each(function (BoothBooking $booking) use ($hallBoothIds, $meta) {
                $companyName = $booking->boothProfile?->company_name
                    ?: $booking->company?->company_name
                    ?: $booking->company?->name;
                $category = $booking->company?->industry;

                collect($booking->selected_booth_ids ?: [$booking->booth_id])
                    ->push($booking->booth_id)
                    ->filter()
                    ->map(fn ($id) => (int) $id)
                    ->unique()
                    ->filter(fn (int $id) => $hallBoothIds->contains($id))
                    ->each(function (int $id) use ($meta, $companyName, $category) {
                        $meta->put($id, [
                            'company_name' => $companyName,
                            'category' => $category,
                        ]);
                    });
            });

        return $meta;
    }

    /** @param array{company_name?:string,category?:string} $meta */
    private static function resolveBoothState(Booth $booth, array $meta): string
    {
        if (filled($meta['company_name'] ?? null)) {
            return 'booked';
        }

        $status = (string) ($booth->status ?: 'available');

        if ($status === 'booked') {
            return 'booked';
        }

        return in_array($status, ['available', 'reserved', 'selected'], true)
            ? $status
            : 'available';
    }

    /** @return Collection<int, array<string, mixed>> */
    private static function bookedGroupsFromMeta(Collection $bookingMetaByBoothId, Collection $dbBooths): Collection
    {
        return $bookingMetaByBoothId
            ->map(function (array $meta, int $boothId) use ($dbBooths) {
                $booth = $dbBooths->firstWhere('id', $boothId);
                if (! $booth) {
                    return null;
                }

                return [
                    'company_name' => $meta['company_name'] ?? null,
                    'category' => $meta['category'] ?? null,
                    'booth_ids' => [$boothId],
                    'booth_numbers' => [$booth->booth_number],
                ];
            })
            ->filter(fn (?array $group) => filled($group['company_name'] ?? null))
            ->values();
    }

    /** @return Collection<int, Booth> */
    private static function templateBoothCollection(Hall $hall): Collection
    {
        return collect(self::$layoutByIndex)->map(function (array $layout, int $index) use ($hall) {
            $number = 'B' . str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT);

            $booth = new Booth([
                'hall_id' => $hall->id,
                'booth_number' => $number,
                'position_x' => $layout['x'],
                'position_y' => $layout['y'],
                'status' => $layout['status'],
            ]);
            $booth->id = -1 * ($index + 1);

            return $booth;
        });
    }

    private static function applyLayoutFallback(Booth $booth): void
    {
        if ((int) ($booth->position_x ?? 0) > 0 || (int) ($booth->position_y ?? 0) > 0) {
            return;
        }

        $layout = self::layoutForBoothNumber($booth->booth_number);
        if (! $layout) {
            return;
        }

        $booth->position_x = $layout['x'];
        $booth->position_y = $layout['y'];

        if (blank($booth->status)) {
            $booth->status = $layout['status'];
        }
    }

    /** @return array{x:int,y:int,status:string}|null */
    private static function layoutForBoothNumber(string $number): ?array
    {
        $normalized = self::normalizeBoothNumber($number);

        if (! preg_match('/^(\d+)/', $normalized, $matches)) {
            return null;
        }

        $index = ((int) $matches[1]) - 1;

        return self::$layoutByIndex[$index] ?? null;
    }

    private static function normalizeBoothNumber(string $number): string
    {
        $value = strtoupper(preg_replace('/[^A-Z0-9]/', '', $number));
        $value = str_starts_with($value, 'B') ? substr($value, 1) : $value;

        if (preg_match('/^0*(\d+)([A-Z]*)$/', $value, $matches)) {
            return ((string) ((int) $matches[1])) . $matches[2];
        }

        return $value;
    }

    private static function formatBoothLabel(string $number): string
    {
        $value = self::normalizeBoothNumber($number);

        if (preg_match('/^(\d+)([A-Z]*)$/', $value, $matches)) {
            $numeric = (int) $matches[1];
            $suffix = $matches[2] ?? '';

            return ($numeric < 10 ? str_pad((string) $numeric, 2, '0', STR_PAD_LEFT) : (string) $numeric) . $suffix;
        }

        return $value;
    }

    private static function sortKey(Booth $booth): string
    {
        return str_pad((string) ($booth->position_y ?? 0), 4, '0', STR_PAD_LEFT)
            . str_pad((string) ($booth->position_x ?? 0), 4, '0', STR_PAD_LEFT);
    }

    private static function boothNumberSortKey(Booth $booth): string
    {
        $number = (int) preg_replace('/\D+/', '', (string) $booth->booth_number);

        return sprintf('%08d-%08d', $number ?: $booth->id, $booth->id);
    }

    /** @return array<int, array{label:string,color:string}> */
    private static function categoryLegendForHall(Hall $hall, Collection $bookedGroups): array
    {
        $categories = $bookedGroups
            ->pluck('category')
            ->filter()
            ->unique()
            ->values();

        if ($categories->isEmpty()) {
            $categories = BoothBooking::query()
                ->where('hall_id', $hall->id)
                ->where('payment_status', 'paid')
                ->whereIn('booking_status', ['confirmed', 'active'])
                ->with('company')
                ->get()
                ->pluck('company.industry')
                ->filter()
                ->unique()
                ->values();
        }

        if ($categories->isEmpty()) {
            return collect(['Technology', 'Cloud', 'Sustainability', 'Healthcare', 'Finance', 'Education'])
                ->map(fn (string $label) => self::colorForCategory($label))
                ->values()
                ->all();
        }

        return $categories
            ->map(fn (string $category) => self::colorForCategory($category))
            ->values()
            ->all();
    }
}
