<?php

use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::get('/events', [EventController::class, 'index']);
Route::post('/events', [EventController::class, 'store']);
Route::get('/events/{id}', [EventController::class, 'show']);
Route::post('/events/{id}/branding', [EventController::class, 'updateBranding']);
Route::post('/events/{id}/tickets', [EventController::class, 'updateTickets']);
Route::post('/events/{id}/submit', [EventController::class, 'submitReview']);

// User flow endpoints
use App\Http\Controllers\UserFlowController;
Route::group(['prefix' => 'user'], function() {
    Route::get('/active-event', [UserFlowController::class, 'getActiveEvent']);
    Route::get('/bookings', [UserFlowController::class, 'getBookings']);
    Route::get('/bookings/{booking_id}', [UserFlowController::class, 'getBookingById']);
    Route::post('/bookings/{booking_id}/check-in', [UserFlowController::class, 'checkIn']);
    Route::post('/feedback', [UserFlowController::class, 'submitFeedback']);
});

// Exhibition Visitor Flow endpoints
use App\Http\Controllers\ExhibitionController;
use App\Http\Controllers\ExhibitionVisitorController;
use App\Http\Controllers\ExhibitionMeetingController;

Route::group(['prefix' => 'exhibitions'], function() {
    Route::get('/', [ExhibitionController::class, 'index']);
    Route::get('/{id}', [ExhibitionController::class, 'show']);
    Route::get('/{id}/exhibitors', [ExhibitionController::class, 'getExhibitors']);
    Route::get('/exhibitors/{id}', [ExhibitionController::class, 'showExhibitor']);
    Route::post('/{id}/register', [ExhibitionVisitorController::class, 'register']);
    Route::post('/visitors/{booking_id}/payment', [ExhibitionVisitorController::class, 'confirmPayment']);
    Route::get('/visitors/tickets', [ExhibitionVisitorController::class, 'getTickets']);
    Route::get('/visitors/tickets/{booking_id}', [ExhibitionVisitorController::class, 'getTicketDetails']);
    Route::post('/visitors/{booking_id}/check-in', [ExhibitionVisitorController::class, 'checkIn']);
    Route::post('/meetings/request', [ExhibitionMeetingController::class, 'requestMeeting']);
    Route::get('/meetings/list', [ExhibitionMeetingController::class, 'index']);
});
