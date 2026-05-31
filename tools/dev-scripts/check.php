<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$routes = Illuminate\Support\Facades\Route::getRoutes();
$count = 0;
$failed = [];
$success = [];

$skipPrefixes = ['api/', '_ignition', 'sanctum'];

$httpKernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

foreach ($routes as $route) {
    if (in_array('GET', $route->methods()) && !str_contains($route->uri(), '{')) {
        
        $skip = false;
        foreach ($skipPrefixes as $prefix) {
            if (str_starts_with($route->uri(), $prefix)) {
                $skip = true;
                break;
            }
        }
        if ($skip) continue;

        $count++;
        try {
            $request = Illuminate\Http\Request::create($route->uri(), 'GET');
            $response = $httpKernel->handle($request);
            if ($response->status() >= 500) {
                $failed[] = "Status " . $response->status() . " on " . $route->uri();
            } else {
                $success[] = $route->uri();
            }
        } catch (\Exception $e) {
            $failed[] = $route->uri() . " (Exception: " . $e->getMessage() . ")";
        } catch (\Error $e) {
            $failed[] = $route->uri() . " (Error: " . $e->getMessage() . ")";
        }
    }
}

echo "Total static GET routes checked: " . $count . "\n";
echo "Failed:\n";
foreach($failed as $f) {
    echo "- $f\n";
}
if (empty($failed)) {
    echo "ALL PAGES RENDERED SUCCESSFULLY (200/302/403/404)!\n";
}
