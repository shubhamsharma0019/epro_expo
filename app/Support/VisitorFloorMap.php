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

    private const BOOTHS_PER_ROW = 10;

    private const MAX_LAYOUT_BOOTHS = 40;

    /** @return array{padding:int,gap:int,boothW:int,boothH:int,colStep:int,rowStep:int} */
    public static function gridSpec(): array
    {
        static $spec = null;

        if ($spec !== null) {
            return $spec;
        }

        $padding = 10;
        $gap = 2;
        $rows = intdiv(self::MAX_LAYOUT_BOOTHS, self::BOOTHS_PER_ROW);
        $boothW = (int) floor(
            (self::CANVAS_WIDTH - (2 * $padding) - ((self::BOOTHS_PER_ROW - 1) * $gap)) / self::BOOTHS_PER_ROW
        );
        $boothH = (int) floor(
            (self::CANVAS_HEIGHT - (2 * $padding) - (($rows - 1) * $gap)) / $rows
        );

        $spec = [
            'padding' => $padding,
            'gap' => $gap,
            'boothW' => $boothW,
            'boothH' => $boothH,
            'colStep' => $boothW + $gap,
            'rowStep' => $boothH + $gap,
        ];

        return $spec;
    }

    public static function boothWidth(): int
    {
        return self::gridSpec()['boothW'];
    }

    public static function boothHeight(): int
    {
        return self::gridSpec()['boothH'];
    }

    public static function gridColumnStep(): int
    {
        return self::gridSpec()['colStep'];
    }

    public static function gridRowStep(): int
    {
        return self::gridSpec()['rowStep'];
    }

    /** @return array{left:int,top:int,width:int,height:int} */
    public static function boundsForGridRange(int $row, int $startCol, int $endCol): array
    {
        $spec = self::gridSpec();
        $count = max($endCol - $startCol + 1, 1);

        return [
            'left' => $spec['padding'] + ($startCol * $spec['colStep']),
            'top' => $spec['padding'] + ($row * $spec['rowStep']),
            'width' => ($count * $spec['boothW']) + (($count - 1) * $spec['gap']),
            'height' => $spec['boothH'],
        ];
    }

    /** @return array{x:int,y:int,status:string} */
    public static function layoutForIndex(int $index): array
    {
        $spec = self::gridSpec();
        $column = $index % self::BOOTHS_PER_ROW;
        $row = intdiv($index, self::BOOTHS_PER_ROW);

        return [
            'x' => $spec['padding'] + ($column * $spec['colStep']),
            'y' => $spec['padding'] + ($row * $spec['rowStep']),
            'status' => 'available',
        ];
    }

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

    public static function layoutIndexForBoothNumber(string $number): ?int
    {
        $normalized = self::normalizeBoothNumber($number);

        if (! preg_match('/^(\d+)/', $normalized, $matches)) {
            return null;
        }

        $index = ((int) $matches[1]) - 1;

        if ($index < 0 || $index >= self::MAX_LAYOUT_BOOTHS) {
            return null;
        }

        return $index;
    }

    private static function isCornerIndex(int $index): bool
    {
        return in_array($index, [0, self::BOOTHS_PER_ROW - 1, self::MAX_LAYOUT_BOOTHS - self::BOOTHS_PER_ROW, self::MAX_LAYOUT_BOOTHS - 1], true);
    }

    /** @return array<int, array{x:int,y:int,status:string}> */
    public static function layoutTemplate(): array
    {
        return collect(range(0, self::MAX_LAYOUT_BOOTHS - 1))
            ->map(fn (int $index) => self::layoutForIndex($index))
            ->all();
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
        $bookedGroups = HallBookedBoothGroups::forHall($hall, $dbBooths);
        $groupedBookedBoothIds = HallBookedBoothGroups::groupedBoothIds($bookedGroups);

        $booths = $dbBooths->map(function (Booth $booth) use ($bookingMetaByBoothId, $groupedBookedBoothIds) {
            $metrics = self::metricsForBooth($booth);
            $meta = $bookingMetaByBoothId->get((int) $booth->id, []);
            $state = self::resolveBoothState($booth, $meta);
            $isGroupedBooking = in_array((int) $booth->id, $groupedBookedBoothIds, true);

            return [
                'label' => self::formatBoothLabel($booth->booth_number),
                'shape' => $metrics['shape'],
                'left' => $metrics['left'],
                'top' => $metrics['top'],
                'state' => $isGroupedBooking ? 'booked' : $state,
                'company' => $meta['company_name'] ?? null,
                'width' => $metrics['width'],
                'height' => $metrics['height'],
                'font' => $metrics['font'],
                'category' => $meta['category'] ?? null,
                'is_hidden' => $isGroupedBooking,
            ];
        })->values()->all();

        return [
            'booths' => $booths,
            'overlayBookedBoothGroups' => $bookedGroups->all(),
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
        $layoutIndex = self::layoutIndexForBoothNumber((string) $booth->booth_number);

        if ($layoutIndex !== null) {
            $layout = self::layoutForIndex($layoutIndex);
            $left = (int) $layout['x'];
            $top = (int) $layout['y'];
        } else {
            $left = (int) ($booth->position_x ?? 0);
            $top = (int) ($booth->position_y ?? 0);

            if ($left > 0 || $top > 0) {
                $canonicalKey = HallBoothLayoutSync::canonicalPositionKey($left, $top);

                if ($canonicalKey !== "{$left}-{$top}") {
                    [$left, $top] = array_map('intval', explode('-', $canonicalKey));
                }
            }

            if ($left <= 0 && $top <= 0) {
                $left = self::gridSpec()['padding'];
                $top = self::gridSpec()['padding'];
            }
        }

        $width = self::boothWidth();
        $height = self::boothHeight();
        $isCorner = $layoutIndex !== null && self::isCornerIndex($layoutIndex);
        $shape = $isCorner ? 'circle' : 'square';
        $font = $isCorner ? 14 : 15;

        $padding = self::gridSpec()['padding'];
        $left = min($left, self::CANVAS_WIDTH - $width - $padding);
        $top = min($top, self::CANVAS_HEIGHT - $height - $padding);

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
        return collect(self::layoutTemplate())->map(function (array $layout, int $index) use ($hall) {
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
        $index = self::layoutIndexForBoothNumber($number);

        return $index === null ? null : self::layoutForIndex($index);
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
