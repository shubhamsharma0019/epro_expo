<?php

namespace Database\Seeders;

use App\Domain\Booth\Models\Booth;
use App\Domain\Booth\Models\BoothBooking;
use App\Domain\Booth\Models\BoothSession;
use App\Domain\Company\Models\Company;
use App\Domain\Company\Models\CompanyMeeting;
use App\Domain\Event\Models\Exhibition;
use App\Domain\Event\Models\Hall;
use App\Domain\Event\Models\Pavilion;
use App\Domain\Shared\Models\User;
use App\Domain\Visitor\Models\Visitor;
use App\Domain\Visitor\Models\VisitorMeetingBooking;
use App\Domain\Visitor\Models\VisitorSessionRegistration;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class VisitorDashboardAgendaSeeder extends Seeder
{
    public function run(): void
    {
        $visitors = User::query()->orderBy('id')->get();

        if ($visitors->isEmpty()) {
            $this->command?->warn('No users found. Skipping dashboard agenda seed.');

            return;
        }

        $exhibition = Exhibition::query()->orderBy('start_date')->first();

        if (! $exhibition) {
            $this->command?->warn('No exhibition found. Skipping dashboard agenda seed.');

            return;
        }

        $pavilion = Pavilion::query()->firstOrCreate(
            ['exhibition_id' => $exhibition->id, 'slug' => 'deep-learning-pavilion'],
            ['title' => 'Deep Learning Pavilion', 'status' => 'active']
        );

        $hall = Hall::query()->firstOrCreate(
            ['pavilion_id' => $pavilion->id, 'slug' => 'hall-a'],
            ['title' => 'Hall A', 'status' => 'active', 'total_booths' => 48]
        );

        $company = Company::query()->firstOrCreate(
            ['email' => 'unbaiq-me-llc@expo.demo'],
            [
                'company_name' => 'UNBAIQ ME LLC',
                'contact_person_name' => 'UNBAIQ ME LLC',
                'phone' => '9999900001',
                'password' => Hash::make('password'),
                'status' => 'approved',
            ]
        );

        $boothIds = [];
        foreach (['U1', 'U2', 'U3', 'U4', 'U5', 'U6'] as $number) {
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
            'booth_setup_status' => 'published',
        ]);

        $today = now()->toDateString();
        $meetingStart = now()->addMinutes(25)->seconds(0);
        $meetingEnd = $meetingStart->copy()->addMinutes(30);

        $sessionStart = now()->isBefore(now()->copy()->setTime(15, 0))
            ? now()->copy()->setTime(15, 0)
            : now()->addHours(2)->minutes(0)->seconds(0);
        $sessionEnd = $sessionStart->copy()->addHour();

        $boothSession = BoothSession::query()->updateOrCreate(
            [
                'company_id' => $company->id,
                'booth_booking_id' => $booking->id,
                'title' => 'product strategy',
            ],
            [
                'description' => 'Product strategy session for visitor dashboard demo.',
                'session_date' => $today,
                'start_time' => $sessionStart->format('H:i:s'),
                'end_time' => $sessionEnd->format('H:i:s'),
                'type' => 'live_demo',
                'status' => 'upcoming',
            ]
        );

        $completedSession = BoothSession::query()->updateOrCreate(
            [
                'company_id' => $company->id,
                'booth_booking_id' => $booking->id,
                'title' => 'AI onboarding walkthrough',
            ],
            [
                'description' => 'Completed onboarding session for progress tracking.',
                'session_date' => now()->subDays(3)->toDateString(),
                'start_time' => '11:00:00',
                'end_time' => '12:00:00',
                'type' => 'live_demo',
                'status' => 'completed',
            ]
        );

        foreach ($visitors as $visitor) {
            $companyMeeting = CompanyMeeting::query()->updateOrCreate(
                [
                    'company_id' => $company->id,
                    'title' => 'Dashboard meeting with ' . $visitor->name,
                    'meeting_date' => $today,
                ],
                [
                    'meeting_type' => 'one-to-one',
                    'start_time' => $meetingStart,
                    'end_time' => $meetingEnd,
                    'meeting_time' => $meetingStart->format('H:i:s'),
                    'meeting_link' => 'https://meet.google.com/demo-unbaiq-dashboard',
                    'zoom_join_url' => 'https://meet.google.com/demo-unbaiq-dashboard',
                    'status' => 'confirmed',
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
                    'meeting_topic' => 'Product discussion',
                    'preferred_date' => $today,
                    'preferred_time' => $meetingStart->format('H:i:s'),
                    'status' => 'confirmed',
                ]
            );

            $visitorPass = Visitor::query()
                ->where('exhibition_id', $exhibition->id)
                ->whereRaw('LOWER(email) = ?', [strtolower($visitor->email)])
                ->first();

            VisitorSessionRegistration::query()->updateOrCreate(
                [
                    'booth_session_id' => $boothSession->id,
                    'exhibition_id' => $exhibition->id,
                    'user_id' => $visitor->id,
                ],
                [
                    'visitor_booking_id' => $visitorPass?->booking_id,
                    'visitor_email' => $visitor->email,
                    'status' => 'registered',
                ]
            );

            VisitorSessionRegistration::query()->updateOrCreate(
                [
                    'booth_session_id' => $completedSession->id,
                    'exhibition_id' => $exhibition->id,
                    'user_id' => $visitor->id,
                ],
                [
                    'visitor_booking_id' => $visitorPass?->booking_id,
                    'visitor_email' => $visitor->email,
                    'status' => 'completed',
                ]
            );
        }

        $this->command?->info('Seeded dashboard agenda data for ' . $visitors->count() . ' user(s).');
    }
}
