<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\Booking;
use App\Models\Exhibition;
use App\Models\Exhibitor;
use App\Models\ExhibitionVisitor;
use App\Models\ExhibitionMeeting;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Events
        $event1 = Event::create([
            'id' => 1,
            'name' => 'Global Tech Summit 2026',
            'category' => 'Technology',
            'sub_category' => 'AI & Cloud',
            'start_date' => '2026-05-15',
            'end_date' => '2026-05-17',
            'timezone' => 'Asia/Kolkata',
            'venue' => 'Jio World Convention Centre, Mumbai, India',
            'website' => 'https://globaltechsummit.com',
            'description' => 'Global Tech Summit brings together technology leaders, developers, and investors to explore emerging trends in AI, Cloud Computing, and Next-Generation Business Architectures.',
            'primary_color' => '#1010b9',
            'secondary_color' => '#3111e8',
            'accent_color' => '#FF8A00',
            'text_color' => '#101828',
            'organizer_name' => 'Tech Events Inc.',
            'organizer_email' => 'organizer@techevents.com',
            'organizer_phone' => '+91 98765 43210',
            'status' => 'approved',
            'allow_group_registrations' => true,
            'show_remaining_tickets' => true,
            'waiting_list' => false,
        ]);

        $event2 = Event::create([
            'id' => 2,
            'name' => 'Future of AI Expo',
            'category' => 'Artificial Intelligence',
            'sub_category' => 'Machine Learning',
            'start_date' => '2026-06-10',
            'end_date' => '2026-06-12',
            'timezone' => 'Asia/Kolkata',
            'venue' => 'Bengaluru Convention Centre, Bengaluru, India',
            'website' => 'https://futureaiexpo.com',
            'description' => 'Explore deep neural structures, machine learning platforms, and automation algorithms.',
            'primary_color' => '#5B32F6',
            'secondary_color' => '#00B894',
            'accent_color' => '#FF8A00',
            'text_color' => '#0F172A',
            'organizer_name' => 'AI Labs Consortium',
            'organizer_email' => 'contact@aiexpo.com',
            'organizer_phone' => '+91 80 555 1234',
            'status' => 'pending',
            'allow_group_registrations' => false,
            'show_remaining_tickets' => false,
            'waiting_list' => true,
        ]);

        $event3 = Event::create([
            'id' => 3,
            'name' => 'Sustainability World Expo',
            'category' => 'Environment',
            'sub_category' => 'Green Tech',
            'start_date' => '2026-08-08',
            'end_date' => '2026-08-10',
            'timezone' => 'Asia/Kolkata',
            'venue' => 'Pune International Exhibition Centre, Pune, India',
            'website' => 'https://sustainabilityworld.org',
            'description' => 'Innovations in green architecture, eco-friendly systems, and global sustainability standards.',
            'primary_color' => '#00B894',
            'secondary_color' => '#5B32F6',
            'accent_color' => '#FF8A00',
            'text_color' => '#0F172A',
            'organizer_name' => 'EcoWorld Foundation',
            'organizer_email' => 'info@ecoworld.org',
            'organizer_phone' => '+91 20 444 5678',
            'status' => 'draft',
            'allow_group_registrations' => true,
            'show_remaining_tickets' => false,
            'waiting_list' => false,
        ]);

        // 2. Seed Tickets
        Ticket::create([
            'event_id' => 1,
            'type' => 'Business Pass',
            'price' => 1499.00,
            'quantity' => '1000',
            'sales_start' => '2026-04-01',
            'sales_end' => '2026-05-14',
        ]);

        Ticket::create([
            'event_id' => 1,
            'type' => 'VIP Access Pass',
            'price' => 4999.00,
            'quantity' => '200',
            'sales_start' => '2026-04-01',
            'sales_end' => '2026-05-14',
        ]);

        Ticket::create([
            'event_id' => 2,
            'type' => 'Early Bird Pass',
            'price' => 999.00,
            'quantity' => '300',
            'sales_start' => '2026-05-01',
            'sales_end' => '2026-06-01',
        ]);

        Ticket::create([
            'event_id' => 2,
            'type' => 'General Admission',
            'price' => 1999.00,
            'quantity' => 'Unlimited',
            'sales_start' => '2026-05-01',
            'sales_end' => '2026-06-09',
        ]);

        // 3. Seed Bookings
        Booking::create([
            'event_id' => 1,
            'booking_id' => 'EVT-260515-000123',
            'ticket_type' => 'Business Pass',
            'amount' => 1499.00,
            'booking_date' => 'May 10, 2026',
            'attendee_name' => 'John Doe',
            'attendee_email' => 'john.doe@example.com',
            'checkin_status' => false,
            'checkin_time' => null,
        ]);

        Booking::create([
            'event_id' => 1,
            'booking_id' => 'EVT-260515-000124',
            'ticket_type' => 'VIP Access Pass',
            'amount' => 4999.00,
            'booking_date' => 'May 11, 2026',
            'attendee_name' => 'Jane Smith',
            'attendee_email' => 'jane.smith@example.com',
            'checkin_status' => true,
            'checkin_time' => 'May 15, 2026 at 09:30 AM',
        ]);

        // 4. Seed Exhibitions
        $exh1 = Exhibition::create([
            'id' => 1,
            'name' => 'Global Tech Summit 2026',
            'start_date' => '2026-05-15',
            'end_date' => '2026-05-17',
            'venue' => 'Jio World Convention Centre, Mumbai, India',
            'description' => 'Experience next-generation tech breakthroughs in enterprise systems and engineering.',
            'companies_count' => 120,
            'banner_url' => 'https://images.unsplash.com/photo-1518770660439-4636190af475?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
        ]);

        $exh2 = Exhibition::create([
            'id' => 2,
            'name' => 'Future of AI Expo',
            'start_date' => '2026-06-10',
            'end_date' => '2026-06-12',
            'venue' => 'Bengaluru Convention Centre, Bengaluru, India',
            'description' => 'Explore deep neural structures, machine learning platforms, and automation algorithms.',
            'companies_count' => 80,
            'banner_url' => 'https://images.unsplash.com/photo-1485827404703-89b55fcc595e?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
        ]);

        $exh3 = Exhibition::create([
            'id' => 3,
            'name' => 'Sustainability World Expo',
            'start_date' => '2026-08-08',
            'end_date' => '2026-08-10',
            'venue' => 'Pune International Exhibition Centre, Pune, India',
            'description' => 'Innovations in green architecture, eco-friendly systems, and global sustainability standards.',
            'companies_count' => 85,
            'banner_url' => 'https://images.unsplash.com/photo-1466611653911-95081537e5b7?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
        ]);

        // 5. Seed Exhibitors
        Exhibitor::create([
            'id' => 1,
            'exhibition_id' => 1,
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
            'logo_text' => 'TN',
        ]);

        Exhibitor::create([
            'id' => 2,
            'exhibition_id' => 1,
            'hall_name' => 'Hall 1 - AI & IA',
            'booth_number' => 'Booth 102',
            'name' => 'InnovaAI Labs',
            'category' => 'Machine Learning',
            'description' => 'Building intelligent models for real-world impact and actionable data analytics.',
            'website' => 'www.innovaalabs.com',
            'email' => 'contact@innovaalabs.com',
            'country' => 'United States',
            'rep_name' => 'Sarah Jenkins',
            'rep_title' => 'Lead Data Scientist',
            'rep_email' => 'sarah.j@innovaalabs.com',
            'rep_phone' => '+1 555-0198',
            'rep_img_url' => 'https://randomuser.me/api/portraits/women/44.jpg',
            'logo_color' => 'bg-indigo-600',
            'logo_text' => 'IA',
        ]);

        Exhibitor::create([
            'id' => 3,
            'exhibition_id' => 1,
            'hall_name' => 'Hall 1 - AI & IA',
            'booth_number' => 'Booth 103',
            'name' => 'DataMind Analytics',
            'category' => 'Data & Analytics',
            'description' => 'Data analytics platforms for smarter decisions and operational intelligence.',
            'website' => 'www.datamind.io',
            'email' => 'hello@datamind.io',
            'country' => 'United Kingdom',
            'rep_name' => 'David Chen',
            'rep_title' => 'VP of Sales',
            'rep_email' => 'david.c@datamind.io',
            'rep_phone' => '+44 20 7123 4567',
            'rep_img_url' => 'https://randomuser.me/api/portraits/men/62.jpg',
            'logo_color' => 'bg-blue-600',
            'logo_text' => 'DM',
        ]);

        Exhibitor::create([
            'id' => 4,
            'exhibition_id' => 1,
            'hall_name' => 'Hall 1 - AI & IA',
            'booth_number' => 'Booth 104',
            'name' => 'CloudSphere Tech',
            'category' => 'Cloud Computing',
            'description' => 'Scalable cloud solutions for modern businesses.',
            'website' => 'www.cloudsphere.tech',
            'email' => 'support@cloudsphere.tech',
            'country' => 'Canada',
            'rep_name' => 'Elena Rodriguez',
            'rep_title' => 'Cloud Solutions Architect',
            'rep_email' => 'elena.r@cloudsphere.tech',
            'rep_phone' => '+1 416 555 0192',
            'rep_img_url' => 'https://randomuser.me/api/portraits/women/68.jpg',
            'logo_color' => 'bg-[#0F172A]',
            'logo_text' => 'CS',
        ]);

        // 6. Seed Exhibition Visitors
        $visitor1 = ExhibitionVisitor::create([
            'id' => 1,
            'exhibition_id' => 1,
            'booking_id' => 'EXH-260515-000001',
            'first_name' => 'Amit',
            'last_name' => 'Kumar',
            'email' => 'amit.kumar@example.com',
            'mobile' => '+91 99999 88888',
            'job_title' => 'Software Engineer',
            'company' => 'Infosys',
            'country' => 'India',
            'state' => 'Karnataka',
            'city' => 'Bengaluru',
            'industry' => 'Information Technology',
            'company_size' => '10000+',
            'business_address' => 'Electronic City Phase 1, Bengaluru',
            'pass_type' => 'VIP Pass',
            'amount' => 999.00,
            'payment_status' => 'completed',
            'checkin_status' => true,
            'checkin_time' => '2026-05-15 10:15:00',
        ]);

        $visitor2 = ExhibitionVisitor::create([
            'id' => 2,
            'exhibition_id' => 1,
            'booking_id' => 'EXH-260515-000002',
            'first_name' => 'Priya',
            'last_name' => 'Sharma',
            'email' => 'priya.sharma@example.com',
            'mobile' => '+91 88888 77777',
            'job_title' => 'Product Manager',
            'company' => 'Wipro',
            'country' => 'India',
            'state' => 'Maharashtra',
            'city' => 'Pune',
            'industry' => 'Software Solutions',
            'company_size' => '5000-10000',
            'business_address' => 'Hinjewadi Phase 2, Pune',
            'pass_type' => 'Standard Pass',
            'amount' => 0.00,
            'payment_status' => 'completed',
            'checkin_status' => false,
            'checkin_time' => null,
        ]);

        // 7. Seed Exhibition Meetings
        ExhibitionMeeting::create([
            'id' => 1,
            'visitor_id' => 1,
            'exhibitor_id' => 1,
            'meeting_date' => '2026-05-15',
            'meeting_time' => '11:30 AM',
            'notes' => 'Discuss AI agent integration possibilities for enterprise dashboard.',
            'status' => 'accepted',
        ]);

        ExhibitionMeeting::create([
            'id' => 2,
            'visitor_id' => 2,
            'exhibitor_id' => 2,
            'meeting_date' => '2026-05-16',
            'meeting_time' => '02:00 PM',
            'notes' => 'Interested in their custom machine learning models.',
            'status' => 'pending',
        ]);
    }
}
