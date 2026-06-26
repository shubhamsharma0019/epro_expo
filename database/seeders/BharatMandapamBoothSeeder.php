<?php

namespace Database\Seeders;

use App\Domain\Event\Models\Exhibition;
use App\Domain\Event\Models\Hall;
use App\Support\HallBoothLayoutSync;
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

        $boothSizes = HallBoothLayoutSync::resolveBoothSizes();

        if ($boothSizes->isEmpty()) {
            $this->command?->warn('Booth sizes missing. Run CompanyPavilionDemoSeeder first.');

            return;
        }

        $count = HallBoothLayoutSync::sync($hall, $boothSizes);

        $this->command?->info("Seeded {$count} booths for {$hall->title} (hall #{$hall->id}).");
    }
}
