<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth'])->prefix('amazon')->name('amazon.')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\AmazonController::class, 'index'])->name('index');
    Route::get('/fetch-products', [App\Http\Controllers\Admin\AmazonController::class, 'fetchProducts'])->name('fetch-products');
    Route::get('/pricing', [App\Http\Controllers\Admin\AmazonController::class, 'getPricing'])->name('get-pricing');
    Route::get('/orders', [App\Http\Controllers\Admin\AmazonController::class, 'listOrders'])->name('list-orders');
    Route::get('/orders/{orderId}', [App\Http\Controllers\Admin\AmazonController::class, 'trackOrder'])->name('track-order');
});
