<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle(Illuminate\Http\Request::capture()); // Boot up the full app including database

$company = \App\Models\Company::first();

// Create a mock request for login
$request = Illuminate\Http\Request::create('/company/login', 'POST', [
    'email' => $company->email,
    'password' => 'password',
]);
$request->setSession($app->make('session.store'));
$request->session()->start();
$request->session()->put('_token', 'fake-token');
$request->merge(['_token' => 'fake-token']);

$response = $kernel->handle($request);

echo "Status: " . $response->getStatusCode() . "\n";
echo "Redirect: " . $response->headers->get('Location') . "\n";
