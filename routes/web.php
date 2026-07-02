<?php

use App\Domain\Shared\Controllers\HomePageController;
use Illuminate\Support\Facades\Route;

/**
 * Web routes entry point.
 * Reorganized to follow a clean Domain-Driven directory layout.
 */

Route::get('/', HomePageController::class)->name('home');
Route::get('/home', HomePageController::class)->name('frontend.home');

Route::view('/features', 'frontend.pages.features')->name('frontend.features');
Route::view('/pricing', 'frontend.pages.pricing')->name('frontend.pricing');
Route::view('/about-us', 'frontend.pages.about')->name('frontend.about');
Route::get('/login', function () {
    return redirect()->route('frontend.user.login');
})->name('login');

Route::middleware('auth')->group(function () {
    Route::get('/qr-ticket/{ticket}', [\App\Domain\Visitor\Controllers\EventTicketController::class, 'showQrTicket'])
        ->name('qr-ticket.show');
    Route::post('/qr-ticket/{ticket}/send-email', [\App\Domain\Visitor\Controllers\EventTicketController::class, 'sendTicketEmail'])
        ->name('qr-ticket.send-email');
});
Route::prefix('ticket-scanner')->name('ticket-scanner.')->group(function () {
    Route::get('/login', [\App\Domain\Visitor\Controllers\TicketScannerAuthController::class, 'showLogin'])
        ->name('login');
    Route::post('/login', [\App\Domain\Visitor\Controllers\TicketScannerAuthController::class, 'login'])
        ->name('login.submit');
    Route::post('/logout', [\App\Domain\Visitor\Controllers\TicketScannerAuthController::class, 'logout'])
        ->name('logout');
});

Route::middleware('ticket.scanner')->group(function () {
    Route::get('/verify-ticket/{qr_token}', [\App\Domain\Visitor\Controllers\EventTicketController::class, 'verify'])
        ->name('verify-ticket.show');
    Route::post('/verify-ticket/{qr_token}/check-in', [\App\Domain\Visitor\Controllers\EventTicketController::class, 'checkIn'])
        ->name('verify-ticket.check-in');
});
Route::get('/ticket-qr/{qr_token}', [\App\Domain\Visitor\Controllers\EventTicketController::class, 'qrImage'])
    ->name('ticket-qr.image');

if (app()->environment('local')) {
    Route::prefix('setup/google-meet')->name('setup.google-meet.')->group(function () {
        Route::get('/', [\App\Domain\Shared\Controllers\GoogleMeetSetupController::class, 'index'])->name('index');
        Route::post('/credentials', [\App\Domain\Shared\Controllers\GoogleMeetSetupController::class, 'saveCredentials'])->name('credentials');
        Route::get('/connect', [\App\Domain\Shared\Controllers\GoogleMeetSetupController::class, 'connect'])->name('connect');
        Route::get('/callback', [\App\Domain\Shared\Controllers\GoogleMeetSetupController::class, 'callback'])->name('callback');
    });

    Route::prefix('setup/mail')->name('setup.mail.')->group(function () {
        Route::get('/', [\App\Domain\Shared\Controllers\MailSetupController::class, 'index'])->name('index');
        Route::post('/save', [\App\Domain\Shared\Controllers\MailSetupController::class, 'save'])->name('save');
        Route::post('/test', [\App\Domain\Shared\Controllers\MailSetupController::class, 'test'])->name('test');
    });
}

require __DIR__.'/user.php';
require __DIR__.'/visitor.php';
require __DIR__.'/admin.php';
require __DIR__.'/company.php';
require __DIR__.'/event.php';
