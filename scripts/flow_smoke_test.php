<?php

/**
 * Mock HTTP smoke test: admin, company (exhibition + event), visitor (exhibition + event).
 * Run: php scripts/flow_smoke_test.php
 */

use App\Models\Admin;
use App\Models\Company;
use App\Models\BoothBooking;
use App\Support\LiveContent;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$kernel = $app->make(Kernel::class);

$admin = Admin::query()->first();
$company = Company::query()->first();
$liveExhibition = LiveContent::exhibitionQuery()->orderBy('start_date')->first();
$liveEvent = LiveContent::companyEventQuery()->orderBy('starts_at')->first();
$exhSlug = $liveExhibition?->slug ?? 'global-tech-expo-2024';
$evtSlug = $liveEvent?->slug ?? 'sample-event';

if (! $admin) {
    fwrite(STDERR, "SKIP: No admin — run php artisan db:seed\n");
    exit(1);
}
if (! $company) {
    fwrite(STDERR, "SKIP: No company — run php artisan db:seed\n");
    exit(1);
}

$suites = [
    'admin' => [
        'session' => ['admin_id' => $admin->id],
        'paths' => [
            '/admin/dashboard',
            '/admin/exhibitions',
            '/admin/exhibitions/create',
            '/admin/pavilions',
            '/admin/halls',
            '/admin/booths',
            '/admin/booth-bookings',
            '/admin/booth-approvals',
            '/admin/events',
            '/admin/event-approvals',
            '/admin/companies',
            '/admin/meetings',
            '/admin/enquiries',
            '/admin/payments',
            '/admin/reports',
        ],
    ],
    'company_exhibition' => [
        'session' => ['company_id' => $company->id, 'company_logged_in' => true],
        'paths' => [
            '/company/dashboard',
            '/company/exhibitions',
            '/company/exhibitions/' . $exhSlug,
            '/company/booth-booking/pavilions?exhibition=' . $exhSlug,
            '/company/booth-booking/halls?exhibition=' . $exhSlug,
            '/company/booth-booking/floor-plan?exhibition=' . $exhSlug,
        ],
    ],
    'company_event' => [
        'session' => ['company_id' => $company->id, 'company_logged_in' => true],
        'paths' => [
            '/company/event-company-flow/dashboard',
            '/company/event-company-flow/create',
        ],
    ],
    'visitor_exhibition' => [
        'session' => [],
        'paths' => array_values(array_filter([
            '/exhibitions',
            '/exhibitions/browse',
            '/exhibitions/home',
            '/exhibitions/' . $exhSlug,
            '/exhibitions/' . $exhSlug . '/visit',
            '/exhibitions/' . $exhSlug . '/companies',
            '/exhibitions/' . $exhSlug . '/sessions',
            '/exhibitions/' . $exhSlug . '/my-meetings',
            \Database\Seeders\MockFlowDemoSeeder::EXHIBITION_SLUG !== $exhSlug
                ? '/exhibitions/' . \Database\Seeders\MockFlowDemoSeeder::EXHIBITION_SLUG
                : null,
            \Database\Seeders\MockFlowDemoSeeder::EXHIBITION_SLUG !== $exhSlug
                ? '/exhibitions/' . \Database\Seeders\MockFlowDemoSeeder::EXHIBITION_SLUG . '/companies'
                : null,
        ])),
    ],
    'visitor_event' => [
        'session' => [],
        'paths' => array_values(array_filter([
            '/events',
            '/events/listings',
            '/events/listings/' . $evtSlug,
            '/events/tickets/select?event=' . $evtSlug,
            \Database\Seeders\MockFlowDemoSeeder::EVENT_SLUG !== $evtSlug
                ? '/events/listings/' . \Database\Seeders\MockFlowDemoSeeder::EVENT_SLUG
                : null,
            \Database\Seeders\MockFlowDemoSeeder::EVENT_SLUG !== $evtSlug
                ? '/events/tickets/select?event=' . \Database\Seeders\MockFlowDemoSeeder::EVENT_SLUG
                : null,
        ])),
    ],
];

$results = [];
$total = 0;
$passed = 0;
$failed = 0;
$skipped = 0;

foreach ($suites as $suiteName => $suite) {
    $results[$suiteName] = ['ok' => [], 'fail' => [], 'skip' => []];

    foreach ($suite['paths'] as $path) {
        $total++;
        $request = Request::create($path, 'GET');
        $request->setLaravelSession($app['session']->driver());

        foreach ($suite['session'] as $key => $value) {
            $request->session()->put($key, $value);
        }

        try {
            $response = $kernel->handle($request);
            $status = $response->getStatusCode();
            $kernel->terminate($request, $response);

            if ($status >= 200 && $status < 400) {
                $passed++;
                $results[$suiteName]['ok'][] = [$path, $status];
            } elseif ($status >= 300 && $status < 400) {
                $passed++;
                $results[$suiteName]['ok'][] = [$path, $status, 'redirect'];
            } else {
                $failed++;
                $results[$suiteName]['fail'][] = [$path, $status];
            }
        } catch (\Throwable $e) {
            $failed++;
            $results[$suiteName]['fail'][] = [$path, 500, $e->getMessage()];
        }
    }
}

// Data sync assertions (no HTTP)
$dataChecks = [
    'live_exhibitions' => LiveContent::exhibitionQuery()->count(),
    'live_events' => LiveContent::companyEventQuery()->count(),
    'public_booths' => LiveContent::boothBookingQuery()->count(),
];

echo "\n=== Flow Smoke Test Report ===\n";
echo 'Exhibition slug: ' . $exhSlug . "\n";
echo 'Event slug: ' . $evtSlug . "\n";
echo 'Company: ' . ($company->company_name ?? $company->name ?? $company->id) . "\n\n";

foreach ($results as $suite => $suiteResults) {
    $ok = count($suiteResults['ok']);
    $fail = count($suiteResults['fail']);
    $icon = $fail === 0 ? 'PASS' : 'FAIL';
    echo "[{$icon}] {$suite}: {$ok} ok, {$fail} failed\n";

    foreach ($suiteResults['fail'] as $failRow) {
        $path = $failRow[0];
        $status = $failRow[1];
        $msg = $failRow[2] ?? null;
        echo "  ✗ {$status} {$path}" . ($msg ? " — {$msg}" : '') . "\n";
    }
}

echo "\n--- Data sync checks ---\n";
foreach ($dataChecks as $label => $count) {
    echo "  {$label}: {$count}\n";
}

echo "\n--- Summary ---\n";
echo "HTTP: {$passed}/{$total} passed, {$failed} failed\n";

if ($failed > 0) {
    exit(1);
}

echo "All flow smoke tests passed.\n";
exit(0);
