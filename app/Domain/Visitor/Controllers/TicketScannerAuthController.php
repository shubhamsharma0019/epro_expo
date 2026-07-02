<?php

namespace App\Domain\Visitor\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TicketScannerAuthController extends Controller
{
    public function showLogin(Request $request): View
    {
        return view('frontend.events.tickets.scanner-login', [
            'redirect' => $request->query('redirect'),
            'scannerUsername' => session('ticket_scanner_username'),
            'scannerLoginUrl' => rtrim(\App\Support\EventTicketQr::appBaseUrl(), '/') . route('ticket-scanner.login.submit', [], false),
        ]);
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'username' => ['required', 'string', 'max:100'],
            'password' => ['required', 'string', 'max:100'],
            'scan_location' => ['nullable', 'string', 'max:120'],
            'redirect' => ['nullable', 'string', 'max:2000'],
        ]);

        $expectedUser = (string) config('ticket_scanner.username');
        $expectedPass = (string) config('ticket_scanner.password');

        if (
            $credentials['username'] !== $expectedUser
            || $credentials['password'] !== $expectedPass
        ) {
            return back()
                ->withInput($request->only('username', 'redirect'))
                ->withErrors(['username' => 'Invalid scanner credentials.']);
        }

        session([
            'ticket_scanner_username' => $credentials['username'],
            'ticket_scanner_logged_in_at' => now()->toIso8601String(),
            'ticket_scanner_location' => filled($credentials['scan_location'] ?? null)
                ? trim((string) $credentials['scan_location'])
                : null,
        ]);

        $redirect = $this->resolveSafeRedirect($credentials['redirect'] ?? null);

        if ($redirect) {
            return redirect()->to($redirect)->with('success', 'Scanner signed in.');
        }

        return redirect()
            ->route('ticket-scanner.login')
            ->with('success', 'Scanner signed in. Scan a ticket QR code to verify entry.');
    }

    public function logout(Request $request): RedirectResponse
    {
        session()->forget([
            'ticket_scanner_username',
            'ticket_scanner_logged_in_at',
            'ticket_scanner_location',
        ]);

        return redirect()
            ->route('ticket-scanner.login')
            ->with('status', 'Scanner signed out.');
    }

    private function resolveSafeRedirect(?string $redirect): ?string
    {
        if (! filled($redirect)) {
            return null;
        }

        $path = parse_url($redirect, PHP_URL_PATH);
        $query = parse_url($redirect, PHP_URL_QUERY);

        if (! is_string($path) || ! str_starts_with($path, '/')) {
            return null;
        }

        $allowedPrefixes = ['/verify-ticket/', '/ticket-scanner/'];

        foreach ($allowedPrefixes as $prefix) {
            if (str_starts_with($path, $prefix)) {
                return $path . ($query ? '?' . $query : '');
            }
        }

        return null;
    }
}
