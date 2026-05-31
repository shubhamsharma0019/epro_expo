<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Exhibition;
use App\Models\Pavilion;
use App\Models\Hall;
use App\Models\Booth;
use App\Models\BoothSize;
use App\Models\BoothBooking;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class ExhibitorFlowTest extends TestCase
{
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
        ])->get('/company/booth-booking/pavilions');
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

        // 3. Floor plan
        $response = $this->withSession([
            'company_id' => $company->id,
            'company_logged_in' => true
        ])->get('/company/booth-booking/floor-plan?hall=' . $hall->id);
        $response->assertStatus(200);

        $booth = Booth::where('hall_id', $hall->id)->first();
        if (!$booth) $this->markTestSkipped('No booth found.');

        // 4. Select Booth
        $response = $this->withSession([
            'company_id' => $company->id,
            'company_logged_in' => true
        ])->post('/company/booth-booking/floor-plan/select', [
            'booth_id' => $booth->id,
            'hall_id' => $hall->id
        ]);
        $response->assertRedirect('/company/booth-booking/sizes');

        // 5. Sizes
        $booking = BoothBooking::latest()->first();
        $response = $this->withSession([
            'company_id' => $company->id,
            'company_logged_in' => true,
            'current_booking_id' => $booking->id
        ])->get('/company/booth-booking/sizes');
        $response->assertStatus(200);

        $size = BoothSize::first();
        
        // 6. Select Size
        $response = $this->withSession([
            'company_id' => $company->id,
            'company_logged_in' => true,
            'current_booking_id' => $booking->id
        ])->post('/company/booth-booking/sizes/select', [
            'size_id' => $size->id
        ]);
        $response->assertRedirect('/company/booth-booking/slots');

        // 7. Slots
        $response = $this->withSession([
            'company_id' => $company->id,
            'company_logged_in' => true,
            'current_booking_id' => $booking->id
        ])->get('/company/booth-booking/slots');
        $response->assertStatus(200);

        // 8. Services
        $response = $this->withSession([
            'company_id' => $company->id,
            'company_logged_in' => true,
            'current_booking_id' => $booking->id
        ])->get('/company/booth-booking/services');
        $response->assertStatus(200);

        // 9. Review
        $response = $this->withSession([
            'company_id' => $company->id,
            'company_logged_in' => true,
            'current_booking_id' => $booking->id
        ])->get('/company/booth-booking/review');
        $response->assertStatus(200);

        // 10. Payment
        $response = $this->withSession([
            'company_id' => $company->id,
            'company_logged_in' => true,
            'current_booking_id' => $booking->id
        ])->get('/company/booth-booking/payment');
        $response->assertStatus(200);
        
        // Output success if we get here
        echo "ALL PAGES RENDERED SUCCESSFULLY WITH 200 OK STATUS.\n";
    }
}
