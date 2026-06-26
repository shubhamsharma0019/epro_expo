<?php

namespace App\Domain\Booth\Controllers;

use App\Domain\Booth\Models\BoothBooking;
use App\Domain\Booth\Services\BoothSetupStepService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BoothSetupController extends BaseBoothSetupController
{
    public function index(?BoothBooking $booking = null, BoothSetupStepService $steps): View|RedirectResponse
    {
        $booking = $booking?->exists ? $this->setupBooking($booking) : $this->latestOwnedPaidBooking();
        if ($booking instanceof RedirectResponse) {
            return $booking;
        }

        return view('company.booth-setup.setup-overview', $this->commonData($booking, $steps));
    }
}
