<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Carbon;
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
            'welcome' => App\Models\Settings::where('name', 'welcome')->first()->value
        ],
    ]);
});

Route::get('/terms-of-service', function () {
    return Inertia::render('TermsOfService', [
        'settings' => [
            'terms' => App\Models\Settings::where('name', 'terms')->first()->value
        ],
    ]);
})->name('terms-of-service');

Route::get('/privacy-policy', function () {
    return Inertia::render('PrivacyPolicy', [
        'settings' => [
            'privacy' => App\Models\Settings::where('name', 'privacy')->first()->value
        ],
    ]);
})->name('privacy-policy');

Route::group(['prefix' => 'contact-us'], function () {
    Route::get('/', function () {
        return Inertia::render('ContactUs', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'settings' => [
                'email' => App\Models\Settings::where('name', 'email')->first()->value,
                'phone' => App\Models\Settings::where('name', 'phone')->first()->value,
                'address' => App\Models\Settings::where('name', 'address')->first()->value
            ],
        ]);
    })->name('contact-us');
    Route::put('/update', [\App\Http\Controllers\GuestController::class, 'contactUs'])->name('contact-us.update');
});

Route::get('/pricing', [\App\Http\Controllers\GuestController::class, 'countries'])->name('pricing');

Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
    Route::any('/send', [\App\Http\Controllers\SmsController::class, 'edit'])->name('sms.edit');
    Route::get('/reports', [\App\Http\Controllers\SmsController::class, 'index'])->name('sms.index');
    Route::put('/sms/estimate', [\App\Http\Controllers\SmsController::class, 'estimate'])->name('sms.estimate');
    Route::put('/sms/send', [\App\Http\Controllers\SmsController::class, 'send'])->name('sms.send');
});

Route::group(['prefix' => 'manager', 'middleware' => ['auth:sanctum', 'verified', 'manager']], function () {
    Route::get('/', function () {
        return Inertia::render('Manager');
    })->name('manager');
    Route::group(['prefix' => 'users'], function () {
        Route::get('/', [\App\Http\Controllers\Manager\UsersController::class, 'index'])->name('manager.users');
        Route::get('/{user}/destroy', [\App\Http\Controllers\Manager\UsersController::class, 'destroy'])->name('manager.users.destroy');
        Route::get('/{user}/restore', [\App\Http\Controllers\Manager\UsersController::class, 'restore'])->name('manager.users.restore');
        Route::put('/{user}/money', [\App\Http\Controllers\Manager\UsersController::class, 'updateMoney'])->name('manager.users.money.update');
        Route::put('/{user}/discount', [\App\Http\Controllers\Manager\UsersController::class, 'updateDiscount'])->name('manager.users.discount.update');
    });
    Route::group(['prefix' => 'settings'], function () {
        Route::get('/', [\App\Http\Controllers\Manager\SettingsController::class, 'edit'])->name('manager.settings.edit');
        Route::put('/update', [\App\Http\Controllers\Manager\SettingsController::class, 'update'])->name('manager.settings.update');
    });
    Route::group(['prefix' => 'countries'], function () {
        Route::get('/', [\App\Http\Controllers\Manager\CountriesController::class, 'index'])->name('manager.countries');
        Route::get('/{country}/destroy', [\App\Http\Controllers\Manager\CountriesController::class, 'destroy'])->name('manager.countries.destroy');
        Route::get('/{country}/restore', [\App\Http\Controllers\Manager\CountriesController::class, 'restore'])->name('manager.countries.restore');
        Route::put('/{country}/update', [\App\Http\Controllers\Manager\CountriesController::class, 'update'])->name('manager.countries.update');
    });
});
