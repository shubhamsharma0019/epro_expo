<?php

namespace Database\Seeders;

use App\Domain\Booth\Models\BoothBooking;
use App\Domain\Booth\Models\BoothProduct;
use App\Domain\Booth\Models\BoothProfile;
use App\Domain\Booth\Models\BoothSession;
use App\Domain\Event\Models\Exhibition;
use Illuminate\Database\Seeder;

class BharatMandapamBoothHubSeeder extends Seeder
{
    public function run(): void
    {
        $exhibition = Exhibition::query()->where('slug', 'bharat-mandapam')->first();

        if (! $exhibition) {
            $this->command?->warn('Bharat Mandapam exhibition not found.');

            return;
        }

        $this->seedBooth($exhibition->id, 'sagar Traders', [
            'profile' => [
                'contact_person' => 'Sagar',
                'industry' => 'Gaming & Entertainment',
                'email' => 'sagar@gmail.com',
                'phone' => '9123456780',
                'tagline' => 'Next-gen gaming experiences for global audiences.',
                'about_company' => 'sagar Traders builds immersive gaming tournaments, esports infrastructure, and interactive entertainment solutions for exhibitions and live events.',
                'website' => 'https://nair.com',
                'city' => 'Muradnagar',
                'state' => 'Uttar Pradesh',
                'country' => 'India',
            ],
            'product' => [
                'name' => 'gaming',
                'category' => 'Gaming',
                'short_description' => 'GAMING UNIVERSE CHAMPIONSHIP — competitive esports showcase.',
                'detailed_description' => 'Live gaming demos, tournament brackets, and championship previews for visitors.',
            ],
            'session' => [
                'title' => 'Product',
                'description' => 'Live product walkthrough at the sagar Traders booth.',
                'session_date' => '2026-06-05',
                'start_time' => '11:00:00',
                'end_time' => '11:30:00',
            ],
        ]);

        $this->seedBooth($exhibition->id, 'unbaiq me llc', [
            'profile' => [
                'contact_person' => 'John Doe',
                'industry' => 'Technology, Conference',
                'email' => 'unbaiq@expo.demo',
                'phone' => '9876543210',
                'tagline' => 'AI-powered business solutions for modern enterprises.',
                'about_company' => 'unbaiq me llc delivers intelligent automation, analytics platforms, and enterprise software tailored for exhibition visitors and global clients.',
                'website' => 'https://www.globaltechsummit.com',
                'city' => 'Mumbai',
                'state' => 'Maharashtra',
                'country' => 'India',
            ],
            'product' => [
                'name' => 'johndoe',
                'category' => 'Software',
                'short_description' => 'Enterprise AI assistant for sales, support, and visitor engagement.',
                'detailed_description' => 'Demo the johndoe platform with live workflows, analytics dashboards, and meeting integrations.',
            ],
            'session' => [
                'title' => 'product',
                'description' => 'Product demo and Q&A at the unbaiq me llc booth.',
                'session_date' => '2026-06-23',
                'start_time' => '11:00:00',
                'end_time' => '11:30:00',
            ],
        ]);
    }

    private function seedBooth(int $exhibitionId, string $companyName, array $data): void
    {
        $booking = BoothBooking::query()
            ->with('company')
            ->where('exhibition_id', $exhibitionId)
            ->where('payment_status', 'paid')
            ->whereHas('company', fn ($query) => $query->where('company_name', $companyName))
            ->first();

        if (! $booking) {
            $this->command?->warn("{$companyName} booth booking not found.");

            return;
        }

        BoothProfile::query()->updateOrCreate(
            ['booth_booking_id' => $booking->id],
            array_merge([
                'company_id' => $booking->company_id,
                'company_name' => $companyName,
                'status' => 'published',
            ], $data['profile'])
        );

        BoothProduct::query()->updateOrCreate(
            ['booth_booking_id' => $booking->id, 'name' => $data['product']['name']],
            array_merge([
                'company_id' => $booking->company_id,
                'status' => 'published',
                'sort_order' => 0,
            ], $data['product'])
        );

        BoothSession::query()->updateOrCreate(
            ['booth_booking_id' => $booking->id, 'title' => $data['session']['title']],
            array_merge([
                'company_id' => $booking->company_id,
                'type' => 'live_demo',
                'attendee_limit' => 100,
                'status' => 'upcoming',
                'end_time' => '11:30:00',
            ], $data['session'])
        );

        $this->command?->info("Updated {$companyName} booth hub content for booking #{$booking->id}.");
    }
}
