<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CompanyMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! session()->has('company_id')) {
            if ($request->isMethod('GET')) {
                session()->put('url.intended', $request->fullUrl());
            }

            if ($request->is('company/event-company-flow*') || $request->is('company/event-flow*')) {
                return redirect()->route('company.event-company.login');
            }

            return redirect('/company/login');
        }

        return $next($request);
    }
}
