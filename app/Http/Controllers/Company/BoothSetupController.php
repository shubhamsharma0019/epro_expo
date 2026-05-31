<?php

namespace App\Http\Controllers\Company;

use App\Models\BoothBooking;
use App\Services\Company\BoothSetupStepService;
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

        return view('company.booth-setup.index', $this->commonData($booking, $steps));
    }
}
