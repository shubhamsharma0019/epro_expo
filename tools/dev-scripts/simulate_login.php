<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$company = \App\Models\Company::first();

// Create a mock request for login
$request = Illuminate\Http\Request::create('/company/login', 'POST', [
    'email' => $company->email,
    'password' => 'password',
]);

$response = $kernel->handle($request);

echo "Status: " . $response->getStatusCode() . "\n";
echo "Redirect: " . $response->headers->get('Location') . "\n";

$cookies = $response->headers->getCookies();
$sessionId = null;
foreach ($cookies as $cookie) {
    if ($cookie->getName() === 'eproexpo_session') {
        $sessionId = $cookie->getValue();
    }
}

echo "Session ID: " . $sessionId . "\n";

// Now simulate the dashboard request with that session ID
$dashboardRequest = Illuminate\Http\Request::create('/company/dashboard', 'GET');
if ($sessionId) {
    $dashboardRequest->cookies->set('eproexpo_session', $sessionId);
}

$dashboardResponse = $kernel->handle($dashboardRequest);
echo "Dashboard Status: " . $dashboardResponse->getStatusCode() . "\n";
echo "Dashboard Redirect: " . $dashboardResponse->headers->get('Location') . "\n";

