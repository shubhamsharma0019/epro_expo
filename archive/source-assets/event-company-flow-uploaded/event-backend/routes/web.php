<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'message' => 'Welcome to the eproexpo Event & Exhibition API Backend',
        'status' => 'Running'
    ]);
});
