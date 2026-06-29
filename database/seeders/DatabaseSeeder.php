<?php

namespace Database\Seeders;

use App\Domain\Shared\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (! filter_var(env('APP_SEED_BASE', false), FILTER_VALIDATE_BOOLEAN)) {
            return;
        }

        // User::factory(10)->create();

        User::updateOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Test User',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
            ]
        );

        // Seed default Admin
        \App\Domain\Admin\Models\Admin::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'phone' => '1234567890',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'role' => 'admin',
                'status' => 'active',
            ]
        );

        // Optional demo company login (does not replace real MySQL data).
        \App\Domain\Company\Models\Company::updateOrCreate(
            ['email' => 'company@example.com'],
            [
                'company_name' => 'TechNova Solutions',
                'contact_person_name' => 'Shubham Sharma',
                'phone' => '9876543210',
                'website' => 'https://technova.example.com',
                'industry' => 'Software & AI Solutions',
                'city' => 'New Delhi',
                'country' => 'India',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'status' => 'approved',
            ]
        );

        // Mock exhibition + event for flow testing (distinct from global-tech-expo-2024).
        if (filter_var(env('MOCK_FLOW_SEED', false), FILTER_VALIDATE_BOOLEAN)) {
            $this->call(MockFlowDemoSeeder::class);
        }

        // Demo pavilion/exhibitor data only when explicitly enabled (never required for production).
        if (! filter_var(env('APP_SEED_DEMO', false), FILTER_VALIDATE_BOOLEAN)) {
            return;
        }

        $company = \App\Domain\Company\Models\Company::where('email', 'company@example.com')->firstOrFail();

        $this->call(CompanyPavilionDemoSeeder::class);

        // Keep the public mock event available inside the default company dashboard too.
        $digitalLeadershipEvent = \App\Domain\Event\Models\CompanyEvent\CompanyEvent::where('slug', 'digital-leadership-forum-2026')->first();
        if ($digitalLeadershipEvent && $digitalLeadershipEvent->company_id !== $company->id) {
            $digitalLeadershipEvent->update(['company_id' => $company->id]);

            \App\Domain\Event\Models\CompanyEvent\CompanyEventBranding::where('company_event_id', $digitalLeadershipEvent->id)
                ->update(['company_id' => $company->id]);
            \App\Domain\Event\Models\CompanyEvent\CompanyEventTicketType::where('company_event_id', $digitalLeadershipEvent->id)
                ->update(['company_id' => $company->id]);
            \App\Domain\Event\Models\CompanyEvent\CompanyEventSession::where('company_event_id', $digitalLeadershipEvent->id)
                ->update(['company_id' => $company->id]);
            \App\Domain\Event\Models\CompanyEvent\CompanyEventSpeaker::where('company_event_id', $digitalLeadershipEvent->id)
                ->update(['company_id' => $company->id]);
            \App\Domain\Event\Models\CompanyEvent\CompanyEventPublishRequest::where('company_event_id', $digitalLeadershipEvent->id)
                ->update(['company_id' => $company->id]);
        }

        $bootCampEvent = \App\Domain\Event\Models\CompanyEvent\CompanyEvent::updateOrCreate(
            ['slug' => 'hands-on-ui-ux-design-boot-camp'],
            [
                'company_id' => $company->id,
                'title' => 'Hands-on UI/UX Design Boot Camp',
                'event_type' => 'in_person',
                'category' => 'Education',
                'sub_category' => 'Product Design',
                'event_mode' => 'in_person',
                'status' => 'published',
                'publish_status' => 'published',
                'starts_at' => '2026-07-24 10:00:00',
                'ends_at' => '2026-07-25 17:00:00',
                'timezone' => 'Asia/Kolkata',
                'venue_name' => 'Creative Arts Hub',
                'venue_address' => 'Sector 5, Bangalore, India',
                'city' => 'Bangalore',
                'country' => 'India',
                'website' => 'https://designbootcamp.in',
                'summary' => 'An intensive in-person workshop for product design teams.',
                'description' => 'An intensive interactive in-person workshop focusing on modern design tokens, design systems, user research frameworks, and advanced prototyping methods.',
                'highlights' => [
                    '2 days hands-on boot camp',
                    'In-person UI/UX workshop experience',
                    'Design systems, research, and prototyping sessions',
                    'Creative Arts Hub, Bangalore',
                ],
                'capacity' => 0,
                'visibility' => 'public',
                'published_at' => now(),
                'is_home_featured' => true,
            ]
        );

        \App\Domain\Event\Models\CompanyEvent\CompanyEventBranding::updateOrCreate(
            ['company_event_id' => $bootCampEvent->id],
            [
                'company_id' => $company->id,
                'logo_path' => 'company-events/seeded/hands-on-uiux-logo.jpg',
                'banner_path' => 'company-events/seeded/hands-on-uiux-banner.jpg',
                'primary_color' => '#4C10D0',
                'secondary_color' => '#00B894',
                'accent_color' => '#FF8A00',
                'headline' => 'Hands-on UI/UX Design Boot Camp',
                'tagline' => 'Practical design systems, research, and prototyping for product teams.',
                'cta_label' => 'Explore Event',
            ]
        );

        \App\Domain\Event\Models\CompanyEvent\CompanyEventTicketType::updateOrCreate(
            [
                'company_event_id' => $bootCampEvent->id,
                'name' => 'Workshop Pass',
            ],
            [
                'company_id' => $company->id,
                'description' => 'Access to the hands-on UI/UX design boot camp sessions.',
                'price' => 0,
                'currency' => 'INR',
                'quantity_total' => 100,
                'quantity_sold' => 0,
                'sales_start_at' => now()->subDay(),
                'sales_end_at' => $bootCampEvent->starts_at,
                'status' => 'active',
                'benefits' => ['Hands-on workshop access', 'Design systems sessions', 'Research and prototyping practice'],
            ]
        );

        // Create an approved booking for this company to start in active state
        $exhibition = \App\Domain\Event\Models\Exhibition::where('slug', 'global-tech-expo-2024')->first();
        if ($exhibition) {
            $pavilion = $exhibition->pavilions()->first();
            $hall = $pavilion ? $pavilion->halls()->first() : null;
            $size = \App\Domain\Booth\Models\BoothSize::first();
            $booth = $hall ? $hall->booths()->where('status', 'available')->first() : null;

            if ($hall && $size && $booth) {
                // Book booth
                $booth->update(['status' => 'booked']);

                $booking = \App\Domain\Booth\Models\BoothBooking::create([
                    'company_id' => $company->id,
                    'exhibition_id' => $exhibition->id,
                    'pavilion_id' => $pavilion->id,
                    'hall_id' => $hall->id,
                    'booth_size_id' => $size->id,
                    'booth_id' => $booth->id,
                    'selected_booth_ids' => [$booth->id],
                    'amount' => $size->price,
                    'services_amount' => 0,
                    'total_amount' => $size->price,
                    'payment_status' => 'paid',
                    'booking_status' => 'confirmed',
                    'admin_status' => 'approved',
                    'paid_at' => now(),
                    'approved_at' => now(),
                ]);

                // Create a basic profile for this booth
                \App\Domain\Booth\Models\BoothProfile::create([
                    'booth_booking_id' => $booking->id,
                    'company_id' => $company->id,
                    'booth_title' => 'TechNova AI Studio',
                    'company_name' => $company->company_name,
                    'contact_person' => $company->contact_person_name,
                    'email' => $company->email,
                    'phone' => $company->phone,
                    'tagline' => 'Innovating the Future Together',
                    'website' => $company->website,
                    'about_company' => 'TechNova Solutions is a leading AI and software systems integrator specializing in enterprise digitalization.',
                ]);

                // Seed some default enquiries
                \App\Domain\Company\Models\Enquiry::create([
                    'company_id' => $company->id,
                    'name' => 'Priya Mehta',
                    'email' => 'priya@example.com',
                    'phone' => '9999911111',
                    'subject' => 'Interested in AI Workflow Studio',
                    'message' => 'We visited your booth and would like to schedule a product walkthrough for our operations team.',
                    'status' => 'new',
                ]);

                \App\Domain\Company\Models\Enquiry::create([
                    'company_id' => $company->id,
                    'name' => 'Rahul Shah',
                    'email' => 'rahul@example.com',
                    'phone' => '9999922222',
                    'subject' => 'Requesting product pricing',
                    'message' => 'Please share the enterprise licensing cost structure for the engagement CRM.',
                    'status' => 'open',
                ]);

                // Seed a default meeting slot & booking
                $meeting = \App\Domain\Company\Models\CompanyMeeting::create([
                    'company_id' => $company->id,
                    'title' => 'Product Walkthrough',
                    'meeting_type' => 'one_on_one',
                    'start_time' => now()->addDay()->setTime(11, 30),
                    'end_time' => now()->addDay()->setTime(12, 0),
                    'max_attendees' => 2,
                    'description' => 'Discussion regarding AI Workflow Studio integrations.',
                ]);

                \App\Domain\Visitor\Models\VisitorMeetingBooking::create([
                    'company_meeting_id' => $meeting->id,
                    'company_id' => $company->id,
                    'visitor_name' => 'Priya Mehta',
                    'visitor_email' => 'priya@example.com',
                    'visitor_phone' => '9999911111',
                    'message' => 'Looking forward to the workflow demo.',
                    'status' => 'pending',
                ]);
            }
        }

        // Seed visitor flow tables
        // 1. Update/create exhibitions for visitor flow
        \App\Domain\Event\Models\Exhibition::updateOrCreate(
            ['slug' => 'global-tech-expo-2024'],
            [
                'name' => 'Global Tech Summit 2024',
                'title' => 'Global Tech Expo 2024',
                'slug' => 'global-tech-expo-2024',
                'description' => 'A premium exhibition for technology, business, healthcare, education, sustainability, and mobility companies.',
                'location' => 'Virtual Expo',
                'start_date' => '2026-06-12',
                'end_date' => '2026-06-14',
                'banner_image' => 'images/exhibitions/hero-book-exhibition.png',
                'status' => 'active',
                'name' => 'Global Tech Summit 2024',
                'venue' => 'Jio World Convention Centre, Mumbai, India',
                'companies_count' => 120,
                'banner_url' => 'https://images.unsplash.com/photo-1639322537228-f710d846310a?auto=format&fit=crop&w=800&q=80',
            ]
        );

        \App\Domain\Event\Models\Exhibition::updateOrCreate(
            ['slug' => 'future-of-ai-expo'],
            [
                'name' => 'Future of AI Expo',
                'title' => 'Future of AI Expo',
                'slug' => 'future-of-ai-expo',
                'description' => 'Explore deep neural structures, machine learning platforms, and automation algorithms.',
                'location' => 'Bengaluru Convention Centre',
                'start_date' => '2026-06-10',
                'end_date' => '2026-06-12',
                'banner_image' => 'https://images.unsplash.com/photo-1485827404703-89b55fcc595e?auto=format&fit=crop&w=800&q=80',
                'status' => 'active',
                'name' => 'Future of AI Expo',
                'venue' => 'Bengaluru Convention Centre, Bengaluru, India',
                'companies_count' => 80,
                'banner_url' => 'https://images.unsplash.com/photo-1485827404703-89b55fcc595e?auto=format&fit=crop&w=800&q=80',
            ]
        );

        \App\Domain\Event\Models\Exhibition::updateOrCreate(
            ['slug' => 'sustainability-world-expo'],
            [
                'name' => 'Sustainability World Expo',
                'title' => 'Sustainability World Expo',
                'slug' => 'sustainability-world-expo',
                'description' => 'Innovations in green architecture, eco-friendly systems, and global sustainability standards.',
                'location' => 'Pune International Exhibition Centre',
                'start_date' => '2026-08-08',
                'end_date' => '2026-08-10',
                'banner_image' => 'https://images.unsplash.com/photo-1466611653911-95081537e5b7?auto=format&fit=crop&w=800&q=80',
                'status' => 'active',
                'name' => 'Sustainability World Expo',
                'venue' => 'Pune International Exhibition Centre, Pune, India',
                'companies_count' => 85,
                'banner_url' => 'https://images.unsplash.com/photo-1466611653911-95081537e5b7?auto=format&fit=crop&w=800&q=80',
            ]
        );

        $visitorFlowExhibitionId = \App\Domain\Event\Models\Exhibition::where('slug', 'global-tech-expo-2024')->value('id') ?? 1;

        // 2. Visitor Pavilions
        $pavilions = [
            [
                'id' => 'tech',
                'title' => 'Technology & AI',
                'badge' => 'AI SOLUTIONS',
                'subtitle' => 'Innovate the future with intelligent solutions',
                'description' => 'Step into the future with breakthrough technologies in artificial intelligence, machine learning, automation, data analytics, and next-gen enterprise solutions.',
                'image_url' => 'https://images.unsplash.com/photo-1485827404703-89b55fcc595e?auto=format&fit=crop&w=800&q=80',
                'companies_count' => '8+ Companies',
                'products_count' => '120+ Products',
                'visitors_count' => '2,500+ Visitors',
                'category' => 'Technology',
                'about_desc' => '<p class="text-[13px] text-gray-600 leading-relaxed mb-4 pr-6">The Technology & AI Pavilion brings together leading innovators and solution providers who are transforming industries through artificial intelligence, machine learning, data analytics, cloud computing, and intelligent automation.</p><p class="text-[13px] text-gray-600 leading-relaxed pr-6">Explore cutting-edge solutions, connect with experts, and discover how emerging technologies can drive growth and efficiency for your business.</p>'
            ],
            [
                'id' => 'manufacturing',
                'title' => 'Manufacturing & Pharma',
                'badge' => 'MANUFACTURING',
                'subtitle' => 'Discover innovations in manufacturing and pharmaceutical industries.',
                'description' => 'Explore the latest in automated production lines, pharmaceutical research, and industrial automation shaping the future of global supply chains.',
                'image_url' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=800&q=80',
                'companies_count' => '20+ Companies',
                'products_count' => '350+ Products',
                'visitors_count' => '4,200+ Visitors',
                'category' => 'Manufacturing',
                'about_desc' => '<p class="text-[13px] text-gray-600 leading-relaxed mb-4 pr-6">The Manufacturing & Pharma Pavilion showcases state-of-the-art production technologies and pharmaceutical breakthroughs.</p><p class="text-[13px] text-gray-600 leading-relaxed pr-6">Join industry leaders to explore automated manufacturing, quality control tech, and innovative supply chain solutions.</p>'
            ],
            [
                'id' => 'smart',
                'title' => 'Smart Manufacturing',
                'badge' => 'SMART FACTORY',
                'subtitle' => 'Experience smart factories, automation, and industrial IoT.',
                'description' => 'Dive into the world of Industry 4.0 with live demonstrations of IoT devices, smart sensors, and fully automated robotics systems.',
                'image_url' => 'https://images.unsplash.com/photo-1565514020179-026b92b84bb6?auto=format&fit=crop&w=800&q=80',
                'companies_count' => '15+ Companies',
                'products_count' => '200+ Products',
                'visitors_count' => '3,100+ Visitors',
                'category' => 'Industrial IoT',
                'about_desc' => '<p class="text-[13px] text-gray-600 leading-relaxed mb-4 pr-6">The Smart Manufacturing Pavilion is dedicated to the evolution of factories and production environments through connectivity.</p><p class="text-[13px] text-gray-600 leading-relaxed pr-6">Discover IoT solutions, advanced robotics, and real-time data analytics designed to maximize industrial efficiency.</p>'
            ],
            [
                'id' => 'green',
                'title' => 'Green Energy',
                'badge' => 'SUSTAINABILITY',
                'subtitle' => 'Find sustainable energy solutions for a greener planet.',
                'description' => 'Discover solutions for a greener and sustainable tomorrow. Explore renewable energy sources, green tech, and ESG solutions.',
                'image_url' => 'https://images.unsplash.com/photo-1466611653911-95081537e5b7?auto=format&fit=crop&w=800&q=80',
                'companies_count' => '50+ Companies',
                'products_count' => '85+ Products',
                'visitors_count' => '5,000+ Visitors',
                'category' => 'Renewable Energy',
                'about_desc' => '<p class="text-[13px] text-gray-600 leading-relaxed mb-4 pr-6">The Green Energy Pavilion brings together innovative companies focused on building a better, more sustainable future.</p><p class="text-[13px] text-gray-600 leading-relaxed pr-6">Explore products, solutions, and insights driving sustainability across industries, including solar, wind, and circular economy.</p>'
            ],
            [
                'id' => 'startups',
                'title' => 'Startups',
                'badge' => 'INNOVATION',
                'subtitle' => 'Meet innovative startups and future disruptors.',
                'description' => 'Connect with the brightest minds and rising companies that are disrupting traditional industries with fresh ideas and agile execution.',
                'image_url' => 'https://images.unsplash.com/photo-1559136555-9ce7b5fda016?auto=format&fit=crop&w=800&q=80',
                'companies_count' => '60+ Companies',
                'products_count' => '150+ Products',
                'visitors_count' => '6,500+ Visitors',
                'category' => 'Startups',
                'about_desc' => '<p class="text-[13px] text-gray-600 leading-relaxed mb-4 pr-6">The Startups Pavilion is a buzzing hub of innovation, featuring young companies with groundbreaking technologies and solutions.</p><p class="text-[13px] text-gray-600 leading-relaxed pr-6">Network with founders, experience raw innovation, and discover the next big disruptors before they hit the mainstream market.</p>'
            ]
        ];

        foreach ($pavilions as $p) {
            \App\Domain\Visitor\Models\VisitorPavilion::updateOrCreate(['id' => $p['id']], $p);
        }

        // 3. Visitor Halls
        $halls = [
            [
                'id' => 'hall1',
                'badge' => 'Hall 1',
                'title' => 'Hall 1 – AI & IA',
                'subtitle' => 'Artificial Intelligence & Intelligent Automation solutions.',
                'description' => 'Explore the latest in AI, machine learning, robotic process automation, and intelligent systems that are transforming industries.',
                'image_url' => 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&fit=crop&w=800&q=80',
                'category' => 'Technology',
                'area' => '12,500 sqm',
                'exhibitors_count' => '45+',
                'booths_count' => '350+'
            ],
            [
                'id' => 'hall2',
                'badge' => 'Hall 2',
                'title' => 'Hall 2 – Cloud & DevOps',
                'subtitle' => 'Cloud computing, DevOps, and infrastructure solutions.',
                'description' => 'Discover next-generation cloud platforms, containerization strategies, and robust DevOps pipelines accelerating digital transformation.',
                'image_url' => 'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?auto=format&fit=crop&w=800&q=80',
                'category' => 'Infrastructure',
                'area' => '10,000 sqm',
                'exhibitors_count' => '38+',
                'booths_count' => '280+'
            ],
            [
                'id' => 'hall3',
                'badge' => 'Hall 3',
                'title' => 'Hall 3 – Green Energy',
                'subtitle' => 'Renewable energy, sustainability, and environmental solutions.',
                'description' => 'Connect with leaders in solar, wind, and sustainable manufacturing working towards a zero-carbon, greener future.',
                'image_url' => 'https://images.unsplash.com/photo-1466611653911-95081537e5b7?auto=format&fit=crop&w=800&q=80',
                'category' => 'Sustainability',
                'area' => '11,200 sqm',
                'exhibitors_count' => '32+',
                'booths_count' => '220+'
            ],
            [
                'id' => 'hall4',
                'badge' => 'Hall 4',
                'title' => 'Hall 4 – Manufacturing',
                'subtitle' => 'Smart manufacturing, robotics, and industrial automation.',
                'description' => 'Experience live demonstrations of heavy machinery, smart factory layouts, and collaborative robotics on the exhibition floor.',
                'image_url' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=800&q=80',
                'category' => 'Industrial',
                'area' => '14,000 sqm',
                'exhibitors_count' => '40+',
                'booths_count' => '310+'
            ]
        ];

        foreach ($halls as $h) {
            \App\Domain\Visitor\Models\VisitorHall::updateOrCreate(['id' => $h['id']], $h);
        }

        // 4. Exhibitors
        $exhibitors = [
            [
                'id' => 101,
                'exhibition_id' => $visitorFlowExhibitionId,
                'hall_name' => 'Hall 1 - AI & IA',
                'booth_number' => 'Booth 101',
                'name' => 'TechNext Solutions Pvt. Ltd.',
                'category' => 'AI & Automation',
                'description' => 'Delivering next-gen AI and automation solutions that empower enterprises to innovate, optimize, and accelerate growth.',
                'website' => 'www.technext.com',
                'email' => 'info@technext.com',
                'country' => 'India',
                'rep_name' => 'Rahul Sharma',
                'rep_title' => 'Business Development Manager',
                'rep_email' => 'rahul.sharma@technext.com',
                'rep_phone' => '+91 98765 43210',
                'rep_img_url' => 'https://randomuser.me/api/portraits/men/32.jpg',
                'logo_color' => 'bg-blue-500',
                'logo_text' => 'TN'
            ],
            [
                'id' => 102,
                'exhibition_id' => $visitorFlowExhibitionId,
                'hall_name' => 'Hall 1 - AI & IA',
                'booth_number' => 'Booth 102',
                'name' => 'InnovaAI Labs',
                'category' => 'Machine Learning',
                'description' => 'Building intelligent models for real-world impact and actionable data analytics.',
                'website' => 'www.innovaalabs.com',
                'email' => 'contact@innovaalabs.com',
                'country' => 'India',
                'rep_name' => 'Sarah Jenkins',
                'rep_title' => 'Lead Data Scientist',
                'rep_email' => 'sarah.j@innovaalabs.com',
                'rep_phone' => '+91 98765 43211',
                'rep_img_url' => 'https://randomuser.me/api/portraits/women/44.jpg',
                'logo_color' => 'bg-indigo-600',
                'logo_text' => '<i class="ph-fill ph-chart-bar"></i>'
            ],
            [
                'id' => 103,
                'exhibition_id' => $visitorFlowExhibitionId,
                'hall_name' => 'Hall 1 - AI & IA',
                'booth_number' => 'Booth 103',
                'name' => 'DataMind Analytics',
                'category' => 'Data & Analytics',
                'description' => 'Data analytics platforms for smarter decisions and operational intelligence.',
                'website' => 'www.datamind.io',
                'email' => 'hello@datamind.io',
                'country' => 'India',
                'rep_name' => 'David Chen',
                'rep_title' => 'VP of Sales',
                'rep_email' => 'david.c@datamind.io',
                'rep_phone' => '+91 98765 43212',
                'rep_img_url' => 'https://randomuser.me/api/portraits/men/62.jpg',
                'logo_color' => 'bg-blue-600',
                'logo_text' => '<i class="ph-fill ph-database mr-1"></i> DM'
            ],
            [
                'id' => 104,
                'exhibition_id' => $visitorFlowExhibitionId,
                'hall_name' => 'Hall 1 - AI & IA',
                'booth_number' => 'Booth 104',
                'name' => 'CloudSphere Tech',
                'category' => 'Cloud Computing',
                'description' => 'Scalable cloud solutions for modern businesses.',
                'website' => 'www.cloudsphere.tech',
                'email' => 'support@cloudsphere.tech',
                'country' => 'India',
                'rep_name' => 'Elena Rodriguez',
                'rep_title' => 'Cloud Solutions Architect',
                'rep_email' => 'elena.r@cloudsphere.tech',
                'rep_phone' => '+91 98765 43213',
                'rep_img_url' => 'https://randomuser.me/api/portraits/women/68.jpg',
                'logo_color' => 'bg-[#0F172A]',
                'logo_text' => '<i class="ph-fill ph-cloud text-sky-400"></i>'
            ]
        ];

        foreach ($exhibitors as $e) {
            \App\Domain\Company\Models\Exhibitor::updateOrCreate(['id' => $e['id']], $e);
        }

        // 5. Ticket Tiers
        $tiers = [
            ['id' => 1, 'exhibition_id' => $visitorFlowExhibitionId, 'name' => 'Free Visitor Pass', 'price' => 0.00, 'benefits' => 'Access to AI & Automation pavilions, standard sessions entry, digital certificate'],
            ['id' => 2, 'exhibition_id' => $visitorFlowExhibitionId, 'name' => 'Business Pass', 'price' => 999.00, 'benefits' => 'Access to all pavilions, B2B matchmaking lounges, standard speaker sessions, catalog book'],
            ['id' => 3, 'exhibition_id' => $visitorFlowExhibitionId, 'name' => 'VIP All-Access Pass', 'price' => 2499.00, 'benefits' => 'Priority check-in, VIP lounge access, invite-only keynote, VIP networking dinner'],
        ];

        foreach ($tiers as $t) {
            \App\Domain\Event\Models\TicketTier::updateOrCreate(['id' => $t['id']], $t);
        }

        // Clean and Seed products and videos
        \Illuminate\Support\Facades\DB::table('visitor_products')->delete();
        \Illuminate\Support\Facades\DB::table('demo_videos')->delete();

        // 6. Visitor Products
        $products = [
            ['exhibitor_id' => 101, 'name' => 'AI Workflow Optimizer', 'description' => 'Automate complex enterprise workflows with high efficiency and minimum overhead.', 'price' => 199.00, 'image_url' => 'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=400&q=80', 'document_url' => '#', 'downloads_count' => 12],
            ['exhibitor_id' => 101, 'name' => 'Intelligent Chat Assistant', 'description' => 'Enterprise grade NLP virtual agent for customer support automation.', 'price' => 99.00, 'image_url' => 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?auto=format&fit=crop&w=400&q=80', 'document_url' => '#', 'downloads_count' => 25],
            ['exhibitor_id' => 102, 'name' => 'Neural Prediction Engine', 'description' => 'Predict market trends and consumer behavior using deep learning networks.', 'price' => 499.00, 'image_url' => 'https://images.unsplash.com/photo-1526374965328-7f61d4dc18c5?auto=format&fit=crop&w=400&q=80', 'document_url' => '#', 'downloads_count' => 8]
        ];

        foreach ($products as $p) {
            \App\Domain\Visitor\Models\VisitorProduct::create($p);
        }

        // 7. Demo Videos
        $videos = [
            [
                'exhibitor_id' => 101,
                'title' => 'TechNext AI Platform Showcase',
                'description' => 'Explore the next-gen AI automation workflows in action.',
                'duration' => '0:10',
                'video_url' => 'https://www.w3schools.com/html/mov_bbb.mp4',
                'published_date' => 'May 2026',
            ],
            [
                'exhibitor_id' => 102,
                'title' => 'InnovaAI Neural Net Walkthrough',
                'description' => 'Deep neural models training and analytics dashboard visualization.',
                'duration' => '0:10',
                'video_url' => 'https://www.w3schools.com/html/mov_bbb.mp4',
                'published_date' => 'May 2026',
            ]
        ];

        foreach ($videos as $v) {
            \App\Domain\Company\Models\DemoVideo::create($v);
        }
    }
}
