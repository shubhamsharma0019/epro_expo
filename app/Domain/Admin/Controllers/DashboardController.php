<?php

namespace App\Domain\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Domain\Admin\Services\DashboardMetrics;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(DashboardMetrics $dashboardMetrics): View
    {
        return view('admin.dashboard.index', $dashboardMetrics->forDashboard(request('search')));
    }
}
