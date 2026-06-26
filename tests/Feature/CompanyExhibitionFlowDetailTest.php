<?php

namespace Tests\Feature;

use App\Domain\Admin\Models\Admin;
use App\Domain\Booth\Models\Booth;
use App\Domain\Booth\Models\BoothBooking;
use App\Domain\Booth\Models\BoothSize;
use App\Domain\Company\Models\Company;
use App\Domain\Company\Models\CompanyMeeting;
use App\Domain\Company\Models\Enquiry;
use App\Domain\Event\Models\Exhibition;
use App\Domain\Event\Models\Hall;
use App\Domain\Event\Models\Pavilion;
use App\Domain\Company\Models\Service;
use App\Domain\Visitor\Models\VisitorMeetingBooking;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class CompanyExhibitionFlowDetailTest extends TestCase
{
    use RefreshDatabase;

    protected Company $company;
    protected Exhibition $exhibition;
    protected Pavilion $pavilion;
    protected Hall $hall;
    protected BoothSize $size;
    protected Booth $booth;
    protected Admin $admin;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed basic models
        $this->company = Company::create([
            'company_name' => 'Acme Technologies',
            'contact_person_name' => 'Shubham',
            'email' => 'company@example.com',
            'phone' => '9876543210',
            'password' => Hash::make('password'),
            'status' => 'approved',
        ]);

        $this->admin = Admin::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'status' => 'active',
            'role' => 'admin',
        ]);

        $this->exhibition = Exhibition::create([
            'title' => 'Global Tech Expo 2024',
            'slug' => 'global-tech-expo-2024',
            'start_date' => '2026-06-12',
            'end_date' => '2026-06-14',
            'status' => 'active',
            'approval_status' => 'approved',
            'publish_status' => 'published',
        ]);

        $this->pavilion = Pavilion::create([
            'exhibition_id' => $this->exhibition->id,
            'title' => 'Innovation Pavilion',
            'slug' => 'innovation-pavilion',
            'status' => 'active',
        ]);

        $this->hall = Hall::create([
            'pavilion_id' => $this->pavilion->id,
            'title' => 'Hall 1 - AI Solutions',
            'slug' => 'hall-1-ai-solutions',
            'status' => 'active',
        ]);

        $this->size = BoothSize::create([
            'title' => '3m x 3m',
            'width' => 3,
            'height' => 3,
            'area' => 9,
            'price' => 499,
            'status' => 'active',
        ]);

        $this->booth = Booth::create([
            'hall_id' => $this->hall->id,
            'booth_size_id' => $this->size->id,
            'booth_number' => 'A-01',
            'price' => 499,
            'status' => 'available',
        ]);
    }

    public function test_company_exhibition_browse_deduplicates_exhibitions_by_title(): void
    {
        $this->session(['company_id' => $this->company->id]);

        Exhibition::create([
            'title' => 'Global Tech Expo 2024',
            'slug' => 'global-tech-expo-2024-copy',
            'start_date' => '2026-06-12',
            'end_date' => '2026-06-14',
            'status' => 'active',
            'approval_status' => 'approved',
            'publish_status' => 'published',
        ]);

        $response = $this->get(route('company.exhibitions.index'));

        $response->assertStatus(200);
        $this->assertSame(1, substr_count($response->getContent(), '<h2 class="text-[21px] font-semibold text-navy">Global Tech Expo 2024</h2>'));
    }

    public function test_company_exhibition_browse_search_filters_results(): void
    {
        $this->session(['company_id' => $this->company->id]);

        $secondExhibition = Exhibition::create([
            'title' => 'Future of AI Expo',
            'slug' => 'future-of-ai-expo',
            'start_date' => '2026-07-10',
            'end_date' => '2026-07-12',
            'status' => 'active',
            'approval_status' => 'approved',
            'publish_status' => 'published',
        ]);

        Pavilion::create([
            'exhibition_id' => $secondExhibition->id,
            'title' => 'Robotics Pavilion',
            'slug' => 'robotics-pavilion',
            'status' => 'active',
        ]);

        $response = $this->get(route('company.exhibitions.index', ['search' => 'future']));

        $response->assertStatus(200);
        $response->assertSee('Future of AI Expo');
        $response->assertDontSee('Global Tech Expo 2024');
        $response->assertSee('value="future"', false);

        $response = $this->get(route('company.exhibitions.index', ['search' => 'robotics']));

        $response->assertStatus(200);
        $response->assertSee('Future of AI Expo');
        $response->assertDontSee('Global Tech Expo 2024');
    }

    public function test_company_pavilion_search_filters_and_preserves_selected_exhibition(): void
    {
        $this->session(['company_id' => $this->company->id]);

        Pavilion::create([
            'exhibition_id' => $this->exhibition->id,
            'title' => 'Robotics Pavilion',
            'slug' => 'robotics-pavilion',
            'description' => 'Automation systems',
            'status' => 'active',
        ]);

        $response = $this->get(route('company.booth-booking.pavilions', [
            'exhibition' => $this->exhibition->slug,
            'search' => 'robotics',
        ]));

        $response->assertStatus(200);
        $response->assertSee('Robotics Pavilion');
        $response->assertDontSee('Innovation Pavilion');
        $response->assertSee('name="exhibition" value="global-tech-expo-2024"', false);
        $response->assertSee('value="robotics"', false);
    }

    public function test_company_pavilion_search_works_across_all_live_exhibitions(): void
    {
        $this->session(['company_id' => $this->company->id]);

        $secondExhibition = Exhibition::create([
            'title' => 'Future of AI Expo',
            'slug' => 'future-of-ai-expo',
            'start_date' => '2026-07-10',
            'end_date' => '2026-07-12',
            'status' => 'active',
            'approval_status' => 'approved',
            'publish_status' => 'published',
        ]);

        Pavilion::create([
            'exhibition_id' => $secondExhibition->id,
            'title' => 'Deep Learning Pavilion',
            'slug' => 'deep-learning-pavilion',
            'description' => 'Neural network models',
            'status' => 'active',
        ]);

        $response = $this->get(route('company.booth-booking.pavilions', ['search' => 'deep']));

        $response->assertStatus(200);
        $response->assertSee('Deep Learning Pavilion');
        $response->assertDontSee('Innovation Pavilion');
        $response->assertSee('value="deep"', false);
        $response->assertDontSee('name="exhibition"', false);
    }

    public function test_company_hall_search_filters_results_without_footfall_labels(): void
    {
        $this->session(['company_id' => $this->company->id]);

        Hall::create([
            'pavilion_id' => $this->pavilion->id,
            'title' => 'Hall 2 - Machine Automation',
            'slug' => 'hall-2-machine-automation',
            'description' => 'Robotics and machinery booths',
            'status' => 'active',
        ]);

        $response = $this->get(route('company.booth-booking.halls', [
            'pavilion' => $this->pavilion->id,
            'search' => 'machine',
        ]));

        $response->assertStatus(200);
        $response->assertSee('Hall 2 - Machine Automation');
        $response->assertDontSee('Hall 1 - AI Solutions');
        $response->assertDontSee('High Footfall');
        $response->assertDontSee('Medium Footfall');
        $response->assertSee('value="machine"', false);
    }
    public function test_complete_exhibition_and_booth_booking_flow(): void
    {
        // Set company session
        $this->session(['company_id' => $this->company->id]);

        // 1. Check Exhibition List and Details as logged-in company
        $response = $this->get(route('company.exhibitions.index'));
        $response->assertStatus(200);
        $response->assertSee('Global Tech Expo 2024');

        $response = $this->get(route('company.exhibitions.show', $this->exhibition->slug));
        $response->assertStatus(200);
        $response->assertSee('Global Tech Expo 2024');

        // 2. Start Booth Booking: Select Pavilion
        $response = $this->get(route('company.booth-booking.pavilions'));
        $response->assertStatus(200);

        // 3. Select Hall
        $response = $this->get(route('company.booth-booking.halls', ['pavilion' => $this->pavilion->id]));
        $response->assertStatus(200);

        // 4. Select Booth and Size
        $response = $this->get(route('company.booth-booking.floor-plan', ['hall' => $this->hall->id]));
        $response->assertStatus(200);

        // Post booking step 1 (Selects booth, updates session)
        $response = $this->post(route('company.booth-booking.floor-plan.select'), [
            'hall_id' => $this->hall->id,
            'booth_id' => $this->booth->id,
            'size_id' => $this->size->id,
        ]);
        $response->assertRedirect();
        $this->assertStringContainsString('/company/booth-booking/summary', $response->headers->get('Location'));

        $booking = BoothBooking::firstOrFail();

        // Legacy slots routes still sync admin days and continue to summary
        $response = $this->post(route('company.booth-booking.slots.continue'), [
            'hall_id' => $this->hall->id,
            'booth_id' => $this->booth->id,
            'size_id' => $this->size->id,
        ]);
        $response->assertRedirect(route('company.booth-booking.summary', ['exhibition' => $this->exhibition->slug]));

        // 6. View Summary and Select Services
        $response = $this->get(route('company.booth-booking.summary'));
        $response->assertStatus(200);

        // Seed service
        $service = Service::create([
            'title' => 'Premium Catering',
            'price' => 150,
            'status' => 'active',
        ]);

        $response = $this->post(route('company.booth-booking.services.toggle'), [
            'service_id' => $service->id,
        ]);
        $response->assertRedirect();

        // Continue from services
        $response = $this->post(route('company.booth-booking.services.continue'));
        $response->assertRedirect();

        // Review booking
        $response = $this->get(route('company.booth-booking.review'));
        $response->assertStatus(200);

        // Proceed to Payment
        $response = $this->get(route('company.booth-booking.payment'));
        $response->assertStatus(200);

        // Verification / Continue after payment (Mocking bypass payment confirmation)
        $response = $this->post(route('company.booth-booking.payment.continue'));
        $response->assertRedirect(route('company.booth-booking.confirmed'));

        // Booking confirmation landing page
        $response = $this->get(route('company.booth-booking.confirmed'));
        $response->assertStatus(200);

        // 7. Verify the booking is pending review and shows on the company dashboard
        $booking->refresh();
        $this->assertEquals('pending', $booking->admin_status);
        $this->assertEquals('paid', $booking->payment_status);

        $response = $this->get(route('company.dashboard'));
        $response->assertStatus(200);
        $response->assertSee('Booking Pending Approval');
        // Ensure setup button is disabled/pending
        $response->assertSee('Awaiting Approval');

        // 8. Log in as admin and approve the booking
        $this->session(['admin_id' => $this->admin->id]);

        $response = $this->get(route('admin.booth-bookings.index'));
        $response->assertStatus(200);

        $response = $this->get(route('admin.booth-bookings.show', $booking->id));
        $response->assertStatus(200);

        $response = $this->post(route('admin.booth-bookings.approve', $booking->id));
        $response->assertRedirect();

        $booking->refresh();
        $this->assertEquals('approved', $booking->admin_status);

        // 9. Log back in as company and verify setup is unlocked
        $this->session(['company_id' => $this->company->id]);

        $response = $this->get(route('company.dashboard'));
        $response->assertStatus(200);
        $response->assertDontSee('Booking Pending Approval');

        // Verify bookings index, details and invoice views
        $response = $this->get('/company/bookings');
        $response->assertStatus(200);
        $response->assertSee('Download Invoice');

        $response = $this->get('/company/bookings/' . $booking->id);
        $response->assertStatus(200);
        $response->assertSee('Download Invoice');
        $response->assertSee('View Payment Receipt');

        $response = $this->get('/company/bookings/' . $booking->id . '/invoice');
        $response->assertStatus(200);
        $response->assertSee('INVOICE');
        $response->assertSee('EXPO-');
        $response->assertSee('Billed To');
        $response->assertSee('Acme Technologies');

        // 10. Walk through booth setup page-by-page and save info
        // Setup Step 1: Profile
        $response = $this->post(route('company.booth-setup.profile.update', $booking->id), [
            'company_name' => 'Acme Technologies Inc',
            'contact_person' => 'Shubham Sharma',
            'industry' => 'AI SaaS',
            'email' => 'contact@acme.com',
            'phone' => '1234567890',
            'tagline' => 'AI Orchestration for all',
            'website' => 'https://acme.example.com',
            'about_company' => 'We specialize in enterprise automation.',
            'address' => 'Delhi, India',
            'city' => 'New Delhi',
            'state' => 'Delhi',
            'zip_code' => '110001',
            'country' => 'India',
            'next' => 'branding',
        ]);
        $response->assertRedirect();

        // Setup Step 2: Branding
        $response = $this->post(route('company.booth-setup.branding.update', $booking->id), [
            'primary_color' => '#5b2eff',
            'secondary_color' => '#071044',
            'welcome_heading' => 'Welcome to Acme AI Center',
            'theme_template' => 'modern',
            'cta_button_text' => 'Get Free Demo',
            'cta_button_link' => 'https://acme.example.com/demo',
            'action' => 'continue',
        ]);
        $response->assertRedirect();

        // Setup Step 3: Products (Create a product)
        $response = $this->post(route('company.booth-setup.products.store', $booking->id), [
            'name' => 'Acme Workflow Automator',
            'category' => 'AI Software',
            'short_description' => 'Automate manual back-office tasks.',
            'detailed_description' => 'Detailed product overview here.',
            'status' => 'published',
            'sort_order' => 1,
        ]);
        $response->assertRedirect();

        // Setup Step 4: Documents (Create a document)
        $response = $this->post(route('company.booth-setup.documents.store', $booking->id), [
            'title' => 'Acme Automation Overview PDF',
            'file' => UploadedFile::fake()->create('overview.pdf', 100),
            'visibility' => 'public',
            'status' => 'active',
        ]);
        $response->assertRedirect();

        // Setup Step 5: Catalogues (Create a catalogue)
        $response = $this->post(route('company.booth-setup.catalogues.store', $booking->id), [
            'title' => 'Product Catalogue 2026',
            'file' => UploadedFile::fake()->create('catalogue.pdf', 200),
            'category' => 'Brochure',
            'visibility' => 'public',
            'status' => 'active',
        ]);
        $response->assertRedirect();

        // Setup Step 6: Media (Create media)
        $response = $this->post(route('company.booth-setup.media.store', $booking->id), [
            'title' => 'Product Demo Video Screenshot',
            'type' => 'image',
            'file' => UploadedFile::fake()->create('screenshot.png', 100),
            'sort_order' => 1,
            'status' => 'active',
        ]);
        $response->assertRedirect();

        // Setup Step 7: Team (Create team member)
        $response = $this->post(route('company.booth-setup.team-members.store', $booking->id), [
            'name' => 'Rohan Dev',
            'designation' => 'Technical Solutions Architect',
            'email' => 'rohan@acme.com',
            'phone' => '1234567890',
            'status' => 'active',
        ]);
        $response->assertRedirect();

        // Setup Step 8: Meeting Availability
        $response = $this->post(route('company.booth-setup.meetings.update', $booking->id), [
            'available_start_date' => '2026-06-12',
            'available_end_date' => '2026-06-14',
            'available_weekdays' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
            'daily_start_time' => '10:00',
            'daily_end_time' => '18:00',
            'meeting_types' => ['video', 'chat'],
            'slot_duration' => 30,
        ]);
        $response->assertRedirect();

        // Setup Step 9: Sessions (Create a session)
        $response = $this->post(route('company.booth-setup.sessions.store', $booking->id), [
            'title' => 'Acme AI Masterclass',
            'description' => 'Learn how to automate workflow processes in real time.',
            'session_date' => '2026-06-13',
            'start_time' => '14:00',
            'end_time' => '15:00',
            'type' => 'live_demo',
            'status' => 'upcoming',
        ]);
        $response->assertRedirect();

        // Setup Step 10: Preview
        $response = $this->get(route('company.booth-setup.preview', $booking->id));
        $response->assertStatus(200);
        $response->assertSee('Acme Technologies Inc');
        $response->assertSee('Welcome to Acme AI Center');
        $response->assertSee('Acme Workflow Automator');
        $response->assertSee('Product Catalogue 2026');
        $response->assertSee('Rohan Dev');
        $response->assertSee('Acme AI Masterclass');

        $response = $this->post(route('company.booth-setup.preview.mark-ready', $booking->id));
        $response->assertRedirect();

        // Setup Step 11: Publish
        $response = $this->get(route('company.booth-setup.publish.show', $booking->id));
        $response->assertStatus(200);

        $response = $this->post(route('company.booth-setup.publish.submit', $booking->id));
        $response->assertRedirect(route('company.dashboard'));

        // Verify booth setup status is pending review
        $booking->refresh();
        $this->assertEquals('published', $booking->booth_setup_status);

        // Log in as admin and approve the booth publish request
        $this->session(['admin_id' => $this->admin->id]);
        $publishRequest = \App\Domain\Booth\Models\BoothPublishRequest::where('booth_booking_id', $booking->id)->firstOrFail();
        $response = $this->post(route('admin.booth-approvals.approve', $publishRequest->id));
        $response->assertRedirect();

        // Log back in as company and verify setup is marked as published
        $this->session(['company_id' => $this->company->id]);
        $booking->refresh();
        $this->assertEquals('published', $booking->booth_setup_status);

        $response = $this->get(route('company.dashboard'));
        $response->assertStatus(200);
        $response->assertSee('Live');
        $response->assertSee('View Live Booth');
        $response->assertSee('Your booth is live on the website.');
        $response->assertSee('Your Exhibition Booths');
        $response->assertSee('Book Another Booth');

        $response = $this->getJson(route('company.dashboard.data'));
        $response->assertStatus(200)
            ->assertJsonPath('bookings.0.exhibition', $this->exhibition->title);

        $response = $this->get(route('exhibitions.index'));
        $response->assertStatus(200);
        $response->assertSee('Acme Technologies Inc');

        $response = $this->get(route('exhibitions.home'));
        $response->assertStatus(200);
        $response->assertSee('Acme Technologies Inc');
        $response->assertSee('Visit Booth');

        $response = $this->get(route('exhibitions.visit', $this->exhibition->slug));
        $response->assertStatus(200);
        $response->assertSee('Acme Technologies Inc');

        // 11. Admin record should exist as already approved.
        $publishRequest = \App\Domain\Booth\Models\BoothPublishRequest::where('booth_booking_id', $booking->id)->firstOrFail();
        $this->assertEquals('approved', $publishRequest->status);

        // 12. Visitor Flow (no login required)
        $response = $this->get(route('exhibitions.tickets.select', $this->exhibition->slug));
        $response->assertRedirect(route('exhibitions.tickets.visitor-details', $this->exhibition->slug));

        $response = $this->get(route('exhibitions.tickets.visitor-details', $this->exhibition->slug));
        $response->assertStatus(200);
        $response->assertSee('Visitor Registration');
        $response->assertSee('Continue to Pass Selection');

        $response = $this->post(route('exhibitions.tickets.visitor-details.store'), [
            'slug' => $this->exhibition->slug,
            'name' => 'Exhibition Flow Visitor',
            'email' => 'exhibitionflow@example.com',
            'password' => 'password123',
            'phone' => '9876543210',
            'gender' => 'male',
            'city' => 'Delhi',
        ]);
        $response->assertRedirect(route('exhibitions.tickets.pass-details', $this->exhibition->slug));

        $response = $this->get(route('exhibitions.tickets.pass-details', $this->exhibition->slug));
        $response->assertStatus(200);
        $response->assertSee('Visitor Details');

        // Get confirmed (sets visitor_pass_active to true in session)
        $response = $this->get(route('exhibitions.tickets.confirmed', $this->exhibition->slug));
        $response->assertStatus(200);
        $this->assertTrue(session('visitor_pass_active'));

        // Visit the Exhibition Lobby / Companies List
        $response = $this->get(route('exhibitions.visitor.companies', $this->exhibition->slug));
        $response->assertStatus(200);
        $response->assertSee('Acme Technologies Inc');

        // View dynamic Booth details as a visitor
        $companySlug = \Illuminate\Support\Str::slug('Acme Technologies Inc');
        $response = $this->get(route('exhibitions.visitor.companies.show', [$this->exhibition->slug, $companySlug]));
        $response->assertStatus(200);
        $response->assertSee('Acme Technologies Inc');
        $response->assertSee('Acme Automation Overview PDF'); // Document
        $response->assertSee('Product Catalogue 2026'); // Catalogue
        $response->assertSee('Acme Workflow Automator'); // Product

        // Visitor sessions page should be synced from booth setup sessions.
        $response = $this->get(route('exhibitions.visitor.sessions', $this->exhibition->slug));
        $response->assertStatus(200);
        $response->assertSee('Acme AI Masterclass');
        $response->assertSee('Acme Technologies Inc');
    }

    public function test_company_analytics_page_renders_successfully(): void
    {
        $response = $this->withSession([
            'company_id' => $this->company->id,
            'company_logged_in' => true
        ])->get(route('company.analytics'));

        $response->assertStatus(200);
        $response->assertSee('Booth Analytics');
        $response->assertSee('Booth Views');
        $response->assertSee('Product Views');
        $response->assertSee('Brochure Downloads');
        $response->assertSee('Meeting Requests');
        $response->assertSee('Enquiries');
        $response->assertSee('Session Attendees');
        $response->assertSee('Traffic Sources');
        $response->assertSee('Recent Activities');
    }
}
