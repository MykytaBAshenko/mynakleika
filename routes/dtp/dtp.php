<?php

use App\Http\Controllers\Dtp\DashboardController;
use Illuminate\Support\Facades\Route;

/*
 * All route names are prefixed with 'customer.'.
 */
Route::redirect('/', '/dtp/dashboard', 301);
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('layout/{type}/{orderId}', 'FileController@getLayout')->name('file.getLayout');
