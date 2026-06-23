<?php

namespace App\Domain\Shared\Controllers;

use App\Domain\Shared\Support\EnvFileUpdater;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class GoogleMeetSetupController extends Controller
{
    protected const SCOPE = 'https://www.googleapis.com/auth/calendar';

    protected function oauthRedirectUri(): string
    {
        if ($override = env('GOOGLE_OAUTH_REDIRECT_URI')) {
            return $override;
        }

        $port = parse_url(config('app.url'), PHP_URL_PORT) ?: 8000;

        return 'http://127.0.0.1:' . $port . '/setup/google-meet/callback';
    }

    public function index(): View
    {
        abort_unless(app()->environment('local'), 404);

        return view('setup.google-meet', [
            'clientId' => env('GOOGLE_CLIENT_ID'),
            'clientSecret' => filled(env('GOOGLE_CLIENT_SECRET')),
            'refreshToken' => filled(env('GOOGLE_REFRESH_TOKEN')),
            'redirectUri' => $this->oauthRedirectUri(),
            'setupUrl' => 'http://127.0.0.1:' . (parse_url(config('app.url'), PHP_URL_PORT) ?: 8000) . '/setup/google-meet',
        ]);
    }

    public function saveCredentials(Request $request): RedirectResponse
    {
        abort_unless(app()->environment('local'), 404);

        $validated = $request->validate([
            'google_client_id' => ['required', 'string', 'max:500'],
            'google_client_secret' => ['required', 'string', 'max:500'],
        ]);

        EnvFileUpdater::set([
            'GOOGLE_CLIENT_ID' => $validated['google_client_id'],
            'GOOGLE_CLIENT_SECRET' => $validated['google_client_secret'],
            'GOOGLE_CALENDAR_ID' => env('GOOGLE_CALENDAR_ID', 'primary'),
            'GOOGLE_CALENDAR_TIMEZONE' => env('GOOGLE_CALENDAR_TIMEZONE', 'Asia/Kolkata'),
            'GOOGLE_MEET_DEFAULT_DURATION' => env('GOOGLE_MEET_DEFAULT_DURATION', '30'),
        ]);

        Artisan::call('config:clear');

        return redirect()
            ->route('setup.google-meet.index')
            ->with('status', 'Client ID and Secret saved to .env. Now click "Connect with Google".');
    }

    public function connect(): RedirectResponse
    {
        abort_unless(app()->environment('local'), 404);

        $clientId = env('GOOGLE_CLIENT_ID');
        if (! filled($clientId) || ! filled(env('GOOGLE_CLIENT_SECRET'))) {
            return redirect()
                ->route('setup.google-meet.index')
                ->with('error', 'Save Client ID and Client Secret first.');
        }

        $query = http_build_query([
            'client_id' => $clientId,
            'redirect_uri' => $this->oauthRedirectUri(),
            'response_type' => 'code',
            'scope' => self::SCOPE,
            'access_type' => 'offline',
            'prompt' => 'consent',
        ]);

        return redirect('https://accounts.google.com/o/oauth2/v2/auth?' . $query);
    }

    public function callback(Request $request): View|RedirectResponse
    {
        abort_unless(app()->environment('local'), 404);

        if ($request->filled('error')) {
            return redirect()
                ->route('setup.google-meet.index')
                ->with('error', 'Google denied access: ' . $request->input('error'));
        }

        $code = $request->input('code');
        if (! filled($code)) {
            return redirect()
                ->route('setup.google-meet.index')
                ->with('error', 'Authorization code was not returned by Google.');
        }

        $response = Http::asForm()->post('https://oauth2.googleapis.com/token', [
            'code' => $code,
            'client_id' => env('GOOGLE_CLIENT_ID'),
            'client_secret' => env('GOOGLE_CLIENT_SECRET'),
            'redirect_uri' => $this->oauthRedirectUri(),
            'grant_type' => 'authorization_code',
        ]);

        if (! $response->successful()) {
            return redirect()
                ->route('setup.google-meet.index')
                ->with('error', 'Token exchange failed. Is the redirect URI added in Google Console? Error: ' . ($response->json('error_description') ?: $response->body()));
        }

        $refreshToken = $response->json('refresh_token');
        if (! filled($refreshToken)) {
            return redirect()
                ->route('setup.google-meet.index')
                ->with('error', 'Refresh token not received. Revoke app access from your Google account and try again.');
        }

        EnvFileUpdater::set([
            'GOOGLE_REFRESH_TOKEN' => $refreshToken,
        ]);

        Artisan::call('config:clear');

        return redirect()
            ->route('setup.google-meet.index')
            ->with('status', 'Setup complete! Google Meet is ready. Confirm a meeting from the company panel to test.');
    }
}
