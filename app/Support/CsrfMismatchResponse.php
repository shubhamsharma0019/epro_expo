<?php

namespace App\Support;

use Illuminate\Http\Request;
use Illuminate\Session\TokenMismatchException;
use Symfony\Component\HttpFoundation\Response;

class CsrfMismatchResponse
{
    public static function forRequest(Request $request, TokenMismatchException $exception): Response
    {
        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Your session expired. Refresh the page and try again.',
            ], 419);
        }

        $message = 'Your session expired. Please refresh the page and try again.';

        if ($request->isMethod('GET')) {
            return redirect()->route('home')->withErrors(['csrf' => $message]);
        }

        $eventSlug = $request->input('event')
            ?: $request->input('slug')
            ?: $request->query('event')
            ?: $request->route('slug');

        if ($request->routeIs('events.tickets.visitor-details.store') && filled($eventSlug)) {
            return redirect()
                ->route('events.tickets.visitor-details', ['event' => $eventSlug])
                ->withInput($request->except('password', '_token'))
                ->withErrors(['csrf' => $message]);
        }

        if ($request->routeIs('exhibitions.tickets.visitor-details.store') && filled($eventSlug)) {
            return redirect()
                ->route('exhibitions.tickets.visitor-details', $eventSlug)
                ->withInput($request->except('password', '_token'))
                ->withErrors(['csrf' => $message]);
        }

        return back()
            ->withInput($request->except('password', '_token'))
            ->withErrors(['csrf' => $message]);
    }
}
