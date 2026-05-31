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
    
    // Simulate session
    session()->put('company_id', $company->id);

    // Call the controller action directly
    $controller = app(\App\Http\Controllers\Company\CompanyDashboardController::class);
    $response = $controller->index();
    
    if ($response instanceof \Illuminate\View\View) {
        $html = $response->render();
        echo "Rendered View Length: " . strlen($html) . "\n";
    } else {
        echo "Returned a redirect: " . $response->getTargetUrl() . "\n";
    }
} catch (\Throwable $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "IN: " . $e->getFile() . " on line " . $e->getLine() . "\n";
}
