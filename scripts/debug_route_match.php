<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$path = $argv[1] ?? '/exhibitions/future-of-ai-expo/my-meetings';
$req = \Illuminate\Http\Request::create($path, 'GET');

try {
    $route = \Illuminate\Support\Facades\Route::getRoutes()->match($req);
    echo 'matched: ' . $route->getName() . PHP_EOL;
    echo 'action: ' . (is_string($route->getAction('uses')) ? $route->getAction('uses') : json_encode($route->getAction())) . PHP_EOL;
} catch (\Throwable $e) {
    echo 'match error: ' . $e->getMessage() . PHP_EOL;
}

$config = $app->make('config');
$config->set('app.debug', true);

$kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);
$req->setLaravelSession($app['session']->driver());

try {
    $res = $kernel->handle($req);
    echo 'status=' . $res->getStatusCode() . PHP_EOL;
    if ($res->getStatusCode() >= 400) {
        file_put_contents(__DIR__ . '/../storage/logs/smoke-debug.html', $res->getContent());
        echo "wrote storage/logs/smoke-debug.html\n";
    }
} catch (\Throwable $e) {
    echo 'EX: ' . $e->getMessage() . PHP_EOL;
    echo $e->getTraceAsString() . PHP_EOL;
}
