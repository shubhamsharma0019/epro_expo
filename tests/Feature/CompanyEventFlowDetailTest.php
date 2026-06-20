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
        ]);
    }

    public function test_complete_company_event_and_visitor_booking_flow(): void
    {
        // 1. Company Login (set session)
        $this->session(['company_id' => $this->company->id]);

        // 2. Access Event Dashboard
        $response = $this->get(route('company.event-company-flow.dashboard'));
        $response->assertStatus(200);

        // 3. Initialize Draft Event on Create
        $response = $this->get(route('company.event-company-flow.create'));
        $response->assertStatus(200);

        $event = CompanyEvent::firstOrFail();
        $this->assertEquals('draft', $event->status);
        $this->assertEquals($this->company->id, $event->company_id);

        // 4. Update Basic details (Name, Dates, Location, Category)
        $response = $this->post(route('company.event-company-flow.basic.update', $event->id), [
            'title' => 'Acme Global Summit 2026',
            'category' => 'Technology',
            'event_type' => 'in_person',
            'event_mode' => 'in_person',
            'starts_at' => '2026-07-15 09:00:00',
            'ends_at' => '2026-07-17 18:00:00',
            'timezone' => 'Asia/Kolkata',
            'venue_name' => 'Silicon Valley Center',
            'venue_address' => '123 Tech Way',
            'city' => 'San Jose',
            'country' => 'USA',
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
        $this->session(['company_id' => $this->company->id]);
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
        $this->session(['company_id' => $this->company->id]);

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
        $response->assertSee('Rs. 99.00'); // Minimum price check

        // 11. Navigate to ticket booking screen and verify actual database ticket types load
        $visitorUser = \App\Domain\Shared\Models\User::create([
            'name' => 'Visitor User',
            'email' => 'visitor@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);
        $this->actingAs($visitorUser);

        $response = $this->get(route('events.tickets.select', ['event' => $event->slug]));
        $response->assertStatus(200);
        $response->assertSee('Acme Global Summit 2026');
        $response->assertSee('Regular Pass');
        $response->assertSee('VIP Pass');
        $response->assertSee('INR 99.00');
        $response->assertSee('INR 299.00');
    }
}
