<?php

namespace App\Support;

use App\Domain\Booth\Models\Booth;
use App\Domain\Booth\Models\BoothBooking;
use App\Domain\Event\Models\Hall;
use Illuminate\Support\Collection;

class HallBookedBoothGroups
{
    /** @param  Collection<int, Booth>  $booths */
    public static function forHall(Hall $hall, Collection $booths): Collection
    {
        $hall->loadMissing('pavilion.exhibition');

        $boothsById = $booths->keyBy('id');

        if ($boothsById->isEmpty()) {
            return collect();
        }

        return BoothBooking::query()
            ->with(['company', 'boothProfile', 'boothSize'])
            ->where('hall_id', $hall->id)
            ->where('payment_status', 'paid')
            ->whereIn('booking_status', ['confirmed', 'active'])
            ->whereIn('admin_status', ['pending', 'approved'])
            ->orderBy('created_at')
            ->orderBy('id')
            ->get()
            ->filter(fn (BoothBooking $booking) => $booking->company_id && $booking->booth_id)
            ->map(function (BoothBooking $booking) use ($hall, $boothsById) {
                $allocatedBooths = collect($booking->selected_booth_ids ?: [$booking->booth_id])
                    ->push($booking->booth_id)
                    ->filter()
                    ->map(fn ($id) => (int) $id)
                    ->unique()
                    ->filter(fn (int $id) => $boothsById->has($id))
                    ->map(fn (int $id) => $boothsById->get($id))
                    ->sortBy(function (Booth $booth) {
                        $number = (int) preg_replace('/\D+/', '', (string) $booth->booth_number);

                        return sprintf('%08d-%08d', $number ?: $booth->id, $booth->id);
                    })
                    ->values();

                if ($allocatedBooths->isEmpty()) {
                    return null;
                }

                $items = $allocatedBooths
                    ->map(function (Booth $booth) {
                        $metrics = BoothFloorMap::metricsForBooth($booth);

                        return [
                            'booth' => $booth,
                            'left' => $metrics['left'],
                            'top' => $metrics['top'],
                            'right' => $metrics['right'],
                            'bottom' => $metrics['bottom'],
                        ];
                    })
                    ->values();

                $profileLogo = $booking->boothProfile?->company_logo;
                $companyLogo = $booking->company?->logo;
                $logo = $profileLogo
                    ? asset(str_starts_with($profileLogo, 'storage/') ? $profileLogo : 'storage/' . $profileLogo)
                    : ($companyLogo ? asset($companyLogo) : null);

                $companyName = $booking->boothProfile?->company_name
                    ?: $booking->company?->company_name
                    ?: $booking->company?->name
                    ?: 'Booked Company';

                return [
                    'booking_id' => $booking->id,
                    'company_id' => $booking->company_id,
                    'company_name' => $companyName,
                    'logo_url' => $logo,
                    'booth_ids' => $items->pluck('booth.id')->values()->all(),
                    'booth_numbers' => $items->pluck('booth.booth_number')->values()->all(),
                    'segments' => BoothFloorMap::segmentsForFootprint($allocatedBooths),
                    'space_label' => trim(($items->count() > 1 ? $items->count() . ' spaces' : '1 space') . ' ' . ($booking->boothSize?->title ? '- ' . $booking->boothSize->title : '')),
                    'exhibition_name' => $hall->pavilion?->exhibition?->title ?? $hall->pavilion?->exhibition?->name ?? 'Exhibition',
                    'hall_name' => $hall->title,
                    'pavilion_name' => $hall->pavilion?->title ?? 'Pavilion',
                    'size_title' => $booking->boothSize?->title ?? 'Custom size',
                    'booth_count' => $items->count(),
                    'status' => ucfirst((string) ($booking->booking_status ?: 'confirmed')),
                    'contact_person' => $booking->company?->contact_person_name ?: $booking->company?->owner_name,
                    'email' => $booking->company?->email,
                    'phone' => $booking->company?->phone,
                    'website' => $booking->company?->website,
                    'category' => $booking->company?->industry,
                    'location' => trim(implode(', ', array_filter([$booking->company?->city, $booking->company?->country]))) ?: null,
                    'left' => max(min($items->min('left'), 700), 0),
                    'top' => max(min($items->min('top'), 350), 0),
                    'width' => min($items->max('right') - $items->min('left'), 700),
                    'height' => min($items->max('bottom') - $items->min('top'), 350),
                ];
            })
            ->filter()
            ->values()
            ->sortBy(function (array $group) use ($booths) {
                $firstBoothId = (int) (($group['booth_ids'][0] ?? 0));
                $booth = $booths->firstWhere('id', $firstBoothId);
                $index = $booth
                    ? VisitorFloorMap::layoutIndexForBoothNumber((string) $booth->booth_number)
                    : null;

                return sprintf('%03d-%03d', $index ?? 999, $firstBoothId);
            })
            ->values();
    }

    /** @return array<int> */
    public static function groupedBoothIds(Collection $groups): array
    {
        return $groups
            ->flatMap(fn (array $group) => $group['booth_ids'] ?? [])
            ->map(fn ($id) => (int) $id)
            ->unique()
            ->values()
            ->all();
    }

    public static function overlayLabelClass(int $width, int $height): string
    {
        $font = match (true) {
            $width >= 220 => 'text-[12px]',
            $width >= 140 => 'text-[11px]',
            $width >= 90 => 'text-[10px]',
            default => 'text-[9px]',
        };

        return "pointer-events-none w-full whitespace-normal break-words text-center leading-snug {$font}";
    }

    public static function overlayLogoClass(int $width, int $height): string
    {
        if ($width <= 56 && $height <= 52) {
            return 'pointer-events-none flex h-5 w-5 shrink-0 items-center justify-center overflow-hidden rounded-full bg-white/95 text-[10px] font-extrabold text-[#4B5563]';
        }

        return 'pointer-events-none flex h-7 w-7 shrink-0 items-center justify-center overflow-hidden rounded-full bg-white/95 text-[11px] font-extrabold text-[#4B5563]';
    }
}
