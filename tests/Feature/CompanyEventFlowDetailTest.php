<?php

namespace Tests\Feature;

use App\Domain\Company\Models\Company;
use App\Domain\Event\Models\CompanyEvent\CompanyEvent;
use App\Domain\Event\Models\CompanyEvent\CompanyEventBranding;
use App\Domain\Event\Models\CompanyEvent\CompanyEventPublishRequest;
use App\Domain\Event\Models\CompanyEvent\CompanyEventTicketType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CompanyEventFlowDetailTest extends TestCase
{
    use RefreshDatabase;

    protected Company $company;

    protected function setUp(): void
    {
        parent::setUp();

        $this->company = Company::create([
            'company_name' => 'Acme Event Organizers',
            'contact_person_name' => 'Shubham Sharma',
            'email' => 'company@example.com',
            'phone' => '9876543210',
            'password' => Hash::make('password'),
            'status' => 'approved',
            'account_type' => 'event',
        ]);
    }

    public function test_company_can_create_multiple_events_and_see_them_on_dashboard(): void
    {
        $this->session(['company_id' => $this->company->id, 'company_flow_context' => 'event_company']);

        $firstPayload = [
            'title' => 'Manufacturing Expo 2026',
            'category' => 'Manufacturing',
            'sub_category' => 'Industrial Automation',
            'event_type' => 'in_person',
            'event_mode' => 'in_person',
            'starts_at' => '2026-09-10 09:00:00',
            'ends_at' => '2026-09-13 18:00:00',
            'timezone' => 'Asia/Kolkata',
            'venue_address' => 'Pragati Maidan, New Delhi, India',
            'summary' => 'A physical exhibition for machinery and automation.',
        ];

        $secondPayload = [
            'title' => 'Founders Mixer 2026',
            'category' => 'Finance',
            'sub_category' => 'Venture Capital',
            'event_type' => 'in_person',
            'event_mode' => 'in_person',
            'starts_at' => '2026-10-05 18:00:00',
            'ends_at' => '2026-10-05 22:00:00',
            'timezone' => 'Asia/Kolkata',
            'venue_address' => 'Bandra Kurla Complex, Mumbai, India',
            'summary' => 'A premium networking dinner and pitch mixer.',
        ];

        $this->post(route('company.event-company-flow.create.store'), $firstPayload)
            ->assertRedirect();

        $this->post(route('company.event-company-flow.create.store'), $secondPayload)
            ->assertRedirect();

        $this->assertDatabaseCount('company_events', 2);
        $this->assertDatabaseHas('company_events', [
            'company_id' => $this->company->id,
            'title' => 'Manufacturing Expo 2026',
        ]);
        $this->assertDatabaseHas('company_events', [
            'company_id' => $this->company->id,
            'title' => 'Founders Mixer 2026',
        ]);

        $this->get(route('company.event-company-flow.dashboard', ['all' => 'true']))
            ->assertStatus(200)
            ->assertSee('Manufacturing Expo 2026')
            ->assertSee('Founders Mixer 2026');
    }

    public function test_complete_company_event_and_visitor_booking_flow(): void
    {
        // 1. Company Login (set session)
        $this->session(['company_id' => $this->company->id, 'company_flow_context' => 'event_company']);

        // 2. Access Event Dashboard with no events yet
        $response = $this->get(route('company.event-company-flow.dashboard'));
        $response->assertStatus(200);
        $response->assertSee('No events yet. Create your first event to see it here.');
        $this->assertDatabaseCount('company_events', 0);

        // 3. Create page should not auto-create a draft event
        $response = $this->get(route('company.event-company-flow.create'));
        $response->assertStatus(200);
        $this->assertDatabaseCount('company_events', 0);

        // 4. Create the first event explicitly
        $response = $this->post(route('company.event-company-flow.create.store'), [
            'title' => 'Acme Global Summit 2026',
            'category' => 'Technology',
            'sub_category' => 'Other',
            'event_type' => 'in_person',
            'event_mode' => 'in_person',
            'starts_at' => '2026-07-15 09:00:00',
            'ends_at' => '2026-07-17 18:00:00',
            'timezone' => 'Asia/Kolkata',
            'venue_name' => 'Bengaluru Tech Park',
            'venue_address' => 'Outer Ring Road, Bengaluru',
            'city' => 'Bengaluru',
            'country' => 'India',
        ]);
        $response->assertRedirect();

        $event = CompanyEvent::firstOrFail();
        $this->assertEquals('draft', $event->status);
        $this->assertEquals($this->company->id, $event->company_id);
        $this->assertEquals('Acme Global Summit 2026', $event->title);

        // 5. Update Basic details (Name, Dates, Location, Category)
        $response = $this->post(route('company.event-company-flow.basic.update', $event->id), [
            'title' => 'Acme Global Summit 2026',
            'category' => 'Technology',
            'event_type' => 'in_person',
            'event_mode' => 'in_person',
            'starts_at' => '2026-07-15 09:00:00',
            'ends_at' => '2026-07-17 18:00:00',
            'timezone' => 'Asia/Kolkata',
            'venue_name' => 'Bengaluru Tech Park',
            'venue_address' => 'Outer Ring Road, Bengaluru',
            'city' => 'Bengaluru',
            'country' => 'India',
            'next' => 'branding',
        ]);
        $response->assertRedirect(route('company.event-company-flow.branding', $event->id));

        $event->refresh();
        $this->assertEquals('Acme Global Summit 2026', $event->title);
        $this->assertEquals('Technology', $event->category);

        // 5. Save Branding colors & theme template
        $response = $this->post(route('company.event-company-flow.branding.update', $event->id), [
            'primary_color' => '#1C1364',
            'secondary_color' => '#4C10D0',
            'accent_color' => '#10B981',
            'theme_template' => 'modern',
            'tagline' => 'Accelerating Innovation',
            'action' => 'continue',
        ]);
        $response->assertRedirect(route('company.event-company-flow.tickets', $event->id));

        $branding = CompanyEventBranding::where('company_event_id', $event->id)->firstOrFail();
        $this->assertEquals('#1C1364', $branding->primary_color);
        $this->assertEquals('Accelerating Innovation', $branding->tagline);

        // 6. Create Ticket types (Regular, VIP)
        // Add Regular ticket
        $response = $this->post(route('company.event-company-flow.tickets.store', $event->id), [
            'name' => 'Regular Pass',
            'description' => 'Access to all main tracks',
            'price' => 99.00,
            'quantity_total' => 500,
            'next' => 'stay',
        ]);
        $response->assertRedirect();

        // Add VIP ticket
        $response = $this->post(route('company.event-company-flow.tickets.store', $event->id), [
            'name' => 'VIP Pass',
            'description' => 'Access to all main tracks + speaker lounge',
            'price' => 299.00,
            'quantity_total' => 50,
            'next' => 'preview',
        ]);
        $response->assertRedirect(route('company.event-company-flow.preview', $event->id));

        $this->assertEquals(2, $event->ticketTypes()->count());
        $this->assertDatabaseHas('company_event_ticket_types', [
            'company_event_id' => $event->id,
            'name' => 'Regular Pass',
            'price' => 99.00,
        ]);
        $this->assertDatabaseHas('company_event_ticket_types', [
            'company_event_id' => $event->id,
            'name' => 'VIP Pass',
            'price' => 299.00,
        ]);

        // 7. Preview and submit review
        $response = $this->get(route('company.event-company-flow.preview', $event->id));
        $response->assertStatus(200);

        $response = $this->get(route('company.event-company-flow.submit', $event->id));
        $response->assertStatus(200);

        $response = $this->post(route('company.event-company-flow.submit.store', $event->id), [
            'company_notes' => 'Our event is fully configured.',
        ]);
        $response->assertRedirect(route('company.event-company-flow.dashboard'));

        $event->refresh();
        $this->assertEquals('pending_review', $event->status);

        $response = $this->get(route('events.listings.index'));
        $response->assertStatus(200);
        $response->assertDontSee('Acme Global Summit 2026');

        $response = $this->get(route('events.listings.show', $event->slug));
        $response->assertNotFound();

        // 8. Admin reviews and approves the event
        $admin = \App\Domain\Admin\Models\Admin::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'status' => 'active',
            'role' => 'admin',
        ]);
        $this->session(['admin_id' => $admin->id]);
        $publishRequest = CompanyEventPublishRequest::where('company_event_id', $event->id)->firstOrFail();
        $response = $this->get(route('admin.event-approvals.show', $publishRequest->id));
        $response->assertStatus(200);

        $response = $this->post(route('admin.event-approvals.approve', $publishRequest->id));
        $response->assertRedirect();

        $event->refresh();
        $this->assertEquals('published', $event->status);

        // Verify dashboard reflects the approved event as "Published" count = 1
        $this->session(['company_id' => $this->company->id, 'company_flow_context' => 'event_company']);
        $response = $this->get(route('company.event-company-flow.dashboard'));
        $response->assertStatus(200);
        $response->assertSee('Published');
        $response->assertSee('1');

        // 9. Log back in as company to pay the publishing fee
        $response = $this->get(route('company.event-company-flow.payment.show', $event->id));
        $response->assertStatus(200);
        $response->assertSee('Acme Global Summit 2026');

        $response = $this->post(route('company.event-company-flow.payment.pay', $event->id));
        $response->assertRedirect(route('company.event-company-flow.dashboard'));

        // 10. Log in as admin and publish the event
        $this->session(['admin_id' => $admin->id]);
        $response = $this->post(route('admin.event-approvals.publish', $publishRequest->id));
        $response->assertRedirect();

        $event->refresh();
        $this->assertEquals('published', $event->status);
        $this->assertNotNull($event->published_at);

        // Restore company session
        $this->session(['company_id' => $this->company->id, 'company_flow_context' => 'event_company']);

        // 9. Visit public event listings and verify the user-created event is listed
        $response = $this->get(route('events.listings.index'));
        $response->assertStatus(200);
        $response->assertSee('Acme Global Summit 2026');

        // 10. View public event details and check that dynamic details render
        $response = $this->get(route('events.listings.show', $event->slug));
        $response->assertStatus(200);
        $response->assertSee('Acme Global Summit 2026');
        $response->assertSee('Silicon Valley Center');
        $response->assertSee('Accelerating Innovation');
        $response->assertSee('Get Visitor Pass');

        // 11. Navigate to visitor pass flow
        $response->assertRedirect(route('events.tickets.visitor-details', ['event' => $event->slug]));

        $response = $this->get(route('events.tickets.visitor-details', ['event' => $event->slug]));
        $response->assertStatus(200);
        $response->assertSee('Acme Global Summit 2026');
        $response->assertSee('Get Visitor Pass');
        $response->assertSee('Visitor Registration');
        $response->assertSee('Continue to Ticket Selection');

        $response = $this->post(route('events.tickets.visitor-details.store'), [
            'event' => $event->slug,
            'name' => 'Flow Test Visitor',
            'email' => 'flowvisitor@example.com',
            'password' => 'password123',
            'phone' => '9876543210',
            'gender' => 'male',
            'city' => 'Bengaluru',
        ]);
        $response->assertRedirect(route('events.tickets.attendee-details', ['event' => $event->slug]));

        $response = $this->get(route('events.tickets.attendee-details', ['event' => $event->slug]));
        $response->assertStatus(200);
        $response->assertSee('Select Your Tickets');
        $response->assertSee('Regular Pass');
        $response->assertSee('VIP Pass');
        $response->assertSee('INR 99.00');
        $response->assertSee('INR 299.00');
        $response->assertSee('Continue to Payment');
    }
}
