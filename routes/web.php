<?php

use App\Domain\Shared\Controllers\HomePageController;
use Illuminate\Support\Facades\Route;

/**
 * Web routes entry point.
 * Reorganized to follow a clean Domain-Driven directory layout.
 */

Route::get('/', HomePageController::class)->name('home');
Route::get('/home', HomePageController::class)->name('frontend.home');
Route::get('/login', function () {
    return redirect()->route('frontend.user.login');
})->name('login');

require __DIR__.'/user.php';
require __DIR__.'/visitor.php';
require __DIR__.'/admin.php';
require __DIR__.'/company.php';
require __DIR__.'/event.php';
