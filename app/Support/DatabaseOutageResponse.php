<?php

namespace App\Support;

use App\Domain\Shared\Services\HomePageData;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use PDOException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class DatabaseOutageResponse
{
    public static function forRequest(Request $request, Throwable $exception): ?Response
    {
        if (! DbGuard::isConnectionError($exception)) {
            return null;
        }

        DbGuard::markUnavailable();

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Database is unavailable. Start the MySQL80 service and refresh.',
            ], 503);
        }

        $routeName = (string) $request->route()?->getName();
        $path = trim($request->path(), '/');

        if ($routeName === '') {
            return self::forAuthPath($request, $path) ?? response()->view('errors.database-offline', [
                'retryUrl' => $request->fullUrl(),
            ], 503);
        }

        return match (true) {
            in_array($routeName, ['home', 'frontend.home'], true) => response()->view('frontend.home', [
                'home' => (new HomePageData)->build(),
            ]),

            in_array($routeName, ['exhibitions.index', 'exhibitions.browse'], true) => response()->view('frontend.exhibitions.index', [
                'dynamicExhibitions' => collect(),
            ]),

            $routeName === 'exhibitions.home' => response()->view('frontend.exhibitions.home', [
                'liveBooths' => collect(),
            ]),

            in_array($routeName, ['exhibitions.booths.index', 'exhibitions.visitor.companies'], true) => response()->view('frontend.exhibitions.booths.index', [
                'slug' => (string) $request->route('slug'),
                'booths' => collect(),
                'isPassActive' => false,
            ]),

            $routeName === 'events.home' => response()->view('frontend.events.home', [
                'events' => [],
                'categories' => [],
                'countries' => [],
                'tickets' => [],
                'slots' => [],
                'sampleTicket' => null,
            ]),

            $routeName === 'events.listings.index' => response()->view('frontend.events.listings.index', [
                'dbEvents' => collect(),
                'status' => 'upcoming',
                'statusCounts' => ['upcoming' => 0, 'ongoing' => 0, 'past' => 0],
                'categories' => collect(),
                'countries' => collect(['India']),
            ]),

            in_array($routeName, ['company.register', 'company.event-company.register'], true) => self::authView('frontend.auth.company-register', [
                'flowContext' => str_contains($routeName, 'event-company') ? 'event_company' : ($request->query('flow') === 'event_company' ? 'event_company' : null),
            ]),

            $routeName === 'company.login' => self::authView('frontend.auth.company-login'),

            $routeName === 'company.event-company.login' => self::authView('frontend.auth.company-event-login'),

            in_array($routeName, ['frontend.user.login', 'frontend.user.register'], true) => self::authView(
                $routeName === 'frontend.user.register' ? 'frontend.auth.user-register' : 'frontend.auth.user-login'
            ),

            in_array($routeName, ['company.register.store', 'company.event-company.register.store'], true) => redirect()
                ->route(str_contains($routeName, 'event-company') ? 'company.event-company.register' : 'company.register')
                ->withInput($request->except('password', 'password_confirmation'))
                ->withErrors(['email' => 'Database is unavailable. Start MySQL80, then try again.']),

            default => self::forAuthPath($request, $path) ?? response()->view('errors.database-offline', [
                'retryUrl' => $request->fullUrl(),
            ], 503),
        };
    }

    private static function authView(string $view, array $data = []): Response
    {
        return response()->view($view, array_merge($data, [
            'errors' => session()->get('errors') ?? new \Illuminate\Support\ViewErrorBag,
        ]));
    }

    private static function forAuthPath(Request $request, string $path): ?Response
    {
        return match ($path) {
            'company/register' => self::authView('frontend.auth.company-register', [
                'flowContext' => $request->query('flow') === 'event_company' ? 'event_company' : null,
            ]),
            'company/login' => self::authView('frontend.auth.company-login'),
            'company/event-company/register' => self::authView('frontend.auth.company-register', [
                'flowContext' => 'event_company',
            ]),
            'company/event-company/login' => self::authView('frontend.auth.company-event-login'),
            'user/login' => self::authView('frontend.auth.user-login'),
            'user/register' => self::authView('frontend.auth.user-register'),
            default => null,
        };
    }
}
