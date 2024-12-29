<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AboutMeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SkillController;

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
        Route::delete('/{id}', [AboutMeController::class, 'destroy'])->name('destroy');

    });
    

    //project  part
    Route::prefix('project')->name('project.')->group(function () {
        Route::get('/create', [ProjectController::class, 'create'])->name('create');
        Route::post('/store', [ProjectController::class, 'store'])->name('store');
        Route::get('/', [ProjectController::class, 'show'])->name('show');
        Route::post('/status/{id}', [ProjectController::class, 'updateStatus'])->name('status');
        Route::get('/edit/{id}', [ProjectController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [ProjectController::class, 'update'])->name('update');
        Route::delete('/{id}', [ProjectController::class, 'destroy'])->name('destroy');

    });

    //Skill  part
    Route::prefix('skill')->name('skill.')->group(function () {
        Route::get('/create', [SkillController::class, 'create'])->name('create');
        Route::post('/store', [SkillController::class, 'store'])->name('store');
        Route::get('/', [SkillController::class, 'show'])->name('show');
        Route::post('/status/{id}', [SkillController::class, 'updateStatus'])->name('status');
        Route::get('/edit/{id}', [SkillController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [SkillController::class, 'update'])->name('update');
        Route::delete('/{id}', [SkillController::class, 'destroy'])->name('destroy');

    });

    //Contact  part
    Route::prefix('contact')->name('contact.')->group(function () {
        Route::get('/create', [ContactController::class, 'create'])->name('create');
        Route::post('/store', [ContactController::class, 'store'])->name('store');
        Route::get('/', [ContactController::class, 'show'])->name('show');
        Route::post('/status/{id}', [ContactController::class, 'updateStatus'])->name('status');
        Route::get('/edit/{id}', [ContactController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [ContactController::class, 'update'])->name('update');
        Route::delete('/{id}', [ContactController::class, 'destroy'])->name('destroy');

    });

});

require __DIR__.'/auth.php';
