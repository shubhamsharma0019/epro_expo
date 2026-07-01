<?php

namespace Database\Seeders;

use App\Domain\Event\Models\Exhibition;
use App\Domain\Shared\Models\User;
use App\Domain\Visitor\Models\Visitor;
use Illuminate\Database\Seeder;

class AnuragTyagiPassesSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::query()
            ->where('email', 'Anuragtyagi@gmail.com')
            ->orWhere('id', 66)
            ->first();

        if (! $user) {
            $this->command?->warn('Anurag Tyagi user not found — skipping passes seeder.');

            return;
        }

        $bharat = Exhibition::query()->where('slug', 'bharat-mandapam')->first();
        $futureAi = Exhibition::query()->where('slug', 'future-of-ai-expo')->first();

        if (! $bharat || ! $futureAi) {
            $this->command?->warn('Required exhibitions missing — run exhibition slug fix migration first.');

            return;
        }

        Visitor::query()->updateOrCreate(
            [
                'booking_id' => 'EXP-260701-632229',
            ],
            [
                'exhibition_id' => $bharat->id,
                'user_id' => $user->id,
                'first_name' => 'Anurag',
                'last_name' => 'Tyagi',
                'email' => $user->email,
                'mobile' => '9999999999',
                'country' => 'India',
                'payment_status' => 'completed',
            ]
        );

        Visitor::query()->updateOrCreate(
            [
                'booking_id' => 'EXP-260701-238932',
            ],
            [
                'exhibition_id' => $futureAi->id,
                'user_id' => $user->id,
                'first_name' => 'Anurag',
                'last_name' => 'Tyagi',
                'email' => $user->email,
                'mobile' => '9999999999',
                'country' => 'India',
                'payment_status' => 'completed',
            ]
        );

        // Backfill user_id on any legacy rows for this email.
        Visitor::query()
            ->whereRaw('LOWER(email) = ?', [strtolower($user->email)])
            ->whereNull('user_id')
            ->update(['user_id' => $user->id]);

        $this->command?->info("Linked exhibition passes for {$user->name} (user #{$user->id}).");
    }
}
