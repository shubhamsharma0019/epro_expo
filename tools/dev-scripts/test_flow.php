<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Try rendering a few pages
$pages = [
    '/company/dashboard',
    '/company/booth-booking/pavilions',
    '/company/booth-booking/halls?pavilion=1',
    '/company/booth-booking/floor-plan?hall=1',
    '/company/booth-booking/sizes',
];

$company = App\Models\Company::first();

foreach ($pages as $uri) {
    $request = Illuminate\Http\Request::create($uri, 'GET');
    $request->setLaravelSession($app['session']->driver());
    session()->put('company_id', $company->id);
    session()->put('company_logged_in', true);
    if ($uri == '/company/booth-booking/sizes') {
        session()->put('current_booking_id', App\Models\BoothBooking::first()->id ?? 1);
    }
    
    $response = $kernel->handle($request);
    echo "$uri -> Status: " . $response->getStatusCode() . "\n";
}
