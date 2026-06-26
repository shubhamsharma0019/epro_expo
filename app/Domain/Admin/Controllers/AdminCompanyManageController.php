<?php

namespace App\Domain\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Domain\Booth\Models\BoothBooking;
use App\Domain\Company\Models\Company;
use App\Domain\Event\Models\CompanyEvent\CompanyEvent;
use App\Support\AdminAudit;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminCompanyManageController extends Controller
{
    public function show(Company $company): View
    {
        $bookings = BoothBooking::query()
            ->with(['exhibition', 'hall', 'booth'])
            ->where('company_id', $company->id)
            ->latest()
            ->take(10)
            ->get();

        $events = CompanyEvent::query()
            ->where('company_id', $company->id)
            ->latest()
            ->take(10)
            ->get();

        return view('admin.companies.manage', [
            'company' => $company,
            'bookings' => $bookings,
            'events' => $events,
            'isImpersonating' => (int) session('company_id') === (int) $company->id
                && session()->has('admin_impersonator_id'),
        ]);
    }

    public function impersonate(Company $company): RedirectResponse
    {
        session([
            'admin_impersonator_id' => session('admin_id'),
            'company_id' => $company->id,
            'company_name' => $company->company_name,
        ]);

        AdminAudit::log('admin_company_impersonation', 'companies', 'company', $company->id, [
            'company_name' => $company->company_name,
        ]);

        return redirect('/company/dashboard')
            ->with('status', 'You are now managing ' . $company->company_name . ' as admin.');
    }

    public function stopImpersonation(): RedirectResponse
    {
        $companyId = session('company_id');
        session()->forget(['company_id', 'company_name', 'company_booth_booking']);

        AdminAudit::log('admin_company_impersonation_stopped', 'companies', 'company', $companyId);

        return redirect()->route('admin.companies.index')
            ->with('status', 'Returned to admin workspace.');
    }
}
