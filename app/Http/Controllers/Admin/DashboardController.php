<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BoothBooking;
use App\Models\BoothPublishRequest;
use App\Models\CompanyEvent\CompanyEventPublishRequest;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $pendingBookingsCount = BoothBooking::where('payment_status', 'paid')
                                ->where('admin_status', 'pending')
                                ->count();
                                
        $pendingApprovalsCount = BoothPublishRequest::where('status', 'pending')
                                ->count();

        $pendingEventApprovalsCount = CompanyEventPublishRequest::where('status', 'pending')
                                ->count();

        return view('admin.dashboard', compact('pendingBookingsCount', 'pendingApprovalsCount', 'pendingEventApprovalsCount'));
    }
}
