<?php

use App\Models\Admin;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$kernel = $app->make(Kernel::class);

$admin = Admin::query()->first();
if (! $admin) {
    fwrite(STDERR, "No admin user found. Run php artisan db:seed first.\n");
    exit(1);
}

$paths = [
    '/admin/dashboard',
    '/admin/companies',
    '/admin/companies/1/manage',
    '/admin/company-approval',
    '/admin/companies/create',
    '/admin/kyc-verification',
    '/admin/exhibitions',
    '/admin/exhibitions/create',
    '/admin/exhibition-lifecycle',
    '/admin/pavilions',
    '/admin/halls',
    '/admin/booths',
    '/admin/booth-bookings',
    '/admin/booth-approvals',
    '/admin/booth-engineering-review',
    '/admin/events',
    '/admin/event-approvals',
    '/admin/event-logistics-review',
    '/admin/visitor-checkins',
    '/admin/leads',
    '/admin/meetings',
    '/admin/event-tickets',
    '/admin/payments',
    '/admin/refunds',
    '/admin/reports',
    '/admin/revenue-breakdown',
    '/admin/occupancy-analytics',
    '/admin/enquiries',
    '/admin/notifications',
    '/admin/cms',
    '/admin/support',
    '/admin/users',
    '/admin/roles',
    '/admin/settings',
    '/admin/system-settings',
    '/admin/activity-logs',
    '/admin/flow-diagrams',
    '/admin/02_admin_dashboard',
    '/admin/05_kyc_verification',
    '/admin/09_exhibition_lifecycle',
    '/admin/19_booth_engineering_review',
    '/admin/23_event_logistics_review',
];

$failures = [];

foreach ($paths as $path) {
    $request = Request::create($path, 'GET');
    $request->setLaravelSession($app['session']->driver());
    $request->session()->put('admin_id', $admin->id);

    $response = $kernel->handle($request);
    $status = $response->getStatusCode();

    if ($status >= 400) {
        $failures[] = [$path, $status];
    }

    $kernel->terminate($request, $response);
}

if ($failures === []) {
    echo 'OK: ' . count($paths) . " admin routes responded without HTTP errors.\n";
    exit(0);
}

foreach ($failures as [$path, $status]) {
    echo "FAIL {$status} {$path}\n";
}

exit(1);
