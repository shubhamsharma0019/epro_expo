<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo 'driver: ' . Illuminate\Support\Facades\DB::connection()->getDriverName() . PHP_EOL;
echo 'database: ' . Illuminate\Support\Facades\DB::connection()->getDatabaseName() . PHP_EOL;
echo 'admins: ' . App\Models\Admin::count() . PHP_EOL;
echo 'companies: ' . App\Models\Company::count() . PHP_EOL;
echo 'exhibitions: ' . App\Models\Exhibition::count() . PHP_EOL;
echo 'booth_bookings: ' . App\Models\BoothBooking::count() . PHP_EOL;
