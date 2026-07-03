<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->validateCsrfTokens(except: [
            'company/booth-booking/payment/continue',
        ]);

        $middleware->alias([
            'company' => \App\Http\Middleware\CompanyMiddleware::class,
            'company.event' => \App\Http\Middleware\EnsureCompanyEventFlow::class,
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'ticket.scanner' => \App\Http\Middleware\EnsureTicketScanner::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\HttpException $exception, \Illuminate\Http\Request $request) {
            if ($exception->getStatusCode() !== 419) {
                return null;
            }

            $csrfException = $exception->getPrevious();
            if (! $csrfException instanceof \Illuminate\Session\TokenMismatchException) {
                $csrfException = new \Illuminate\Session\TokenMismatchException($exception->getMessage(), 0, $exception);
            }

            return \App\Support\CsrfMismatchResponse::forRequest($request, $csrfException);
        });

        $exceptions->render(function (\Throwable $exception, \Illuminate\Http\Request $request) {
            return \App\Support\DatabaseOutageResponse::forRequest($request, $exception);
        });
    })->create();


