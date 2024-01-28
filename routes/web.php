<?php

use App\Http\Controllers\Customer\PaymentController;
use App\Http\Controllers\LanguageController;
use Illuminate\Support\Facades\Route;


/*
 * Global Routes
 * Routes that are used between both frontend and backend.
 */

// Switch between the included languages
Route::get('lang/{lang}', [LanguageController::class, 'swap']);

// Localization
Route::get('/js/lang.js', function () {

    $strings = Cache::rememberForever('lang.js', function () {
        $lang = session()->get('locale');
        $files = glob(resource_path('lang/' . $lang . '/*.php'));
        $strings = [];

        foreach ($files as $file) {
            $name           = basename($file, '.php');
            $strings[$name] = require $file;
        }

        return $strings;
    });

    header('Content-Type: text/javascript');
    echo('window.i18n = ' . json_encode($strings) . ';');
    exit();
})->name('assets.lang');

/*
 * Frontend Routes
 * Namespaces indicate folder structure
 */
Route::group(['namespace' => 'Frontend', 'as' => 'frontend.'], function () {
    include_route_files(__DIR__.'/frontend/');
});

/*
 * Backend Routes
 * Namespaces indicate folder structure
 */
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {
    /*
     * These routes need view-backend permission
     * (good if you want to allow more than one group in the backend,
     * then limit the backend features by different roles or permissions)
     *
     * Note: Administrator has all permissions so you do not have to specify the administrator role everywhere.
     * These routes can not be hit if the password is expired
     */
    include_route_files(__DIR__.'/backend/');
});

Route::group(['namespace' => 'Customer', 'prefix' => 'customer', 'as' => 'customer.', 'middleware' => 'customer'], function () {
    include_route_files(__DIR__.'/customer/');
});

Route::group(['namespace' => 'Manager', 'prefix' => 'manager', 'as' => 'manager.', 'middleware' => 'manager'], function () {
    include_route_files(__DIR__.'/manager/');
});

Route::group(['namespace' => 'Accountant', 'prefix' => 'accountant', 'as' => 'accountant.', 'middleware' => 'accountant'], function () {
    include_route_files(__DIR__.'/accountant/');
});

Route::group(['namespace' => 'Dtp', 'prefix' => 'dtp', 'as' => 'dtp.', 'middleware' => 'dtp'], function () {
    include_route_files(__DIR__.'/dtp/');
});

// Payments routes
Route::group(['middleware' => 'throttle:15'], function () {
    Route::group(['prefix' => 'customer/finance', 'as' => 'customer.finance.'], function () {
        Route::post('payment/success', [PaymentController::class, 'onSuccess']);
        Route::post('payment/failure', [PaymentController::class, 'onFailure']);
    });
});
