<?php

namespace Database\Seeders;

use App\Domain\Booth\Models\Booth;
use App\Domain\Booth\Models\BoothBooking;
use App\Domain\Company\Models\Company;
use App\Domain\Company\Models\CompanyMeeting;
use App\Domain\Event\Models\Exhibition;
use App\Domain\Event\Models\Hall;
use App\Domain\Event\Models\Pavilion;
use App\Domain\Shared\Models\User;
use App\Domain\Visitor\Models\VisitorMeetingBooking;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class VisitorPortalMeetingsSeeder extends Seeder
{
    public function run(): void
    {
        $visitors = User::query()->orderBy('id')->get();

        if ($visitors->isEmpty()) {
            $visitors = collect([
                User::create([
                    'name' => 'Ritik',
                    'email' => 'ritik@example.com',
                    'password' => Hash::make('password'),
                ]),
            ]);
        }

        $exhibition = Exhibition::query()->orderBy('start_date')->first();

        if (! $exhibition) {
            $this->command?->warn('No exhibition found. Skipping visitor meetings seed.');

            return;
        }

        $pavilion = Pavilion::query()->firstOrCreate(
            ['exhibition_id' => $exhibition->id, 'slug' => 'deep-learning-pavilion'],
            [
                'title' => 'Deep Learning Pavilion',
                'status' => 'active',
            ]
        );

        $hall = Hall::query()->firstOrCreate(
            ['pavilion_id' => $pavilion->id, 'slug' => 'hall-a'],
            [
                'title' => 'Hall A',
                'status' => 'active',
                'total_booths' => 48,
            ]
        );

        $demoMeetings = [
            [
                'company' => 'UNBAIQ ME LLC',
                'booth_numbers' => ['U1', 'U2', 'U3', 'U4', 'U5', 'U6'],
                'status' => 'confirmed',
                'start' => now()->subMinutes(18),
                'end' => now()->addMinutes(42),
                'join_url' => 'https://meet.google.com/demo-unbaiq',
            ],
            [
                'company' => 'Google',
                'booth_numbers' => ['G1', 'G2'],
                'status' => 'confirmed',
                'start' => now()->setTime(15, 30),
                'end' => now()->setTime(16, 0),
            ],
            [
                'company' => 'Demo Pavilion',
                'booth_numbers' => ['D1'],
                'status' => 'confirmed',
                'start' => now()->addDay()->setTime(11, 0),
                'end' => now()->addDay()->setTime(11, 30),
            ],
            [
                'company' => 'Nexora Systems',
                'booth_numbers' => ['27'],
                'status' => 'pending',
                'start' => now()->addDays(5)->setTime(9, 15),
                'end' => now()->addDays(5)->setTime(9, 45),
            ],
            [
                'company' => 'Vertex Robotics',
                'booth_numbers' => ['33'],
                'status' => 'completed',
                'start' => now()->subDays(2)->setTime(14, 0),
                'end' => now()->subDays(2)->setTime(14, 30),
                'notes' => 'Discussed automation roadmap and integration timeline for Q4.',
            ],
            [
                'company' => 'Pulse Analytics',
                'booth_numbers' => ['19'],
                'status' => 'completed',
                'start' => now()->subDays(2)->setTime(16, 30),
                'end' => now()->subDays(2)->setTime(17, 0),
                'notes' => 'Reviewed dashboard demo and requested pricing follow-up.',
            ],
        ];

        foreach ($visitors as $visitor) {
            foreach ($demoMeetings as $item) {
            $company = Company::query()->firstOrCreate(
                ['email' => strtolower(str_replace(' ', '-', $item['company'])) . '@expo.demo'],
                [
                    'company_name' => $item['company'],
                    'contact_person_name' => $item['company'],
                    'phone' => '9999900000',
                    'password' => Hash::make('password'),
                    'status' => 'approved',
                ]
            );

            $boothIds = [];
            foreach ($item['booth_numbers'] as $number) {
                $booth = Booth::query()->firstOrCreate(
                    ['hall_id' => $hall->id, 'booth_number' => $number],
                    ['status' => 'booked', 'price' => 0]
                );
                $boothIds[] = $booth->id;
            }

            $booking = BoothBooking::query()->firstOrCreate(
                ['company_id' => $company->id, 'exhibition_id' => $exhibition->id],
                [
                    'pavilion_id' => $pavilion->id,
                    'hall_id' => $hall->id,
                    'booth_id' => $boothIds[0] ?? null,
                    'selected_booth_ids' => $boothIds,
                    'amount' => 0,
                    'services_amount' => 0,
                    'total_amount' => 0,
                    'payment_status' => 'paid',
                    'booking_status' => 'confirmed',
                    'admin_status' => 'approved',
                    'booth_setup_status' => 'published',
                ]
            );

            $booking->update([
                'hall_id' => $hall->id,
                'booth_id' => $boothIds[0] ?? null,
                'selected_booth_ids' => $boothIds,
            ]);

            $companyMeeting = CompanyMeeting::query()->updateOrCreate(
                [
                    'company_id' => $company->id,
                    'title' => 'Meeting with ' . $visitor->name,
                    'meeting_date' => $item['start']->toDateString(),
                ],
                [
                    'meeting_type' => 'one-to-one',
                    'start_time' => $item['start'],
                    'end_time' => $item['end'],
                    'meeting_time' => $item['start']->format('H:i:s'),
                    'meeting_link' => $item['join_url'] ?? null,
                    'zoom_join_url' => $item['join_url'] ?? null,
                    'status' => $item['status'] === 'pending' ? 'pending' : 'confirmed',
                ]
            );

            VisitorMeetingBooking::query()->updateOrCreate(
                [
                    'company_meeting_id' => $companyMeeting->id,
                    'visitor_email' => $visitor->email,
                ],
                [
                    'company_id' => $company->id,
                    'visitor_id' => $visitor->id,
                    'visitor_name' => $visitor->name,
                    'visitor_phone' => null,
                    'meeting_topic' => 'Product discussion',
                    'preferred_date' => $item['start']->toDateString(),
                    'preferred_time' => $item['start']->format('H:i:s'),
                    'status' => $item['status'],
                    'notes' => $item['notes'] ?? null,
                    'completed_at' => $item['status'] === 'completed' ? $item['end'] : null,
                ]
            );
            }
        }

        $this->command?->info('Seeded visitor portal meetings for ' . $visitors->count() . ' user(s).');
    }
}
