<?php

namespace Database\Seeders;

use App\Domain\Booth\Models\Booth;
use App\Domain\Booth\Models\BoothBooking;
use App\Domain\Company\Models\Company;
use App\Domain\Event\Models\Exhibition;
use App\Domain\Event\Models\Hall;
use App\Support\HallBoothLayoutSync;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class BharatMandapamHallLayoutSeeder extends Seeder
{
    public function run(): void
    {
        $exhibition = Exhibition::query()->where('slug', 'bharat-mandapam')->first();

        if (! $exhibition) {
            $this->command?->warn('Bharat Mandapam exhibition not found.');

            return;
        }

        $hall = Hall::query()
            ->where('slug', 'main-ai-solutions-hall')
            ->whereHas('pavilion', fn ($query) => $query->where('exhibition_id', $exhibition->id))
            ->with('pavilion')
            ->first();

        if (! $hall) {
            $this->command?->warn('Main AI Solutions Hall not found. Run BharatMandapamHallsSeeder first.');

            return;
        }

        if ($hall->booths()->count() === 0) {
            $boothSizes = HallBoothLayoutSync::resolveBoothSizes();

            if ($boothSizes->isEmpty()) {
                $this->command?->warn('No booth sizes found. Run CompanyPavilionDemoSeeder first.');

                return;
            }

            HallBoothLayoutSync::sync($hall, $boothSizes);
        }

        if (BoothBooking::query()
            ->where('hall_id', $hall->id)
            ->where('payment_status', 'paid')
            ->exists()) {
            $this->command?->info("Hall layout data already present for {$hall->title}.");

            return;
        }

        $boothsByNumber = $hall->booths()->get()->keyBy(
            fn (Booth $booth) => strtoupper((string) $booth->booth_number)
        );

        $demos = [
            ['company' => 'sagar Traders', 'email' => 'sagar-traders@expo.demo', 'booths' => ['B01']],
            ['company' => 'Ritik Tyagi Enterprises', 'email' => 'ritiktyagi@gmail.com', 'booths' => ['B02']],
            ['company' => 'unbaiq me llc', 'email' => 'unbaiq-me-llc@expo.demo', 'booths' => ['B03', 'B04']],
            ['company' => 'Google', 'email' => 'google@expo.demo', 'booths' => ['B05', 'B06', 'B07', 'B08', 'B09', 'B10', 'B12', 'B14', 'B16']],
            ['company' => 'UNBAIQ', 'email' => 'unbaiq-demo@expo.demo', 'booths' => ['B18', 'B20']],
        ];

        foreach ($demos as $demo) {
            $boothIds = collect($demo['booths'])
                ->map(fn (string $number) => (int) ($boothsByNumber->get(strtoupper($number))?->id ?? 0))
                ->filter()
                ->values()
                ->all();

            if ($boothIds === []) {
                continue;
            }

            $company = Company::query()->updateOrCreate(
                ['email' => $demo['email']],
                [
                    'company_name' => $demo['company'],
                    'contact_person_name' => $demo['company'],
                    'phone' => '9999900000',
                    'password' => Hash::make('password'),
                    'status' => 'approved',
                ]
            );

            Booth::query()->whereIn('id', $boothIds)->update(['status' => 'booked']);

            BoothBooking::query()->updateOrCreate(
                ['company_id' => $company->id, 'hall_id' => $hall->id],
                [
                    'exhibition_id' => $exhibition->id,
                    'pavilion_id' => $hall->pavilion_id,
                    'booth_id' => $boothIds[0],
                    'selected_booth_ids' => $boothIds,
                    'amount' => 0,
                    'services_amount' => 0,
                    'total_amount' => 0,
                    'payment_status' => 'paid',
                    'booking_status' => 'confirmed',
                    'admin_status' => 'approved',
                    'paid_at' => now(),
                ]
            );
        }

        $this->command?->info("Seeded hall layout bookings for {$hall->title}.");
    }
}
