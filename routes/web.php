<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
        'settings' => [
            'welcome' => App\Models\Settings::where('name', 'Welcome')->first()->value
        ],
    ]);
});

Route::group(['prefix' => 'contact-us'], function () {
    Route::get('/', function () {
        return Inertia::render('ContactUs', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'settings' => [
                'email' => App\Models\Settings::where('name', 'Email')->first()->value,
                'phone' => App\Models\Settings::where('name', 'Phone')->first()->value,
                'address' => App\Models\Settings::where('name', 'Address')->first()->value
            ],
        ]);
    })->name('contact-us');
    Route::put('/update', [\App\Http\Controllers\GuestController::class, 'contactUs'])->name('contact-us.update');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

Route::group(['prefix' => 'manager', 'middleware' => ['auth:sanctum', 'verified', 'manager']], function () {
    Route::get('/', function () {
        return Inertia::render('Manager');
    })->name('manager');
    Route::group(['prefix' => 'users'], function () {
        Route::get('/', [\App\Http\Controllers\Manager\UsersController::class, 'index'])->name('manager.users');
        Route::get('/{user}/destroy', [\App\Http\Controllers\Manager\UsersController::class, 'destroy'])->name('manager.users.destroy');
        Route::get('/{user}/restore', [\App\Http\Controllers\Manager\UsersController::class, 'restore'])->name('manager.users.restore');
    });
    Route::group(['prefix' => 'settings'], function () {
        Route::get('/', [\App\Http\Controllers\Manager\SettingsController::class, 'edit'])->name('manager.settings.edit');
        Route::put('/update', [\App\Http\Controllers\Manager\SettingsController::class, 'update'])->name('manager.settings.update');
    });
});
