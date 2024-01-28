<?php

use App\Http\Controllers\Customer\PaymentController;
use App\Http\Controllers\Customer\OrderController;
use App\Http\Controllers\Customer\ProfileController;
use App\Http\Controllers\Customer\DeliveryController;
use App\Http\Controllers\Customer\FileController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\Customer\LegalEntityController;
use Illuminate\Support\Facades\Route;

/*
 * All route names are prefixed with 'customer. '.
 */
Route::redirect('/', '/customer/dashboard', 301);
Route::get('dashboard', [OrderController::class, 'index'])->name('dashboard');

// Order routes
Route::get('order/create', [OrderController::class, 'create'])->name('order.create');
Route::post('order/store', [OrderController::class, 'store'])->name('order.store');
Route::delete('order/{order}', [OrderController::class, 'destroy'])->name('order.destroy');

// Profile routes
Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('profile/update', [ProfileController::class, 'update'])->name('profile.update');

// Delivery routes
Route::get('deliveries', [DeliveryController::class, 'index'])->name('deliveries');
Route::post('delivery/store', [DeliveryController::class, 'store'])->name('delivery.store');
Route::delete('delivery/{delivery}', [DeliveryController::class, 'destroy'])->name('delivery.destroy');
Route::get('deliveries/get_customer_deliveries', [DeliveryController::class, 'get_customer_deliveries'])->name('deliveries.get_customer_deliveries');

// LegalEntities routes
Route::get('legal_entities', [LegalEntityController::class, 'index'])->name('legal_entities');
Route::post('legal_entity', [LegalEntityController::class, 'store'])->name('legal_entity.store');
Route::put('legal_entity/{legalEntity}', [LegalEntityController::class, 'update'])->name('legal_entity.update');
Route::delete('legal_entity/{legalEntity}', [LegalEntityController::class, 'destroy'])->name('legal_entity.destroy');

// Invoice routes
Route::get('get_invoices', [InvoiceController::class, 'getInvoices'])->name('invoice.list');
Route::get('invoice/create', [InvoiceController::class, 'create'])->name('invoice.create');
Route::post('invoice/store', [InvoiceController::class, 'store'])->name('invoice.store');

// File routes
Route::post('file/upload', [FileController::class, 'store'])->name('file.upload');
Route::get('file/getProcessed', [FileController::class, 'getProcessed'])->name('file.get_processed');
Route::get('file/getProcessedTest', [FileController::class, 'getProcessedXml']);
Route::get('file/copy-preview', [FileController::class, 'copyPreviewToWebServer']);

Route::group(['prefix' => 'finance', 'as' => 'finance.'], function () {
    // Payments routes
    Route::get('payments', [PaymentController::class, 'index'])->name('payments');
    Route::post('payment/card', [PaymentController::class, 'payByCard'])->name('payment.card');
    Route::get('payment/portmone', [PaymentController::class, 'redirectToPaymentGate'])->name('payment.gate');

    Route::get('invoices', [InvoiceController::class, 'index'])->name('invoices');
    Route::view('transactions', 'customer.finance.transactions.index')->name('transactions');
});

