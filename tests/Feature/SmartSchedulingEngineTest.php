<?php

namespace Tests\Feature;

use App\Domain\Company\Models\Company;
use App\Domain\Company\Models\CompanyMeeting;
use App\Domain\Event\Models\Exhibition;
use App\Domain\Shared\Services\SmartSchedulingEngine;
use App\Domain\Visitor\Models\VisitorMeetingBooking;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SmartSchedulingEngineTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        putenv('APP_SEED_DEMO=true');
        $this->seed();
    }

    public function test_exhibition_date_boundary_validation()
    {
        $exhibition = Exhibition::first();
        if (!$exhibition) {
            $exhibition = Exhibition::create([
                'title' => 'Test Expo',
                'slug' => 'test-expo',
                'start_date' => '2026-06-10 00:00:00',
                'end_date' => '2026-06-12 23:59:59',
                'status' => 'published',
            ]);
        } else {
            $exhibition->update([
                'start_date' => '2026-06-10 00:00:00',
                'end_date' => '2026-06-12 23:59:59',
            ]);
        }

        $company = Company::first() ?: Company::create([
            'company_name' => 'Test Company',
            'contact_person_name' => 'John Doe',
            'email' => 'company@example.com',
            'phone' => '1234567890',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'status' => 'approved',
        ]);

        $engine = new SmartSchedulingEngine();

        // 1. Outside exhibition dates (before start)
        $res = $engine->validateMeetingRequest(
            $company->id,
            null,
            'visitor@test.com',
            '2026-06-09',
            '10:00:00',
            'one-to-one',
            $exhibition->id
        );
        $this->assertFalse($res['valid']);
        $this->assertStringContainsString('exhibition dates', $res['conflict']);

        // 2. Inside exhibition dates
        $res2 = $engine->validateMeetingRequest(
            $company->id,
            null,
            'visitor@test.com',
            '2026-06-11',
            '10:00:00',
            'one-to-one',
            $exhibition->id
        );
        $this->assertTrue($res2['valid']);
    }

    public function test_visitor_overlapping_conflict()
    {
        $exhibition = Exhibition::first();
        if (!$exhibition) {
            $exhibition = Exhibition::create([
                'title' => 'Test Expo',
                'slug' => 'test-expo',
                'start_date' => '2026-06-10 00:00:00',
                'end_date' => '2026-06-12 23:59:59',
                'status' => 'published',
            ]);
        } else {
            $exhibition->update([
                'start_date' => '2026-06-10 00:00:00',
                'end_date' => '2026-06-12 23:59:59',
            ]);
        }

        $company1 = Company::first() ?: Company::create([
            'company_name' => 'Test Company 1',
            'contact_person_name' => 'John Doe',
            'email' => 'company1@example.com',
            'phone' => '1234567890',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'status' => 'approved',
        ]);

        $company2 = Company::create([
            'company_name' => 'Test Company 2',
            'contact_person_name' => 'Jane Doe',
            'email' => 'company2@example.com',
            'phone' => '0987654321',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'status' => 'approved',
        ]);

        $user = \App\Domain\Shared\Models\User::first() ?: \App\Domain\Shared\Models\User::create([
            'name' => 'John Doe',
            'email' => 'visitor@test.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
        ]);
        $userId = $user->id;

        // Create an existing meeting for visitor at 10:00 on June 11
        $meeting1 = CompanyMeeting::create([
            'company_id' => $company1->id,
            'title' => 'Meeting 1',
            'meeting_type' => 'one-to-one',
            'start_time' => '2026-06-11 10:00:00',
            'end_time' => '2026-06-11 10:30:00',
            'meeting_date' => '2026-06-11',
            'meeting_time' => '10:00:00',
            'status' => 'confirmed',
        ]);

        $visitorBooking1 = VisitorMeetingBooking::create([
            'company_id' => $company1->id,
            'company_meeting_id' => $meeting1->id,
            'visitor_id' => $userId,
            'visitor_name' => 'John Doe',
            'visitor_email' => 'visitor@test.com',
            'meeting_topic' => 'Topic 1',
            'status' => 'confirmed',
        ]);

        $engine = new SmartSchedulingEngine();

        // Request overlapping meeting at 10:15
        $res = $engine->validateMeetingRequest(
            $company2->id,
            $userId,
            'visitor@test.com',
            '2026-06-11',
            '10:15:00',
            'one-to-one',
            $exhibition->id
        );

        $this->assertFalse($res['valid']);
        $this->assertStringContainsString('overlapping', $res['conflict']);
    }
}
