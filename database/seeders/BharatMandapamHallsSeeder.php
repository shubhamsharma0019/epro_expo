<?php

namespace Database\Seeders;

use App\Domain\Event\Models\Exhibition;
use App\Domain\Event\Models\Hall;
use App\Domain\Event\Models\Pavilion;
use Illuminate\Database\Seeder;

class BharatMandapamHallsSeeder extends Seeder
{
    public function run(): void
    {
        $exhibition = Exhibition::query()->where('slug', 'bharat-mandapam')->first();

        if (! $exhibition) {
            $this->command?->warn('Bharat Mandapam exhibition not found. Skipping halls seed.');

            return;
        }

        $deepLearning = Pavilion::query()->updateOrCreate(
            ['exhibition_id' => $exhibition->id, 'slug' => 'deep-learning-pavilion'],
            ['title' => 'Deep Learning Pavilion', 'status' => 'active']
        );

        $mainInnovation = Pavilion::query()->updateOrCreate(
            ['exhibition_id' => $exhibition->id, 'slug' => 'main-innovation-pavilion'],
            ['title' => 'Main Innovation Pavilion', 'status' => 'active']
        );

        $hallA = Hall::query()->updateOrCreate(
            ['pavilion_id' => $deepLearning->id, 'slug' => 'hall-a'],
            [
                'title' => 'Hall A',
                'status' => 'active',
                'total_booths' => 48,
            ]
        );

        $mainAiHall = Hall::query()->updateOrCreate(
            ['pavilion_id' => $mainInnovation->id, 'slug' => 'main-ai-solutions-hall'],
            [
                'title' => 'Main AI Solutions Hall',
                'status' => 'active',
                'total_booths' => 40,
            ]
        );

        $this->command?->info("Bharat Mandapam halls ready: Hall A (#{$hallA->id}), Main AI Solutions Hall (#{$mainAiHall->id}).");
    }
}
