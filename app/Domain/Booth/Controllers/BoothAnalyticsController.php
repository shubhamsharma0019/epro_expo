<?php

namespace App\Domain\Booth\Controllers;

use App\Domain\Booth\Models\BoothBooking;
use App\Domain\Booth\Services\BoothAnalyticsService;
use App\Domain\Booth\Services\BoothSetupStepService;
use Illuminate\View\View;

class BoothAnalyticsController extends BaseBoothSetupController
{
    public function index(BoothBooking $booking, BoothAnalyticsService $analyticsService, BoothSetupStepService $steps): View
    {
        $booking = $this->setupBooking($booking);

        return view('company.booth-setup.analytics', $this->commonData($booking, $steps) + [
            'analytics' => $analyticsService->snapshot($booking),
            'topProducts' => $booking->boothProducts()->orderByDesc('views')->take(5)->get(),
            'recentActivities' => [],
        ]);
    }
}
