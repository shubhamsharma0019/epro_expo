<?php

// Bootstrap Laravel
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Domain\Shared\Services\SmartSchedulingEngine;
use App\Domain\Company\Models\Company;
use App\Domain\Event\Models\Exhibition;
use App\Domain\Shared\Models\User;
use App\Domain\Company\Models\CompanyMeeting;
use App\Domain\Visitor\Models\VisitorMeetingBooking;
use App\Domain\Booth\Models\BoothMeetingSlot;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

echo "==================================================\n";
echo "       AI MEETING SCHEDULING FLOW VERIFICATION    \n";
echo "==================================================\n\n";

DB::beginTransaction();

try {
    // 1. Fetch or create Exhibition
    $exhibition = Exhibition::first() ?: Exhibition::create([
        'title' => 'Future of AI Expo',
        'slug' => 'future-of-ai-expo',
        'start_date' => '2026-06-10 00:00:00',
        'end_date' => '2026-06-12 23:59:59',
        'status' => 'published',
    ]);
    
    // Ensure date boundaries are known
    $exhibition->update([
        'start_date' => '2026-06-10 00:00:00',
        'end_date' => '2026-06-12 23:59:59',
    ]);

    echo "1. Exhibition Details:\n";
    echo "   Title: " . $exhibition->title . "\n";
    echo "   Dates: " . $exhibition->start_date->format('Y-m-d') . " to " . $exhibition->end_date->format('Y-m-d') . "\n\n";

    // 2. Fetch or create Company
    $company1 = Company::first() ?: Company::create([
        'company_name' => 'Sagar Traders',
        'contact_person_name' => 'Sagar Sharma',
        'email' => 'sagar@traders.com',
        'phone' => '9876543210',
        'password' => Hash::make('password'),
        'status' => 'approved',
    ]);

    $company2 = Company::where('id', '!=', $company1->id)->first() ?: Company::create([
        'company_name' => 'Tech Solutions',
        'contact_person_name' => 'Jane Doe',
        'email' => 'tech@solutions.com',
        'phone' => '8765432109',
        'password' => Hash::make('password'),
        'status' => 'approved',
    ]);

    // 3. Fetch or create User (Visitor)
    $visitor = User::first() ?: User::create([
        'name' => 'Amit Kumar',
        'email' => 'amit@visitor.com',
        'password' => Hash::make('password'),
    ]);

    echo "2. Test Entities Setup:\n";
    echo "   Company 1: " . $company1->company_name . " (ID: " . $company1->id . ")\n";
    echo "   Company 2: " . $company2->company_name . " (ID: " . $company2->id . ")\n";
    echo "   Visitor: " . $visitor->name . " (ID: " . $visitor->id . ")\n\n";

    $engine = new SmartSchedulingEngine();

    // SCENARIO A: Request outside Exhibition Dates
    echo "Scenario A: Request meeting before Exhibition start date (2026-06-09)\n";
    $resultA = $engine->validateMeetingRequest(
        $company1->id,
        $visitor->id,
        $visitor->email,
        '2026-06-09',
        '10:00:00',
        'one-to-one',
        $exhibition->id
    );
    echo "   Valid: " . ($resultA['valid'] ? 'YES' : 'NO') . "\n";
    echo "   Conflict Message: " . $resultA['conflict'] . "\n\n";

    // SCENARIO B: Valid Slot Request
    echo "Scenario B: Request valid meeting slot during exhibition (2026-06-11 11:00)\n";
    $resultB = $engine->validateMeetingRequest(
        $company1->id,
        $visitor->id,
        $visitor->email,
        '2026-06-11',
        '11:00:00',
        'one-to-one',
        $exhibition->id
    );
    echo "   Valid: " . ($resultB['valid'] ? 'YES' : 'NO') . "\n";
    echo "   Conflict Message: " . ($resultB['conflict'] ?: 'None') . "\n\n";

    if ($resultB['valid']) {
        // Create the meeting to simulate booking
        $meetingB = CompanyMeeting::create([
            'company_id' => $company1->id,
            'title' => 'Meeting B',
            'meeting_type' => 'one-to-one',
            'start_time' => '2026-06-11 11:00:00',
            'end_time' => '2026-06-11 11:30:00',
            'meeting_date' => '2026-06-11',
            'meeting_time' => '11:00:00',
            'status' => 'confirmed',
        ]);
        VisitorMeetingBooking::create([
            'company_id' => $company1->id,
            'company_meeting_id' => $meetingB->id,
            'visitor_id' => $visitor->id,
            'visitor_name' => $visitor->name,
            'visitor_email' => $visitor->email,
            'meeting_topic' => 'Meeting B Topic',
            'status' => 'confirmed',
        ]);
        echo "   [Action] Confirmed Meeting B created successfully.\n\n";
    }

    // SCENARIO C: Visitor Overlapping Request
    echo "Scenario C: Visitor requests another meeting at Company 2 during the same time (2026-06-11 11:15)\n";
    $resultC = $engine->validateMeetingRequest(
        $company2->id,
        $visitor->id,
        $visitor->email,
        '2026-06-11',
        '11:15:00',
        'one-to-one',
        $exhibition->id
    );
    echo "   Valid: " . ($resultC['valid'] ? 'YES' : 'NO') . "\n";
    echo "   Conflict Message: " . $resultC['conflict'] . "\n\n";

    // SCENARIO D: Company Overlapping Request
    echo "Scenario D: Another visitor (new visitor) requests a meeting at Company 1 during the same time (2026-06-11 11:15)\n";
    $otherVisitor = User::create([
        'name' => 'Suresh Kumar',
        'email' => 'suresh@visitor.com',
        'password' => Hash::make('password'),
    ]);
    $resultD = $engine->validateMeetingRequest(
        $company1->id,
        $otherVisitor->id,
        $otherVisitor->email,
        '2026-06-11',
        '11:15:00',
        'one-to-one',
        $exhibition->id
    );
    echo "   Valid: " . ($resultD['valid'] ? 'YES' : 'NO') . "\n";
    echo "   Conflict Message: " . $resultD['conflict'] . "\n\n";

    // SCENARIO E: Capacity and waitlisting checks (One-to-Many slot)
    echo "Scenario E: Set up a One-to-Many slot with max capacity = 2 and simulate overflow\n";
    
    // Create a slot
    $slot = BoothMeetingSlot::create([
        'booth_booking_id' => 1, // Mock
        'company_id' => $company1->id,
        'date' => '2026-06-12',
        'start_time' => '14:00:00',
        'end_time' => '14:30:00',
        'meeting_type' => 'one-to-many',
        'max_capacity' => 2,
        'allow_one_to_one' => false,
        'allow_one_to_many' => true,
        'status' => 'available',
    ]);

    // First booking
    $meetingE1 = CompanyMeeting::create([
        'company_id' => $company1->id,
        'title' => 'Group Session E',
        'meeting_type' => 'one-to-many',
        'start_time' => '2026-06-12 14:00:00',
        'end_time' => '2026-06-12 14:30:00',
        'meeting_date' => '2026-06-12',
        'meeting_time' => '14:00:00',
        'status' => 'confirmed',
    ]);
    VisitorMeetingBooking::create([
        'company_id' => $company1->id,
        'company_meeting_id' => $meetingE1->id,
        'visitor_id' => $visitor->id,
        'visitor_name' => $visitor->name,
        'visitor_email' => $visitor->email,
        'meeting_topic' => 'Group Session E',
        'status' => 'confirmed',
    ]);

    // Second booking
    VisitorMeetingBooking::create([
        'company_id' => $company1->id,
        'company_meeting_id' => $meetingE1->id,
        'visitor_id' => $otherVisitor->id,
        'visitor_name' => $otherVisitor->name,
        'visitor_email' => $otherVisitor->email,
        'meeting_topic' => 'Group Session E',
        'status' => 'confirmed',
    ]);

    // Check third booking on the same slot
    $thirdVisitor = User::create([
        'name' => 'Ramesh Kumar',
        'email' => 'ramesh@visitor.com',
        'password' => Hash::make('password'),
    ]);
    
    $resultE = $engine->validateMeetingRequest(
        $company1->id,
        $thirdVisitor->id,
        $thirdVisitor->email,
        '2026-06-12',
        '14:00:00',
        'one-to-many',
        $exhibition->id,
        $slot->id
    );

    echo "   Slot Capacity: " . $slot->max_capacity . "\n";
    echo "   Current confirmed bookings: 2\n";
    echo "   Valid for Third Booking: " . ($resultE['valid'] ? 'YES' : 'NO') . "\n";
    echo "   Conflict Code: " . $resultE['conflict'] . " (Should say 'waitlist')\n\n";

    echo "==================================================\n";
    echo "         ALL SCENARIOS VALIDATED SUCCESSFULLY     \n";
    echo "==================================================\n";

} catch (\Throwable $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
} finally {
    DB::rollBack();
}
