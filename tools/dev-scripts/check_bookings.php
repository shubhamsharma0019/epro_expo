<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

foreach (\App\Models\BoothBooking::all() as $b) {
    echo "ID: {$b->id}, Pay: {$b->payment_status}, Admin: {$b->admin_status}, Setup: {$b->booth_setup_status}\n";
}
