<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$visitors = DB::table('visitors')->where('email', 'user@example.com')->get();
foreach ($visitors as $v) {
    $exh = DB::table('exhibitions')->find($v->exhibition_id);
    echo "Visitor ID: {$v->id} | Booking ID: {$v->booking_id} | Email: {$v->email} | Exhibition: {$exh->title} (Slug: {$exh->slug}) | Pay Status: {$v->payment_status}\n";
}
