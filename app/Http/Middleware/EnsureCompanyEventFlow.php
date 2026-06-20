<?php

namespace App\Http\Middleware;

use App\Domain\Booth\Models\BoothBooking;
use App\Domain\Company\Models\Company;
use App\Domain\Event\Models\CompanyEvent\CompanyEvent;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureCompanyEventFlow
{
    public function handle(Request $request, Closure $next): Response
    {
        $companyId = (int) $request->session()->get('company_id');
        $company = Company::find($companyId);
        $hasBoothBookings = BoothBooking::where('company_id', $companyId)->exists();
        $hasCompanyEvents = CompanyEvent::where('company_id', $companyId)->exists();
        $isEventFlow = $request->session()->get('company_flow_context') === 'event_company';
        $isEventCompany = ($company?->account_type ?? 'exhibitor') === 'event';

        if (! $isEventFlow || ! $isEventCompany || ($hasBoothBookings && ! $hasCompanyEvents)) {
            $request->session()->forget(['company_flow_context', 'company_event_flow_event_id']);

            return redirect()->route('company.dashboard')
                ->with('status', 'Create Event flow is separate. Please use Create Event to access the event suite.');
        }

        return $next($request);
    }
}
