<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    $company = \App\Models\Company::first();
    if (!$company) {
        echo "No company found\n";
        exit;
    }
    
    $currentCompany = \App\Models\Company::query()
        ->withCount([
            'boothBookings',
            'products',
            'companyDocuments',
            'catalogues',
            'mediaGalleries',
            'businessCards',
            'companyMeetings',
            'enquiries',
            'visitorMeetingBookings',
            'boothViews',
        ])
        ->find($company->id);

    echo "Initial query passed\n";

    $latestBooking = $currentCompany->boothBookings()
        ->with(['exhibition', 'pavilion', 'hall', 'booth', 'boothSize', 'boothProfile'])
        ->withCount([
            'boothProducts',
            'boothDocuments',
            'boothCatalogues',
            'boothMedia',
            'boothTeamMembers',
            'boothMeetingSlots',
        ])
        ->where('payment_status', 'paid')
        ->whereIn('booking_status', ['confirmed', 'active'])
        ->where('admin_status', 'approved')
        ->latest()
        ->first();

    echo "Latest booking query passed\n";

    echo "Success!\n";
} catch (\Throwable $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "IN: " . $e->getFile() . " on line " . $e->getLine() . "\n";
}
