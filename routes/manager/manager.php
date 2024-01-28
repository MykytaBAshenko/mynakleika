<?php

use App\Http\Controllers\Manager\DashboardController;

/*
 * All route names are prefixed with 'customer.'.
 */
Route::redirect('/', '/manager/dashboard', 301);
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');