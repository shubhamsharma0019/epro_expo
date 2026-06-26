<?php

namespace Database\Seeders;

use App\Domain\Admin\Models\Admin;
use App\Domain\Event\Models\AgendaSession;
use App\Domain\Booth\Models\Booth;
use App\Domain\Booth\Models\BoothBooking;
use App\Domain\Booth\Models\BoothBranding;
use App\Domain\Booth\Models\BoothProfile;
use App\Domain\Booth\Models\BoothPublishRequest;
use App\Domain\Booth\Models\BoothSize;
use App\Domain\Company\Models\Company;
use App\Domain\Event\Models\CompanyEvent\CompanyEvent;
use App\Domain\Event\Models\CompanyEvent\CompanyEventBranding;
use App\Domain\Event\Models\CompanyEvent\CompanyEventPublishRequest;
use App\Domain\Event\Models\CompanyEvent\CompanyEventSession;
use App\Domain\Event\Models\CompanyEvent\CompanyEventSpeaker;
use App\Domain\Event\Models\CompanyEvent\CompanyEventTicketType;
use App\Domain\Event\Models\Exhibition;
use App\Domain\Event\Models\Hall;
use App\Domain\Event\Models\Pavilion;
use App\Domain\Event\Models\Speaker;
use App\Domain\Event\Models\Sponsor;
use App\Domain\Shared\Models\User;
use App\Domain\Visitor\Models\VisitorTicket;
use App\Support\HallBoothLayoutSync;
use App\Support\LiveContent;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Seeds a dedicated mock exhibition + event (not global-tech-expo-2024)
 * for company, visitor, and admin flow verification.
 *
 * Run: php artisan db:seed --class=MockFlowDemoSeeder
 */
class MockFlowDemoSeeder extends Seeder
{
    public const EXHIBITION_SLUG = 'smart-healthcare-innovation-expo-2026';

    public const EVENT_SLUG = 'digital-leadership-forum-2026';

    public function run(): void
    {
        $admin = Admin::query()->first();

        $company = Company::updateOrCreate(
            ['email' => 'company@example.com'],
            [
                'company_name' => 'TechNova Solutions',
                'contact_person_name' => 'Shubham Sharma',
                'phone' => '9876543210',
                'website' => 'https://technova.example.com',
                'industry' => 'Software & AI Solutions',
                'city' => 'New Delhi',
                'country' => 'India',
                'password' => Hash::make('password'),
                'status' => 'approved',
            ]
        );

        $exhibition = $this->seedExhibition();
        $this->seedExhibitionVenue($exhibition);
        $booking = $this->seedPublishedBooth($exhibition, $company, $admin);
        $this->seedExhibitionContent($exhibition);
        $event = $this->seedLiveEvent($company, $admin);
        $this->seedVisitorTicket($event);

        $this->command?->info('');
        $this->command?->info('=== Mock flow demo seeded ===');
        $this->command?->table(
            ['Item', 'Slug / login', 'Visible on website'],
            [
                ['Exhibition', self::EXHIBITION_SLUG, $exhibition->isLiveForVisitors() ? 'Yes' : 'No'],
                ['Event', self::EVENT_SLUG, $event->isLiveForVisitors() ? 'Yes' : 'No'],
                ['Company login', 'company@example.com / password', 'Booth + event live'],
                ['Exhibition', self::EXHIBITION_SLUG, 'Browse as company@example.com'],
            ]
        );
        $this->command?->info('Visitor URLs:');
        $this->command?->line('  /exhibitions/' . self::EXHIBITION_SLUG);
        $this->command?->line('  /exhibitions/' . self::EXHIBITION_SLUG . '/companies');
        $this->command?->line('  /events/listings/' . self::EVENT_SLUG);
        $this->command?->line('  /events/tickets/select?event=' . self::EVENT_SLUG);
        $this->command?->info('');
        $this->command?->info('Live counts: exhibitions=' . LiveContent::exhibitionQuery()->count()
            . ', events=' . LiveContent::companyEventQuery()->count()
            . ', public booths=' . LiveContent::boothBookingQuery()->count());
        if ($booking) {
            $this->command?->info('Exhibitor booth slug: ' . Str::slug($company->company_name));
        }
    }

    private function seedExhibition(): Exhibition
    {
        return Exhibition::updateOrCreate(
            ['slug' => self::EXHIBITION_SLUG],
            [
                'name' => 'Smart Healthcare Innovation Expo 2026',
                'title' => 'Smart Healthcare Innovation Expo 2026',
                'description' => 'Mock exhibition for end-to-end flow testing — digital health, med-tech, and hospital innovation (not Global Tech Expo).',
                'location' => 'Hyderabad, India',
                'venue' => 'HITEC City Convention Centre',
                'start_date' => now()->addMonths(2)->startOfDay(),
                'end_date' => now()->addMonths(2)->addDays(2)->endOfDay(),
                'banner_image' => 'images/exhibitions/hero-pavilion-scene.png',
                'banner_url' => 'images/exhibitions/hero-pavilion-scene.png',
                'companies_count' => 24,
                'status' => 'active',
                'approval_status' => 'approved',
                'publish_status' => 'published',
                'approved_at' => now(),
                'published_at' => now(),
                'is_home_featured' => true,
            ]
        );
    }

    private function seedExhibitionVenue(Exhibition $exhibition): void
    {
        $boothSize = BoothSize::query()->where('status', 'active')->first()
            ?? BoothSize::updateOrCreate(
                ['title' => '3m x 3m Mock'],
                [
                    'width' => 3,
                    'height' => 3,
                    'area' => 9,
                    'price' => 599,
                    'description' => 'Mock booth size for flow demo',
                    'status' => 'active',
                ]
            );

        $pavilion = Pavilion::updateOrCreate(
            [
                'exhibition_id' => $exhibition->id,
                'slug' => 'healthcare-innovation-pavilion',
            ],
            [
                'title' => 'Healthcare Innovation Pavilion',
                'description' => 'Med-tech, diagnostics, and digital care solutions',
                'image' => 'assets/images/pavilions/healthcare-pavilion.png',
                'total_halls' => 1,
                'total_booths' => 40,
                'status' => 'active',
            ]
        );

        $hall = Hall::updateOrCreate(
            [
                'pavilion_id' => $pavilion->id,
                'slug' => 'hall-1-digital-health',
            ],
            [
                'title' => 'Hall 1 — Digital Health',
                'description' => 'Hospital systems, telemedicine, and patient platforms',
                'image' => 'assets/images/pavilions/healthcare-pavilion.png',
                'total_booths' => 40,
                'status' => 'active',
            ]
        );

        $boothSizes = HallBoothLayoutSync::resolveBoothSizes();
        if ($boothSizes->isEmpty()) {
            $boothSizes = collect([$boothSize]);
        }

        HallBoothLayoutSync::sync($hall, $boothSizes);
    }

    private function seedPublishedBooth(Exhibition $exhibition, Company $company, ?Admin $admin): ?BoothBooking
    {
        $pavilion = $exhibition->pavilions()->first();
        $hall = $pavilion?->halls()->first();
        $booth = $hall?->booths()->where('booth_number', 'B01')->first();
        $boothSize = $booth?->boothSize ?? BoothSize::query()->first();

        if (! $pavilion || ! $hall || ! $booth || ! $boothSize) {
            $this->command?->warn('Could not create mock booth — pavilion/hall/booth missing.');

            return null;
        }

        $booking = BoothBooking::updateOrCreate(
            [
                'company_id' => $company->id,
                'exhibition_id' => $exhibition->id,
                'booth_id' => $booth->id,
            ],
            [
                'pavilion_id' => $pavilion->id,
                'hall_id' => $hall->id,
                'booth_size_id' => $boothSize->id,
                'selected_booth_ids' => [$booth->id],
                'amount' => $boothSize->price,
                'services_amount' => 0,
                'total_amount' => $boothSize->price,
                'payment_status' => 'paid',
                'booking_status' => 'confirmed',
                'admin_status' => 'approved',
                'booth_setup_status' => 'published',
                'paid_at' => now(),
                'approved_at' => now(),
                'approved_by' => $admin?->id,
            ]
        );

        $booth->update(['status' => 'booked']);

        BoothProfile::updateOrCreate(
            ['booth_booking_id' => $booking->id],
            [
                'company_id' => $company->id,
                'booth_title' => 'MedPulse Digital Care Hub',
                'company_name' => $company->company_name,
                'contact_person' => $company->contact_person_name,
                'email' => $company->email,
                'phone' => $company->phone,
                'tagline' => 'Smarter diagnostics for modern hospitals',
                'website' => $company->website,
                'about_company' => 'MedPulse Systems builds AI-assisted diagnostic workflows and remote patient monitoring for hospitals and clinics.',
                'industry' => 'Healthcare',
                'country' => 'India',
            ]
        );

        BoothBranding::updateOrCreate(
            ['booth_booking_id' => $booking->id],
            [
                'company_id' => $company->id,
                'primary_color' => '#0F766E',
                'secondary_color' => '#14B8A6',
            ]
        );

        BoothPublishRequest::updateOrCreate(
            ['booth_booking_id' => $booking->id],
            [
                'company_id' => $company->id,
                'status' => 'approved',
                'submitted_at' => now()->subDay(),
                'reviewed_at' => now(),
                'reviewed_by' => $admin?->id,
            ]
        );

        return $booking;
    }

    private function seedExhibitionContent(Exhibition $exhibition): void
    {
        Speaker::updateOrCreate(
            [
                'exhibition_id' => $exhibition->id,
                'name' => 'Dr. Priya Nair',
            ],
            [
                'title' => 'Chief Medical Informatics Officer',
                'company' => 'Apollo Digital Health',
                'bio' => 'Leading hospital digitization and clinical AI governance programs across South Asia.',
                'avatar_url' => 'https://randomuser.me/api/portraits/women/65.jpg',
            ]
        );

        AgendaSession::updateOrCreate(
            [
                'exhibition_id' => $exhibition->id,
                'title' => 'Keynote: AI in Clinical Decision Support',
            ],
            [
                'description' => 'How machine learning augments clinicians without replacing judgment.',
                'speaker_name' => 'Dr. Priya Nair',
                'start_time' => '10:30 AM',
                'end_time' => '11:15 AM',
                'hall_name' => 'Hall 1 — Digital Health',
            ]
        );

        Sponsor::updateOrCreate(
            [
                'exhibition_id' => $exhibition->id,
                'name' => 'HealthGrid Labs',
            ],
            [
                'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/2/2f/Google_2015_logo.svg',
                'level' => 'Platinum',
            ]
        );
    }

    private function seedLiveEvent(Company $company, ?Admin $admin): CompanyEvent
    {
        $event = CompanyEvent::updateOrCreate(
            ['slug' => self::EVENT_SLUG],
            [
                'company_id' => $company->id,
                'title' => 'Digital Leadership Forum 2026',
                'event_type' => 'in_person',
                'category' => 'Leadership',
                'sub_category' => 'Technology',
                'event_mode' => 'hybrid',
                'status' => 'published',
                'publish_status' => 'published',
                'visibility' => 'public',
                'starts_at' => now()->addMonths(3)->setTime(9, 0),
                'ends_at' => now()->addMonths(3)->addDays(1)->setTime(18, 0),
                'timezone' => 'Asia/Kolkata',
                'venue_name' => 'India Habitat Centre',
                'venue_address' => 'Lodhi Road, New Delhi',
                'city' => 'New Delhi',
                'country' => 'India',
                'website' => 'https://summitpro.example.com/digital-leadership-forum',
                'summary' => 'Mock live event for company and visitor flow testing (not Global Tech Expo).',
                'description' => 'Executive sessions on digital transformation, AI strategy, and building high-performing technology teams.',
                'highlights' => ['CIO roundtables', 'Live workshops', 'Networking lounge'],
                'capacity' => 500,
                'submitted_at' => now()->subWeek(),
                'published_at' => now(),
                'is_home_featured' => true,
            ]
        );

        CompanyEventBranding::updateOrCreate(
            ['company_event_id' => $event->id],
            [
                'company_id' => $company->id,
                'logo_path' => 'company-events/seeded/digital-leadership-logo.svg',
                'banner_path' => 'company-events/seeded/digital-leadership-banner.png',
                'primary_color' => '#1C1364',
                'secondary_color' => '#4C10D0',
                'accent_color' => '#10B981',
                'theme_template' => 'modern',
                'headline' => 'Lead the Digital Shift',
                'tagline' => 'Strategy, culture, and technology for modern leaders',
            ]
        );

        CompanyEventTicketType::updateOrCreate(
            [
                'company_event_id' => $event->id,
                'name' => 'Standard Delegate Pass',
            ],
            [
                'company_id' => $company->id,
                'description' => 'Full access to keynotes and expo floor',
                'price' => 1499,
                'currency' => 'INR',
                'quantity_total' => 200,
                'quantity_sold' => 12,
                'sales_start_at' => now()->subWeek(),
                'sales_end_at' => $event->starts_at,
                'status' => 'active',
                'benefits' => ['Keynotes', 'Lunch', 'Networking'],
            ]
        );

        CompanyEventTicketType::updateOrCreate(
            [
                'company_event_id' => $event->id,
                'name' => 'VIP Executive Pass',
            ],
            [
                'company_id' => $company->id,
                'description' => 'VIP lounge + roundtable access',
                'price' => 4999,
                'currency' => 'INR',
                'quantity_total' => 50,
                'quantity_sold' => 5,
                'sales_start_at' => now()->subWeek(),
                'sales_end_at' => $event->starts_at,
                'status' => 'active',
                'benefits' => ['VIP lounge', 'Roundtables', 'Meet & greet'],
            ]
        );

        CompanyEventSession::updateOrCreate(
            [
                'company_event_id' => $event->id,
                'title' => 'Opening Keynote: Leading Through Disruption',
            ],
            [
                'company_id' => $company->id,
                'description' => 'Frameworks for resilient leadership in volatile markets.',
                'starts_at' => $event->starts_at,
                'ends_at' => $event->starts_at?->copy()->addHour(),
                'session_type' => 'keynote',
                'location' => 'Main Auditorium',
                'status' => 'upcoming',
            ]
        );

        CompanyEventSpeaker::updateOrCreate(
            [
                'company_event_id' => $event->id,
                'name' => 'Rina Kapoor',
            ],
            [
                'company_id' => $company->id,
                'designation' => 'Former CTO',
                'organization' => 'FinEdge',
                'bio' => 'Advisor to Fortune 500 boards on technology strategy.',
                'status' => 'active',
            ]
        );

        CompanyEventPublishRequest::updateOrCreate(
            ['company_event_id' => $event->id],
            [
                'company_id' => $company->id,
                'status' => 'approved',
                'company_notes' => 'Mock event ready for visitor bookings.',
                'review_notes' => 'Approved for demo seed.',
                'reviewed_by' => $admin?->id,
                'submitted_at' => now()->subWeek(),
                'reviewed_at' => now(),
            ]
        );

        return $event;
    }

    private function seedVisitorTicket(CompanyEvent $event): void
    {
        $visitor = User::updateOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Test Visitor',
                'password' => Hash::make('password'),
            ]
        );

        $ticketType = $event->ticketTypes()->first();

        VisitorTicket::updateOrCreate(
            [
                'user_id' => $visitor->id,
                'company_event_id' => $event->id,
                'order_number' => 'MOCK-DLF-2026-001',
            ],
            [
                'ticket_type_id' => $ticketType?->id,
                'ticket_name' => $ticketType?->name ?? 'Standard Delegate Pass',
                'quantity' => 1,
                'total_amount' => $ticketType?->price ?? 1499,
                'status' => 'confirmed',
                'event_slug' => self::EVENT_SLUG,
                'attendee_name' => $visitor->name,
                'attendee_email' => $visitor->email,
            ]
        );
    }
}
