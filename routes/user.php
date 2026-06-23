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

        Route::prefix('tickets')->name('tickets.')->group(function () {
            Route::get('/', [UserTicketController::class, 'index'])->name('index');
            Route::get('/exhibition/{id}', [UserTicketController::class, 'showExhibitionPass'])->name('exhibition.show');
            Route::get('/exhibition/{id}/pass', [UserTicketController::class, 'downloadExhibitionPass'])->name('exhibition.pass');
            Route::get('/{id}/e-ticket', [UserTicketController::class, 'download'])->name('e-ticket');
            Route::get('/{id}', [UserTicketController::class, 'show'])->name('show');
        });

        Route::prefix('exhibition-tickets')->name('exhibition-tickets.')->group(function () {
            Route::get('/', fn () => redirect()->route('frontend.user.tickets.index'))->name('index');
            Route::get('/{id}/e-ticket', fn ($id) => redirect()->route('frontend.user.tickets.exhibition.pass', $id))->name('e-ticket');
            Route::get('/{id}', fn ($id) => redirect()->route('frontend.user.tickets.exhibition.show', $id))->name('show');
        });

        Route::prefix('visits')->name('visits.')->group(function () {
            Route::get('/', [UserPortalController::class, 'visits'])->name('index');
            Route::get('/{id}', [UserPortalController::class, 'visitShow'])->name('show');
        });

        Route::get('/saved/exhibitions', [UserPortalController::class, 'savedExhibitions'])->name('saved.exhibitions');
        Route::get('/booths/visited', [UserPortalController::class, 'visitedBooths'])->name('booths.visited');

        Route::get('/profile', [UserPortalController::class, 'profile'])->name('profile');
        Route::post('/profile', [UserPortalController::class, 'updateProfile'])->name('profile.update');
    });
});
