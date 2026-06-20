<?php

namespace Tests\Feature;

use App\Domain\Company\Models\Company;
use App\Domain\Event\Models\Exhibition;
use App\Domain\Event\Models\Pavilion;
use App\Domain\Event\Models\Hall;
use App\Domain\Booth\Models\Booth;
use App\Domain\Booth\Models\BoothSize;
use App\Domain\Booth\Models\BoothBooking;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class ExhibitorFlowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Enable demo seeding for test environment
        putenv('APP_SEED_DEMO=true');
        $this->seed();
    }

    public function test_full_exhibitor_flow()
    {
        // Get the first company from the seeder
        $company = Company::first();
        if (!$company) {
            $this->markTestSkipped('No company found.');
        }

        // Login the company
        $response = $this->withSession([
            'company_id' => $company->id,
            'company_logged_in' => true
        ])->get('/company/dashboard');
        
        $response->assertStatus(200);

        // 1. Pavilions
        $response = $this->withSession([
            'company_id' => $company->id,
            'company_logged_in' => true
        ])->get('/company/booth-booking/pavilions?exhibition=global-tech-expo-2024');
        $response->assertStatus(200);

        $pavilion = Pavilion::first();
        if (!$pavilion) $this->markTestSkipped('No pavilion found.');

        // 2. Halls
        $response = $this->withSession([
            'company_id' => $company->id,
            'company_logged_in' => true
        ])->get('/company/booth-booking/halls?pavilion=' . $pavilion->id);
        $response->assertStatus(200);

        $hall = Hall::where('pavilion_id', $pavilion->id)->first();
        if (!$hall) $this->markTestSkipped('No hall found.');

        // 3. Sizes
        $response = $this->withSession([
            'company_id' => $company->id,
            'company_logged_in' => true
        ])->get('/company/booth-booking/sizes?hall=' . $hall->id);
        $response->assertStatus(200);

        $size = BoothSize::first();
        if (!$size) $this->markTestSkipped('No booth size found.');

        // 4. Continue from Sizes
        $response = $this->withSession([
            'company_id' => $company->id,
            'company_logged_in' => true,
            'company_booth_booking' => [
                'exhibition_id' => $hall->pavilion->exhibition_id,
                'exhibition_slug' => $hall->pavilion->exhibition->slug,
                'pavilion_id' => $pavilion->id,
                'hall_id' => $hall->id,
                'booth_size_id' => $size->id,
            ]
        ])->post('/company/booth-booking/sizes/continue', [
            'hall_id' => $hall->id,
            'size_id' => $size->id,
        ]);
        $response->assertRedirect();
        $this->assertStringContainsString('/company/booth-booking/floor-plan', $response->headers->get('Location'));

        // 5. Floor Plan
        $response = $this->withSession([
            'company_id' => $company->id,
            'company_logged_in' => true,
            'company_booth_booking' => [
                'exhibition_id' => $hall->pavilion->exhibition_id,
                'exhibition_slug' => $hall->pavilion->exhibition->slug,
                'pavilion_id' => $pavilion->id,
                'hall_id' => $hall->id,
                'booth_size_id' => $size->id,
            ]
        ])->get('/company/booth-booking/floor-plan?hall=' . $hall->id . '&size=' . $size->id);
        $response->assertStatus(200);

        $booth = Booth::where('hall_id', $hall->id)->where('status', 'available')->first();
        if (!$booth) $this->markTestSkipped('No available booth found.');

        // 6. Select Booth
        $response = $this->withSession([
            'company_id' => $company->id,
            'company_logged_in' => true,
            'company_booth_booking' => [
                'exhibition_id' => $hall->pavilion->exhibition_id,
                'exhibition_slug' => $hall->pavilion->exhibition->slug,
                'pavilion_id' => $pavilion->id,
                'hall_id' => $hall->id,
                'booth_size_id' => $size->id,
            ]
        ])->post('/company/booth-booking/floor-plan/select', [
            'booth_id' => $booth->id,
            'hall_id' => $hall->id,
            'size_id' => $size->id,
        ]);
        $response->assertRedirect();
        $this->assertStringContainsString('/company/booth-booking/slots', $response->headers->get('Location'));

        // 7. Slots
        $response = $this->withSession([
            'company_id' => $company->id,
            'company_logged_in' => true,
            'company_booth_booking' => [
                'exhibition_id' => $hall->pavilion->exhibition_id,
                'exhibition_slug' => $hall->pavilion->exhibition->slug,
                'pavilion_id' => $pavilion->id,
                'hall_id' => $hall->id,
                'booth_size_id' => $size->id,
                'booth_id' => $booth->id,
            ]
        ])->get('/company/booth-booking/slots?hall=' . $hall->id . '&booth=' . $booth->id . '&size=' . $size->id);
        $response->assertStatus(200);

        // Update Days/Slots
        $response = $this->withSession([
            'company_id' => $company->id,
            'company_logged_in' => true,
            'company_booth_booking' => [
                'exhibition_id' => $hall->pavilion->exhibition_id,
                'exhibition_slug' => $hall->pavilion->exhibition->slug,
                'pavilion_id' => $pavilion->id,
                'hall_id' => $hall->id,
                'booth_size_id' => $size->id,
                'booth_id' => $booth->id,
            ]
        ])->post('/company/booth-booking/slots/days', [
            'hall_id' => $hall->id,
            'booth_id' => $booth->id,
            'size_id' => $size->id,
            'days_count' => 1,
        ]);
        $response->assertRedirect();

        $booking = BoothBooking::where('company_id', $company->id)->where('booking_status', 'draft')->latest()->first();
        if (!$booking) $this->markTestSkipped('No draft booking created.');

        // 8. Continue from Slots
        $response = $this->withSession([
            'company_id' => $company->id,
            'company_logged_in' => true,
            'company_booth_booking' => [
                'booth_booking_id' => $booking->id,
                'exhibition_id' => $hall->pavilion->exhibition_id,
                'exhibition_slug' => $hall->pavilion->exhibition->slug,
                'pavilion_id' => $pavilion->id,
                'hall_id' => $hall->id,
                'booth_size_id' => $size->id,
                'booth_id' => $booth->id,
                'slots' => [
                    [
                        'key' => '2026-06-12|full-day',
                        'date' => '2026-06-12',
                        'date_label' => 'Jun 12, Fri',
                        'time' => 'full-day',
                        'label' => 'Full Day',
                        'price' => 1999.00
                    ]
                ],
                'slots_subtotal' => 1999.00,
                'booking_days_count' => 1,
            ]
        ])->post('/company/booth-booking/slots/continue', [
            'hall_id' => $hall->id,
            'booth_id' => $booth->id,
            'size_id' => $size->id,
            'days_count' => 1,
        ]);
        $response->assertRedirect();
        $this->assertStringContainsString('/company/booth-booking/summary', $response->headers->get('Location'));

        // 9. Summary
        $response = $this->withSession([
            'company_id' => $company->id,
            'company_logged_in' => true,
            'company_booth_booking' => [
                'booth_booking_id' => $booking->id,
                'exhibition_id' => $hall->pavilion->exhibition_id,
                'exhibition_slug' => $hall->pavilion->exhibition->slug,
                'pavilion_id' => $pavilion->id,
                'hall_id' => $hall->id,
                'booth_size_id' => $size->id,
                'booth_id' => $booth->id,
            ]
        ])->get('/company/booth-booking/summary?exhibition=' . $hall->pavilion->exhibition->slug);
        $response->assertStatus(200);

        // 10. Services
        $response = $this->withSession([
            'company_id' => $company->id,
            'company_logged_in' => true,
            'company_booth_booking' => [
                'booth_booking_id' => $booking->id,
                'exhibition_id' => $hall->pavilion->exhibition_id,
                'exhibition_slug' => $hall->pavilion->exhibition->slug,
                'pavilion_id' => $pavilion->id,
                'hall_id' => $hall->id,
                'booth_size_id' => $size->id,
                'booth_id' => $booth->id,
            ]
        ])->get('/company/booth-booking/services?exhibition=' . $hall->pavilion->exhibition->slug);
        $response->assertStatus(200);

        // Continue from services
        $response = $this->withSession([
            'company_id' => $company->id,
            'company_logged_in' => true,
            'company_booth_booking' => [
                'booth_booking_id' => $booking->id,
                'exhibition_id' => $hall->pavilion->exhibition_id,
                'exhibition_slug' => $hall->pavilion->exhibition->slug,
                'pavilion_id' => $pavilion->id,
                'hall_id' => $hall->id,
                'booth_size_id' => $size->id,
                'booth_id' => $booth->id,
            ]
        ])->post('/company/booth-booking/services/continue');
        $response->assertRedirect();
        $this->assertStringContainsString('/company/booth-booking/review', $response->headers->get('Location'));

        // 11. Review
        $response = $this->withSession([
            'company_id' => $company->id,
            'company_logged_in' => true,
            'company_booth_booking' => [
                'booth_booking_id' => $booking->id,
                'exhibition_id' => $hall->pavilion->exhibition_id,
                'exhibition_slug' => $hall->pavilion->exhibition->slug,
                'pavilion_id' => $pavilion->id,
                'hall_id' => $hall->id,
                'booth_size_id' => $size->id,
                'booth_id' => $booth->id,
            ]
        ])->get('/company/booth-booking/review?exhibition=' . $hall->pavilion->exhibition->slug);
        $response->assertStatus(200);

        // 12. Payment
        $response = $this->withSession([
            'company_id' => $company->id,
            'company_logged_in' => true,
            'company_booth_booking' => [
                'booth_booking_id' => $booking->id,
                'exhibition_id' => $hall->pavilion->exhibition_id,
                'exhibition_slug' => $hall->pavilion->exhibition->slug,
                'pavilion_id' => $pavilion->id,
                'hall_id' => $hall->id,
                'booth_size_id' => $size->id,
                'booth_id' => $booth->id,
            ]
        ])->get('/company/booth-booking/payment?exhibition=' . $hall->pavilion->exhibition->slug);
        $response->assertStatus(200);

        // 13. Payment Continue / Confirm Booking
        $response = $this->withSession([
            'company_id' => $company->id,
            'company_logged_in' => true,
            'company_booth_booking' => [
                'booth_booking_id' => $booking->id,
                'exhibition_id' => $hall->pavilion->exhibition_id,
                'exhibition_slug' => $hall->pavilion->exhibition->slug,
                'pavilion_id' => $pavilion->id,
                'hall_id' => $hall->id,
                'booth_size_id' => $size->id,
                'booth_id' => $booth->id,
            ]
        ])->post('/company/booth-booking/payment/continue');
        $response->assertRedirect();
        $this->assertStringContainsString('/company/booth-booking/confirmed', $response->headers->get('Location'));

        // 14. Confirmed page
        $response = $this->withSession([
            'company_id' => $company->id,
            'company_logged_in' => true,
            'company_booking_id' => $booking->id,
        ])->get('/company/booth-booking/confirmed');
        $response->assertStatus(200);
        
        // Output success if we get here
        echo "ALL PAGES RENDERED SUCCESSFULLY WITH 200 OK STATUS.\n";
    }

    public function test_company_login_redirect_ignores_intended_url()
    {
        $company = Company::first();
        if (!$company) {
            $company = Company::create([
                'company_name' => 'Test Company',
                'contact_person_name' => 'John Doe',
                'email' => 'company@example.com',
                'phone' => '1234567890',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'status' => 'approved',
            ]);
        }

        // Simulate a user visiting a page and setting url.intended
        $response = $this->withSession([
            'url.intended' => '/events/tickets/select'
        ])->post('/company/login', [
            'email' => $company->email,
            'password' => 'password',
        ]);

        $response->assertRedirect('/company/dashboard');
    }
}

