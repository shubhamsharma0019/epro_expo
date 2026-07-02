<?php

namespace App\Http\Middleware;

use App\Support\EventTicketQr;
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

            $targetUrl = $this->normalizeRedirectUrl($request->fullUrl());

            return redirect()
                ->to(
                    rtrim(EventTicketQr::appBaseUrl(), '/')
                    . route('ticket-scanner.login', ['redirect' => $targetUrl], false)
                )
                ->with('warning', 'Please sign in with scanner credentials to verify tickets.');
        }

        return $next($request);
    }

    private function normalizeRedirectUrl(string $url): string
    {
        $path = parse_url($url, PHP_URL_PATH) ?: '/';
        $query = parse_url($url, PHP_URL_QUERY);
        $relative = $path . ($query ? '?' . $query : '');

        return rtrim(EventTicketQr::appBaseUrl(), '/') . $relative;
    }
}
