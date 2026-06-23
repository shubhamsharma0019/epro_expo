<?php

namespace Database\Seeders;

use App\Domain\Booth\Models\Booth;
use App\Domain\Booth\Models\BoothSize;
use App\Domain\Event\Models\Exhibition;
use App\Domain\Event\Models\Hall;
use Illuminate\Database\Seeder;

class BharatMandapamBoothSeeder extends Seeder
{
    public function run(): void
    {
        $exhibition = Exhibition::where('slug', 'bharat-mandapam')->first();

        if (! $exhibition) {
            $this->command?->warn('Bharat Mandapam exhibition not found.');

            return;
        }

        $hall = Hall::query()
            ->whereHas('pavilion', fn ($query) => $query->where('exhibition_id', $exhibition->id))
            ->orderBy('id')
            ->first();

        if (! $hall) {
            $this->command?->warn('No hall found for Bharat Mandapam.');

            return;
        }

        $boothSizes = BoothSize::query()
            ->whereIn('title', ['3m x 3m', '3m x 4m', '6m x 3m', '6m x 6m', '9m x 9m'])
            ->orderBy('id')
            ->get()
            ->unique('title')
            ->values();

        if ($boothSizes->isEmpty()) {
            $this->command?->warn('Booth sizes missing. Run CompanyPavilionDemoSeeder first.');

            return;
        }

        $boothPositions = [
            [18, 28, 'reserved'], [78, 30, 'reserved'], [138, 30, 'reserved'], [198, 30, 'reserved'], [258, 30, 'reserved'], [318, 30, 'reserved'], [386, 30, 'available'], [446, 30, 'available'], [506, 30, 'available'], [640, 28, 'reserved'],
            [18, 82, 'available'], [640, 82, 'available'], [18, 136, 'available'], [640, 136, 'available'], [18, 190, 'available'], [640, 190, 'available'], [18, 244, 'available'], [640, 244, 'available'], [18, 304, 'reserved'], [640, 304, 'reserved'],
            [120, 122, 'available'], [250, 122, 'available'], [380, 122, 'available'], [510, 122, 'booked'], [78, 248, 'available'], [138, 248, 'available'], [198, 248, 'reserved'], [258, 248, 'reserved'], [318, 248, 'reserved'], [386, 248, 'reserved'],
            [446, 248, 'available'], [506, 248, 'available'], [78, 306, 'available'], [138, 306, 'available'], [198, 306, 'reserved'], [258, 306, 'reserved'], [318, 306, 'available'], [386, 306, 'available'], [446, 306, 'available'], [506, 306, 'available'],
        ];

        $existingBooths = Booth::query()
            ->where('hall_id', $hall->id)
            ->with('boothBooking')
            ->orderBy('id')
            ->get();

        $keptBoothIds = [];

        foreach ($boothPositions as $positionIndex => [$x, $y, $defaultStatus]) {
            $boothNumber = 'B' . str_pad((string) ($positionIndex + 1), 2, '0', STR_PAD_LEFT);
            $sizeIndex = match ($positionIndex) {
                4 => 1,
                20 => 2,
                21 => 3,
                22 => 4,
                default => 0,
            };
            $boothSize = $boothSizes[$sizeIndex] ?? $boothSizes[0];
            $existing = $existingBooths->get($positionIndex);

            if ($existing) {
                $payload = [
                    'booth_number' => $boothNumber,
                    'position_x' => $x,
                    'position_y' => $y,
                ];

                if (! $existing->boothBooking) {
                    $payload['booth_size_id'] = $existing->booth_size_id ?: $boothSize->id;
                    $payload['price'] = $existing->price > 0 ? $existing->price : $boothSize->price;
                    $payload['status'] = in_array($existing->status, ['booked', 'reserved'], true)
                        ? $existing->status
                        : $defaultStatus;
                }

                $existing->update($payload);
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

        Booth::query()
            ->where('hall_id', $hall->id)
            ->whereNotIn('id', $keptBoothIds)
            ->whereDoesntHave('boothBooking')
            ->delete();

        $hall->update(['total_booths' => count($boothPositions)]);
        $hall->pavilion?->update(['total_booths' => count($boothPositions)]);

        $this->command?->info('Seeded ' . count($boothPositions) . " booths for {$hall->title} (hall #{$hall->id}).");
    }
}
