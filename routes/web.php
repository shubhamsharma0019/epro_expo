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

if (app()->environment('local')) {
    Route::prefix('setup/google-meet')->name('setup.google-meet.')->group(function () {
        Route::get('/', [\App\Domain\Shared\Controllers\GoogleMeetSetupController::class, 'index'])->name('index');
        Route::post('/credentials', [\App\Domain\Shared\Controllers\GoogleMeetSetupController::class, 'saveCredentials'])->name('credentials');
        Route::get('/connect', [\App\Domain\Shared\Controllers\GoogleMeetSetupController::class, 'connect'])->name('connect');
        Route::get('/callback', [\App\Domain\Shared\Controllers\GoogleMeetSetupController::class, 'callback'])->name('callback');
    });
}

require __DIR__.'/user.php';
require __DIR__.'/visitor.php';
require __DIR__.'/admin.php';
require __DIR__.'/company.php';
require __DIR__.'/event.php';
