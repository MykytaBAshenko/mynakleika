<?php

use App\Http\Controllers\Accountant\IncomeController;
use Illuminate\Support\Facades\Route;

/*
 * All route names are prefixed with 'customer.'.
 */
Route::redirect('/', '/accountant/dashboard', 301);
Route::get('dashboard', [IncomeController::class, 'index'])->name('dashboard');

// Income routes
Route::post('income/store', [IncomeController::class, 'store'])->name('income.store');

Route::get('incomes', function () {
	return \App\Models\Income::with(['legalEntity', 'invoice'])->get();
})->name('incomes');

Route::get('legal_entities/all', function () {
	return \App\Models\LegalEntity::all();
})->name('legal_entities.all');

Route::get('invoices/unpaid/{legal_entity}', function ($legal_entity) {
	return \App\Models\LegalEntity::find($legal_entity)->invoices()->unpaid()->get();
})->name('invoices.unpaid');

Route::get('invoice/get/{invoice}', function ($invoice) {
	return \App\Models\Invoice::find($invoice);
})->name('invoice.get');
