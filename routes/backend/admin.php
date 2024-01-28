<?php

use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\OptionController;
use App\Http\Controllers\Backend\PayerController;
use Illuminate\Support\Facades\Route;

/*
 * All route names are prefixed with 'admin.'.
 */
Route::redirect('/', '/admin/dashboard', 301);
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('option/print', [OptionController::class, 'print'])->name('option.print');
Route::get('option/cost', [OptionController::class, 'cost'])->name('option.cost');
Route::patch('option/update', [OptionController::class, 'update'])->name('option.update');

Route::resource('material', 'MaterialController')->except('show');

Route::get('option/self_legal_entities', [OptionController::class, 'selfLegalEntities'])
    ->name('option.self-legal-entities');

Route::get('payers', [PayerController::class, 'index'])->name('payers');

