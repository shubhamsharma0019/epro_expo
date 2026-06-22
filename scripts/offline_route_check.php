<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

foreach (['/', '/exhibitions', '/events', '/events/listings'] as $path) {
    $request = Illuminate\Http\Request::create($path, 'GET');
    $started = microtime(true);
    $response = $kernel->handle($request);
    $elapsed = round(microtime(true) - $started, 2);
    echo $path . ': ' . $response->getStatusCode() . ' in ' . $elapsed . 's' . PHP_EOL;
    $kernel->terminate($request, $response);
}
