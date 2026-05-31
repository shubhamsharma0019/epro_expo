<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VisitorFlow\ExhibitionApiController;

Route::get('/exhibitions', [ExhibitionApiController::class, 'getExhibitions']);
Route::get('/exhibitions/{id}', [ExhibitionApiController::class, 'getExhibition']);
Route::get('/exhibitions/{exhibitionId}/exhibitors', [ExhibitionApiController::class, 'getExhibitors']);
Route::get('/exhibitions/exhibitors/{exhibitorId}', [ExhibitionApiController::class, 'getExhibitor']);
Route::post('/exhibitions/{exhibitionId}/register', [ExhibitionApiController::class, 'registerVisitor']);
Route::post('/exhibitions/visitors/{bookingId}/payment', [ExhibitionApiController::class, 'confirmPayment']);
Route::get('/exhibitions/visitors/tickets', [ExhibitionApiController::class, 'getTickets']);
Route::get('/exhibitions/visitors/tickets/{bookingId}', [ExhibitionApiController::class, 'getTicketDetails']);
Route::post('/exhibitions/visitors/{bookingId}/check-in', [ExhibitionApiController::class, 'checkIn']);
Route::post('/exhibitions/meetings/request', [ExhibitionApiController::class, 'requestMeeting']);
Route::get('/exhibitions/meetings/list', [ExhibitionApiController::class, 'getMeetings']);

// Exhibition Halls & Pavilions API
Route::get('/halls', [ExhibitionApiController::class, 'getHalls']);
Route::get('/halls/{id}', [ExhibitionApiController::class, 'getHall']);
Route::get('/pavilions', [ExhibitionApiController::class, 'getPavilions']);
Route::get('/pavilions/{id}', [ExhibitionApiController::class, 'getPavilion']);
Route::get('/exhibitors/{exhibitorId}/videos', [ExhibitionApiController::class, 'getExhibitorVideos']);

// Extra Visitor Flow API Endpoints
Route::get('/exhibitions/{id}/ticket-tiers', [ExhibitionApiController::class, 'getTicketTiers']);
Route::get('/exhibitors/{id}/products', [ExhibitionApiController::class, 'getProducts']);
Route::get('/visitors/{bookingId}/bookmarks', [ExhibitionApiController::class, 'getBookmarks']);
Route::post('/visitors/{bookingId}/bookmarks/toggle', [ExhibitionApiController::class, 'toggleBookmark']);
Route::get('/exhibitions/{id}/announcements', [ExhibitionApiController::class, 'getAnnouncements']);
Route::get('/exhibitions/{id}/faqs', [ExhibitionApiController::class, 'getFaqs']);
Route::get('/exhibitions/{id}/agenda', [ExhibitionApiController::class, 'getAgenda']);
Route::get('/exhibitions/{id}/speakers', [ExhibitionApiController::class, 'getSpeakersList']);
Route::get('/exhibitions/{id}/sponsors', [ExhibitionApiController::class, 'getSponsors']);


