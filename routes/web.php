<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AboutMeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //logout
    Route::get('custom-logout', [DashboardController::class, 'custom_logout'])->name('custom.logout');

    //about me part
    Route::prefix('about')->name('about.')->group(function () {
        Route::get('/create', [AboutMeController::class, 'create'])->name('create');
        Route::post('/store', [AboutMeController::class, 'store'])->name('store');
        Route::get('/', [AboutMeController::class, 'show'])->name('show');
        Route::post('/status/{id}', [AboutMeController::class, 'updateStatus'])->name('status');
        Route::get('/edit/{id}', [AboutMeController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [AboutMeController::class, 'update'])->name('update');

    });
    


});

require __DIR__.'/auth.php';
