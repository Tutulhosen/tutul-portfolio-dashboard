<?php

use App\Http\Controllers\Api\FrontendDataController;
use Illuminate\Support\Facades\Route;

// Public route for login (no authentication needed)
Route::post('/login', [FrontendDataController::class, 'login']);

// Routes that require Sanctum authentication
Route::middleware('auth:sanctum')->group(function () {
    
    Route::get('/hero', [FrontendDataController::class, 'hero']);
});
    Route::get('/about', [FrontendDataController::class, 'about']);
    Route::get('/skill', [FrontendDataController::class, 'skill']);
    Route::get('/project', [FrontendDataController::class, 'project']);
    Route::post('/contact', [FrontendDataController::class, 'contact']);
