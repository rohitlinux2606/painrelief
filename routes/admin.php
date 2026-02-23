<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth'])->prefix('amazon')->name('amazon.')->group(function () {
    Route::get('/fetch-products', [App\Http\Controllers\Admin\AmazonController::class, 'fetchProducts'])->name('fetch-products');
});
