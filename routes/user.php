<?php

use App\Domain\Shared\Controllers\Auth\UserAuthController;
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

    Route::get('/dashboard', [VisitorDashboardController::class, 'index'])->name('dashboard');

    Route::prefix('tickets')->name('tickets.')->group(function () {
        Route::get('/', [\App\Domain\Visitor\Controllers\UserTicketController::class, 'index'])->name('index');

        Route::get('/{id}/e-ticket', [\App\Domain\Visitor\Controllers\UserTicketController::class, 'download'])->name('e-ticket');

        Route::get('/{id}', [\App\Domain\Visitor\Controllers\UserTicketController::class, 'show'])->name('show');
    });

    Route::prefix('exhibition-tickets')->name('exhibition-tickets.')->group(function () {
        Route::get('/', function () {
            $tickets = auth()->check()
                ? \App\Domain\Visitor\Models\VisitorTicket::where('user_id', auth()->id())
                    ->with(['companyEvent', 'ticketType'])
                    ->orderBy('created_at', 'desc')
                    ->get()
                : collect();

            return view('frontend.user.tickets.index', compact('tickets'));
        })->name('index');

        Route::get('/{id}/e-ticket', function ($id) {
            return redirect()->route('frontend.user.tickets.e-ticket', $id);
        })->name('e-ticket');

        Route::get('/{id}', function ($id) {
            return redirect()->route('frontend.user.tickets.show', $id);
        })->name('show');
    });

    Route::prefix('visits')->name('visits.')->group(function () {
        Route::get('/', function () {
            return view('frontend.user.visits.index');
        })->name('index');

        Route::get('/{id}', function ($id) {
            return view('frontend.user.visits.show', compact('id'));
        })->name('show');
    });

    Route::get('/saved/exhibitions', function () {
        return view('frontend.user.saved.exhibitions');
    })->name('saved.exhibitions');

    Route::get('/booths/visited', function () {
        return view('frontend.user.booths.visited');
    })->name('booths.visited');

    Route::get('/profile', function () {
        return view('frontend.user.profile');
    })->name('profile');
});
