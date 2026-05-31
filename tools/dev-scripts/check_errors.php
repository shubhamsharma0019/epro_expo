<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$httpKernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$routes = ['exhibitions/pavilions/show'];

foreach ($routes as $uri) {
    echo "Testing $uri...\n";
    try {
        $request = Illuminate\Http\Request::create($uri, 'GET');
        $response = $httpKernel->handle($request);
        if ($response->status() >= 500) {
            echo "FAILED with status " . $response->status() . "\n";
            if ($response->exception) {
                echo "Exception: " . $response->exception->getMessage() . " in " . $response->exception->getFile() . ":" . $response->exception->getLine() . "\n";
            }
        }
    } catch (\Exception $e) {
        echo "Exception caught: " . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine() . "\n";
    }
}
