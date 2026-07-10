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
        if (! $company) {
            $request->session()->forget(['company_flow_context', 'company_event_flow_event_id']);

            return redirect()->route('company.login');
        }

        $request->session()->put('company_flow_context', 'event_company');

        return $next($request);
    }
}
