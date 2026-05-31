<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$bookings = App\Models\BoothBooking::with(['company', 'exhibition'])->where('payment_status', 'paid')->get();
foreach ($bookings as $b) {
    echo "Booking ID: " . $b->id . " | Company: " . ($b->company?->company_name ?: $b->company?->name) . " | Exhibition: " . ($b->exhibition?->title ?: $b->exhibition?->name) . "\n";
}
