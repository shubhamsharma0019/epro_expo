<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$exhibitions = \App\Domain\Event\Models\Exhibition::query()
    ->with([
        'boothBookings' => fn ($query) => $query
            ->with(['boothProfile', 'boothProducts', 'boothCatalogues'])
            ->where('payment_status', 'paid')
            ->whereIn('booking_status', ['confirmed', 'active'])
            ->where('admin_status', 'approved')
            ->whereIn('booth_setup_status', ['published', 'approved', 'live']),
    ])
    ->where('status', 'active')
    ->orderBy('start_date')
    ->get();

$companyEvents = \App\Domain\Event\Models\CompanyEvent\CompanyEvent::with('branding')
    ->whereIn('status', ['published', 'pending_review', 'submitted', 'draft'])
    ->get()
    ->map(function ($event) {
        $event->start_date = $event->starts_at;
        $event->end_date = $event->ends_at;
        $event->location = $event->venue_name ?: $event->city ?: 'Online';
        $event->banner_image = $event->branding?->banner_path ? 'storage/' . $event->branding->banner_path : 'images/exhibitions/hero-pavilion-scene.png';
        $event->status = 'active';
        return $event;
    });

$dynamicExhibitions = $exhibitions->concat($companyEvents);

$html = view('frontend.exhibitions.index', compact('dynamicExhibitions'))->render();

echo "Contains 'International Manufacturing & Trade Expo 2026': " . (strpos($html, 'International Manufacturing & Trade Expo 2026') !== false ? 'YES' : 'NO') . "\n";
echo "Contains 'Global Tech Expo 2024': " . (strpos($html, 'Global Tech Expo 2024') !== false ? 'YES' : 'NO') . "\n";
echo "Contains 'Hands-on UI/UX Design Boot Camp': " . (strpos($html, 'Hands-on UI/UX Design Boot Camp') !== false ? 'YES' : 'NO') . "\n";
