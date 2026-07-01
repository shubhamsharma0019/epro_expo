<?php

use App\Domain\Shared\Controllers\Auth\UserAuthController;
use App\Domain\Visitor\Controllers\UserPortalController;
use App\Domain\Visitor\Controllers\UserTicketController;
use App\Domain\Visitor\Controllers\VisitorDashboardController;
use Illuminate\Support\Facades\Route;

Route::prefix('user')->name('frontend.user.')->group(function () {
    Route::get('/', function () {
        return redirect('/user/dashboard');
    })->name('home');

    Route::get('/login', [UserAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [UserAuthController::class, 'login'])->name('login.store');
    Route::get('/register', [UserAuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [UserAuthController::class, 'register'])->name('register.store');
    Route::post('/logout', [UserAuthController::class, 'logout'])->name('logout');

    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', [VisitorDashboardController::class, 'index'])->name('dashboard');
        Route::get('/passes', [UserTicketController::class, 'index'])->name('passes');
        Route::get('/meetings', [\App\Domain\Visitor\Controllers\UserMeetingsController::class, 'index'])->name('meetings');
        Route::post('/meetings/{id}/join', [\App\Domain\Visitor\Controllers\UserMeetingsController::class, 'requestJoin'])->name('meetings.join');
        Route::get('/browse', [\App\Domain\Visitor\Controllers\UserBrowseController::class, 'index'])->name('browse');
        Route::get('/exhibitions/{slug}/halls', [UserTicketController::class, 'exhibitionHalls'])->name('exhibitions.halls');
        Route::get('/exhibitions/{slug}/halls/{hallSlug}', [UserTicketController::class, 'exhibitionHallLayout'])->name('exhibitions.halls.show');
        Route::get('/exhibitions/{slug}/halls/{hallSlug}/booths/{boothId}', [\App\Domain\Visitor\Controllers\UserExhibitionBoothController::class, 'show'])->name('exhibitions.booths.show');
        Route::post('/exhibitions/{slug}/halls/{hallSlug}/booths/{boothId}/meetings', [\App\Domain\Visitor\Controllers\UserExhibitionBoothController::class, 'requestMeeting'])->name('exhibitions.booths.meetings.request');
        Route::post('/exhibitions/{slug}/halls/{hallSlug}/booths/{boothId}/sessions/{sessionId}/register', [\App\Domain\Visitor\Controllers\UserExhibitionBoothController::class, 'registerSession'])->name('exhibitions.booths.sessions.register');

        Route::prefix('tickets')->name('tickets.')->group(function () {
            Route::get('/', fn () => redirect()->route('frontend.user.passes'))->name('index');
            Route::get('/exhibition/{id}', [UserTicketController::class, 'showExhibitionPass'])->name('exhibition.show');
            Route::get('/exhibition/{id}/pass', [UserTicketController::class, 'downloadExhibitionPass'])->name('exhibition.pass');
            Route::get('/{id}/e-ticket', [UserTicketController::class, 'download'])->name('e-ticket');
            Route::post('/{id}/email', [UserTicketController::class, 'sendTicketEmail'])->name('email');
            Route::get('/{id}', [UserTicketController::class, 'show'])->name('show');
        });

        Route::prefix('exhibition-tickets')->name('exhibition-tickets.')->group(function () {
            Route::get('/', fn () => redirect()->route('frontend.user.passes'))->name('index');
            Route::get('/{id}/e-ticket', fn ($id) => redirect()->route('frontend.user.tickets.exhibition.pass', $id))->name('e-ticket');
            Route::get('/{id}', fn ($id) => redirect()->route('frontend.user.tickets.exhibition.show', $id))->name('show');
        });

        Route::prefix('visits')->name('visits.')->group(function () {
            Route::get('/', fn () => redirect()->route('frontend.user.dashboard'))->name('index');
            Route::get('/{id}', fn () => redirect()->route('frontend.user.dashboard'))->name('show');
        });

        Route::get('/saved/exhibitions', fn () => redirect()->route('frontend.user.passes'))->name('saved.exhibitions');
        Route::get('/booths/visited', fn () => redirect()->route('frontend.user.dashboard'))->name('booths.visited');

        Route::get('/profile', [UserPortalController::class, 'profile'])->name('profile');
        Route::post('/profile', [UserPortalController::class, 'updateProfile'])->name('profile.update');
        Route::get('/logout', [UserAuthController::class, 'showLogout'])->name('logout.confirm');
    });
});
