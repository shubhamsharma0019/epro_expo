<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTicketScanner
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! session()->has('ticket_scanner_username')) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Scanner login required.'], 401);
            }

            return redirect()
                ->route('ticket-scanner.login', ['redirect' => $request->fullUrl()])
                ->with('warning', 'Please sign in with scanner credentials to verify tickets.');
        }

        return $next($request);
    }
}
