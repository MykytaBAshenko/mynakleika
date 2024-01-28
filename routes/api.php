<?php

use App\Http\Controllers\API\FileController;
use App\Http\Controllers\API\OptionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::middleware('auth:api')
    ->namespace('API')
    ->name('api.')
    ->group(function() {
        Route::apiResource('order', 'OrderController');
        Route::get('orders', [\App\Http\Controllers\API\OrderController::class, 'list'])->name('orders');
        Route::get('orders_for_dtp', [\App\Http\Controllers\API\OrderController::class, 'listForDtp'])->name('orders_for_dtp');
        Route::get('orders_for_payment', [\App\Http\Controllers\API\OrderController::class, 'listForPayment'])->name('orders_for_payment');

        // Balance routes
        Route::get('balance', [\App\Http\Controllers\API\BalanceController::class, 'getBalance'])->name('balance');
        Route::get('transactions', [\App\Http\Controllers\API\BalanceController::class, 'getTransactions'])->name('transactions');

        // Payers route
        Route::get('payers', [\App\Http\Controllers\API\PayerController::class, 'list'])->name('payers');
        Route::patch('payer/{payer}', [\App\Http\Controllers\API\PayerController::class, 'update'])->name('payer.update');
    });

// File routes
Route::group(['middleware' => 'throttle:10'], function () {
    Route::group(['prefix' => 'file', 'as' => 'api.file.'], function () {
        Route::post('upload', [FileController::class, 'upload'])->name('upload');
        Route::get('getProcessed', [FileController::class, 'getProcessed'])->name('get_processed');
    });
});

// Options route
Route::get('options', [OptionController::class, 'getOptions']);
