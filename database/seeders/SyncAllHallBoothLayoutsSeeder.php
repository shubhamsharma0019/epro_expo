<?php

namespace Database\Seeders;

use App\Domain\Event\Models\Hall;
use App\Support\HallBoothLayoutSync;
use Illuminate\Database\Seeder;

class SyncAllHallBoothLayoutsSeeder extends Seeder
{
    public function run(): void
    {
        $boothSizes = HallBoothLayoutSync::resolveBoothSizes();

        if ($boothSizes->isEmpty()) {
            $this->command?->warn('No booth sizes found. Seed booth sizes first.');

            return;
        }

        $halls = Hall::query()->orderBy('id')->get();

        if ($halls->isEmpty()) {
            $this->command?->warn('No halls found to sync.');

            return;
        }

        foreach ($halls as $hall) {
            $count = HallBoothLayoutSync::sync($hall, $boothSizes);
            $this->command?->info("Synced {$count} booths for hall #{$hall->id} — {$hall->title}");
        }

        $this->command?->info("Finished syncing {$halls->count()} hall(s).");
    }
}
