<?php

namespace Tests\Feature;

use App\Models\Booth;
use App\Models\BoothBooking;
use App\Models\BoothBookingSummary;
use App\Models\BoothSize;
use App\Models\Company;
use App\Models\Exhibition;
use App\Models\Hall;
use App\Models\Pavilion;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class CompanyBoothBookingDaysFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_selected_days_update_payment_and_reflect_on_summary(): void
    {
        $company = Company::create([
            'company_name' => 'Acme Exhibitors',
            'contact_person_name' => 'Ritik',
            'email' => 'ritik@example.com',
            'phone' => '9999999999',
            'password' => Hash::make('password'),
            'status' => 'approved',
        ]);

        $exhibition = Exhibition::create([
            'title' => 'Global Tech Expo',
            'slug' => 'global-tech-expo',
            'start_date' => '2026-06-12',
            'end_date' => '2026-06-14',
            'status' => 'active',
        ]);

        $pavilion = Pavilion::create([
            'exhibition_id' => $exhibition->id,
            'title' => 'Innovation Pavilion',
            'slug' => 'innovation-pavilion',
            'status' => 'active',
        ]);

        $hall = Hall::create([
            'pavilion_id' => $pavilion->id,
            'title' => 'Hall 1',
            'slug' => 'hall-1',
            'status' => 'active',
        ]);

        $size = BoothSize::create([
            'title' => '3m x 3m',
            'width' => 3,
            'height' => 3,
            'area' => 9,
            'price' => 499,
            'status' => 'active',
        ]);

        $booth = Booth::create([
            'hall_id' => $hall->id,
            'booth_size_id' => $size->id,
            'booth_number' => 'B01',
            'price' => 499,
            'status' => 'available',
        ]);

        $this->withSession(['company_id' => $company->id])
            ->post(route('company.booth-booking.slots.days'), [
                'hall_id' => $hall->id,
                'booth_id' => $booth->id,
                'size_id' => $size->id,
                'days_count' => 3,
            ])
            ->assertRedirect();

        $booking = BoothBooking::with('days')->firstOrFail();
        $this->assertSame(3, $booking->days->count());
        $this->assertSame('6496.00', (string) $booking->total_amount);

        $this->withSession([
            'company_id' => $company->id,
            'company_booth_booking' => [
                'booth_booking_id' => $booking->id,
                'hall_id' => $hall->id,
                'pavilion_id' => $pavilion->id,
                'exhibition_id' => $exhibition->id,
                'booth_id' => $booth->id,
                'booth_size_id' => $size->id,
            ],
        ])
            ->post(route('company.booth-booking.slots.continue'), [
                'hall_id' => $hall->id,
                'booth_id' => $booth->id,
                'size_id' => $size->id,
                'days_count' => 3,
            ])
            ->assertRedirect('/company/booth-booking/summary');

        $this->withSession([
            'company_id' => $company->id,
            'company_booth_booking' => ['booth_booking_id' => $booking->id],
        ])
            ->get(route('company.booth-booking.summary'))
            ->assertOk()
            ->assertSee('Selected Days')
            ->assertSee('3')
            ->assertSee('&#8377;6,496', false);

        $summary = BoothBookingSummary::firstOrFail();
        $this->assertSame(3, $summary->selected_days_count);
        $this->assertSame('6496.00', (string) $summary->total_amount);
    }

    public function test_services_are_saved_and_increase_booking_total(): void
    {
        $company = Company::create([
            'company_name' => 'Acme Exhibitors',
            'contact_person_name' => 'Ritik',
            'email' => 'ritik-services@example.com',
            'phone' => '9999999999',
            'password' => Hash::make('password'),
            'status' => 'approved',
        ]);

        $exhibition = Exhibition::create([
            'title' => 'Global Tech Expo',
            'slug' => 'global-tech-expo-services',
            'start_date' => '2026-06-12',
            'end_date' => '2026-06-14',
            'status' => 'active',
        ]);

        $pavilion = Pavilion::create([
            'exhibition_id' => $exhibition->id,
            'title' => 'Innovation Pavilion',
            'slug' => 'innovation-pavilion-services',
            'status' => 'active',
        ]);

        $hall = Hall::create([
            'pavilion_id' => $pavilion->id,
            'title' => 'Hall 1',
            'slug' => 'hall-1-services',
            'status' => 'active',
        ]);

        $size = BoothSize::create([
            'title' => '3m x 3m',
            'width' => 3,
            'height' => 3,
            'area' => 9,
            'price' => 499,
            'status' => 'active',
        ]);

        $booth = Booth::create([
            'hall_id' => $hall->id,
            'booth_size_id' => $size->id,
            'booth_number' => 'B01',
            'price' => 499,
            'status' => 'available',
        ]);

        $service = Service::create([
            'title' => 'Featured Listing',
            'description' => 'Top listing',
            'price' => 99,
            'status' => 'active',
        ]);

        $this->withSession(['company_id' => $company->id])
            ->post(route('company.booth-booking.slots.days'), [
                'hall_id' => $hall->id,
                'booth_id' => $booth->id,
                'size_id' => $size->id,
                'days_count' => 3,
            ]);

        $booking = BoothBooking::firstOrFail();

        $this->withSession([
            'company_id' => $company->id,
            'company_booth_booking' => ['booth_booking_id' => $booking->id],
        ])
            ->post(route('company.booth-booking.services.toggle'), [
                'service_id' => $service->id,
            ])
            ->assertRedirect('/company/booth-booking/services');

        $booking->refresh();
        $this->assertSame('99.00', (string) $booking->services_amount);
        $this->assertSame('6595.00', (string) $booking->total_amount);
        $this->assertDatabaseHas('booking_services', [
            'booth_booking_id' => $booking->id,
            'service_id' => $service->id,
            'quantity' => 1,
            'total' => 99,
        ]);

        $this->withSession([
            'company_id' => $company->id,
            'company_booth_booking' => ['booth_booking_id' => $booking->id],
        ])
            ->post(route('company.booth-booking.services.quantity'), [
                'service_id' => $service->id,
                'quantity' => 3,
            ])
            ->assertRedirect('/company/booth-booking/services');

        $booking->refresh();
        $this->assertSame('297.00', (string) $booking->services_amount);
        $this->assertSame('6793.00', (string) $booking->total_amount);
        $this->assertDatabaseHas('booking_services', [
            'booth_booking_id' => $booking->id,
            'service_id' => $service->id,
            'quantity' => 3,
            'total' => 297,
        ]);

        $this->withSession([
            'company_id' => $company->id,
            'company_booth_booking' => ['booth_booking_id' => $booking->id],
        ])
            ->get(route('company.booth-booking.services'))
            ->assertOk()
            ->assertSee('Featured Listing')
            ->assertSee('x3')
            ->assertSee('&#8377;6,793', false);

        $this->withSession([
            'company_id' => $company->id,
            'company_booth_booking' => ['booth_booking_id' => $booking->id],
        ])
            ->post(route('company.booth-booking.services.continue'))
            ->assertRedirect('/company/booth-booking/review');

        $this->withSession([
            'company_id' => $company->id,
            'company_booth_booking' => ['booth_booking_id' => $booking->id],
        ])
            ->get(route('company.booth-booking.review'))
            ->assertOk()
            ->assertSee('Featured Listing x3')
            ->assertSee('&#8377;6,793', false);

        $this->withSession([
            'company_id' => $company->id,
            'company_booth_booking' => ['booth_booking_id' => $booking->id],
        ])
            ->get(route('company.booth-booking.payment'))
            ->assertOk()
            ->assertSee('1 Selected')
            ->assertSee('&#8377;6,793', false);

        $summary = BoothBookingSummary::where('booth_booking_id', $booking->id)->firstOrFail();
        $this->assertSame('297.00', (string) $summary->services_amount);
        $this->assertSame('6793.00', (string) $summary->total_amount);
    }

    public function test_razorpay_payment_is_verified_before_booking_confirmation(): void
    {
        config([
            'services.razorpay.key' => 'rzp_test_key',
            'services.razorpay.secret' => 'test_secret',
            'services.razorpay.currency' => 'INR',
        ]);

        Http::fake([
            'api.razorpay.com/v1/orders' => Http::response([
                'id' => 'order_test_123',
                'amount' => 649600,
                'currency' => 'INR',
            ], 200),
        ]);

        $company = Company::create([
            'company_name' => 'Acme Exhibitors',
            'contact_person_name' => 'Ritik',
            'email' => 'razorpay@example.com',
            'phone' => '9999999999',
            'password' => Hash::make('password'),
            'status' => 'approved',
        ]);

        $exhibition = Exhibition::create([
            'title' => 'Global Tech Expo',
            'slug' => 'global-tech-expo-razorpay',
            'start_date' => '2026-06-12',
            'end_date' => '2026-06-14',
            'status' => 'active',
        ]);

        $pavilion = Pavilion::create([
            'exhibition_id' => $exhibition->id,
            'title' => 'Innovation Pavilion',
            'slug' => 'innovation-pavilion-razorpay',
            'status' => 'active',
        ]);

        $hall = Hall::create([
            'pavilion_id' => $pavilion->id,
            'title' => 'Hall 1',
            'slug' => 'hall-1-razorpay',
            'status' => 'active',
        ]);

        $size = BoothSize::create([
            'title' => '3m x 3m',
            'width' => 3,
            'height' => 3,
            'area' => 9,
            'price' => 499,
            'status' => 'active',
        ]);

        $booth = Booth::create([
            'hall_id' => $hall->id,
            'booth_size_id' => $size->id,
            'booth_number' => 'B01',
            'price' => 499,
            'status' => 'available',
        ]);

        $this->withSession(['company_id' => $company->id])
            ->post(route('company.booth-booking.slots.days'), [
                'hall_id' => $hall->id,
                'booth_id' => $booth->id,
                'size_id' => $size->id,
                'days_count' => 3,
            ]);

        $booking = BoothBooking::firstOrFail();
        $session = [
            'company_id' => $company->id,
            'company_booth_booking' => ['booth_booking_id' => $booking->id],
        ];

        $this->withSession($session)
            ->get(route('company.booth-booking.confirmed'))
            ->assertRedirect('/company/booth-booking/payment');

        $this->withSession($session)
            ->postJson(route('company.booth-booking.payment.razorpay-order'))
            ->assertOk()
            ->assertJsonPath('order_id', 'order_test_123');

        $booking->refresh();
        $this->assertSame('order_test_123', $booking->razorpay_order_id);

        $paymentId = 'pay_test_123';
        $signature = hash_hmac('sha256', $booking->razorpay_order_id . '|' . $paymentId, 'test_secret');

        $this->withSession($session)
            ->postJson(route('company.booth-booking.payment.verify'), [
                'razorpay_order_id' => $booking->razorpay_order_id,
                'razorpay_payment_id' => $paymentId,
                'razorpay_signature' => $signature,
            ])
            ->assertOk()
            ->assertJsonPath('redirect_url', url('/company/booth-booking/confirmed'));

        $booking->refresh();
        $this->assertSame('paid', $booking->payment_status);
        $this->assertSame('confirmed', $booking->booking_status);
        $this->assertSame($paymentId, $booking->razorpay_payment_id);
        $this->assertNotNull($booking->paid_at);
        $this->assertDatabaseHas('booths', [
            'id' => $booth->id,
            'status' => 'booked',
        ]);
    }

    public function test_paid_booking_opens_setup_pages_and_blocks_other_company_access(): void
    {
        $company = Company::create([
            'company_name' => 'Setup Company',
            'contact_person_name' => 'Ritik',
            'email' => 'setup@example.com',
            'phone' => '9999999999',
            'password' => Hash::make('password'),
            'status' => 'approved',
        ]);

        $otherCompany = Company::create([
            'company_name' => 'Other Company',
            'contact_person_name' => 'Other',
            'email' => 'other@example.com',
            'phone' => '8888888888',
            'password' => Hash::make('password'),
            'status' => 'approved',
        ]);

        $exhibition = Exhibition::create([
            'title' => 'Setup Expo',
            'slug' => 'setup-expo',
            'start_date' => '2026-06-12',
            'end_date' => '2026-06-14',
            'status' => 'active',
        ]);

        $pavilion = Pavilion::create([
            'exhibition_id' => $exhibition->id,
            'title' => 'Setup Pavilion',
            'slug' => 'setup-pavilion',
            'status' => 'active',
        ]);

        $hall = Hall::create([
            'pavilion_id' => $pavilion->id,
            'title' => 'Setup Hall',
            'slug' => 'setup-hall',
            'status' => 'active',
        ]);

        $size = BoothSize::create([
            'title' => '3m x 3m',
            'width' => 3,
            'height' => 3,
            'area' => 9,
            'price' => 499,
            'status' => 'active',
        ]);

        $booth = Booth::create([
            'hall_id' => $hall->id,
            'booth_size_id' => $size->id,
            'booth_number' => 'S01',
            'price' => 499,
            'status' => 'booked',
        ]);

        $booking = BoothBooking::create([
            'company_id' => $company->id,
            'exhibition_id' => $exhibition->id,
            'pavilion_id' => $pavilion->id,
            'hall_id' => $hall->id,
            'booth_size_id' => $size->id,
            'booth_id' => $booth->id,
            'amount' => 499,
            'services_amount' => 0,
            'total_amount' => 499,
            'payment_status' => 'paid',
            'booking_status' => 'confirmed',
            'admin_status' => 'approved',
            'paid_at' => now(),
        ]);

        $this->withSession(['company_id' => $company->id])
            ->get(route('company.bookings.show', $booking))
            ->assertOk()
            ->assertSee('Setup Expo')
            ->assertSee('Setup Pavilion')
            ->assertSee('S01')
            ->assertSee(route('company.booth-setup.index', $booking), false);

        $this->withSession(['company_id' => $company->id])
            ->get('/company/booth-setup/products')
            ->assertRedirect(route('company.booth-setup.products.index', $booking));

        $this->withSession(['company_id' => $company->id])
            ->get(route('company.booth-setup.index', $booking))
            ->assertOk()
            ->assertSee('Company Profile')
            ->assertSee('Booth Branding')
            ->assertSee('Publish Booth');

        $draftBooth = Booth::create([
            'hall_id' => $hall->id,
            'booth_size_id' => $size->id,
            'booth_number' => 'S02',
            'price' => 499,
            'status' => 'available',
        ]);

        $draftBooking = BoothBooking::create([
            'company_id' => $company->id,
            'exhibition_id' => $exhibition->id,
            'pavilion_id' => $pavilion->id,
            'hall_id' => $hall->id,
            'booth_size_id' => $size->id,
            'booth_id' => $draftBooth->id,
            'amount' => 499,
            'services_amount' => 0,
            'total_amount' => 499,
            'payment_status' => 'pending',
            'booking_status' => 'draft',
            'admin_status' => 'pending',
        ]);

        $this->withSession(['company_id' => $company->id])
            ->get(route('company.booth-setup.index', $draftBooking))
            ->assertForbidden();

        $this->withSession(['company_id' => $company->id])
            ->post(route('company.booth-setup.profile.update', $booking), [
                'company_name' => 'Setup Company',
                'contact_person' => 'Ritik',
                'industry' => 'Software Development',
                'email' => 'setup@example.com',
                'phone' => '9999999999',
                'tagline' => 'Real booth setup',
                'website' => 'https://example.com',
                'about_company' => 'Backend-connected profile.',
                'address' => '123 Expo Street',
                'city' => 'Kolkata',
                'state' => 'California',
                'zip_code' => '700001',
                'country' => 'India',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('booth_profiles', [
            'booth_booking_id' => $booking->id,
            'company_id' => $company->id,
            'company_name' => 'Setup Company',
        ]);

        $this->assertDatabaseHas('booth_setup_steps', [
            'booth_booking_id' => $booking->id,
            'step_key' => 'profile',
            'status' => 'completed',
        ]);

        $this->withSession(['company_id' => $otherCompany->id])
            ->get(route('company.booth-setup.index', $booking))
            ->assertForbidden();
    }
}
