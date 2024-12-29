<?php

use App\Http\Controllers\Api\FrontendDataController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/about', [FrontendDataController::class, 'about']);
Route::get('/skill', [FrontendDataController::class, 'skill']);