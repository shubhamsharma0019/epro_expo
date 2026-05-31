<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

foreach (\App\Models\Company::all() as $c) {
    echo $c->id . ": " . $c->email . " (Bookings: " . $c->boothBookings()->count() . ")\n";
}
