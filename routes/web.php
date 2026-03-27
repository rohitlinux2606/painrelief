<?php

use App\Http\Controllers\Admin\Productcontroller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', [App\Http\Controllers\Pagecontroller::class, 'home'])->name('page.home');
Route::get('/about-us', [App\Http\Controllers\Pagecontroller::class, 'about'])->name('page.about');
Route::get('/contact-us', [App\Http\Controllers\Pagecontroller::class, 'contact'])->name('page.contact');
Route::get('/product/{id}', [App\Http\Controllers\Pagecontroller::class, 'productDetail'])->name('product-detail');
Route::get('/cart/add/{id}', [App\Http\Controllers\Pagecontroller::class, 'addToCart'])->name('add-to-cart');
Route::get('/buy-now/{id}', [App\Http\Controllers\Pagecontroller::class, 'buyNow'])->name('buy-now');
Route::get('/cart/show', [App\Http\Controllers\Pagecontroller::class, 'showCart'])->name('show-cart');
Route::post('/cart/update', [App\Http\Controllers\Pagecontroller::class, 'updateQuantity'])->name('update-cart');
Route::get('/cart/delete-item/{id}', [App\Http\Controllers\Pagecontroller::class, 'removeItem'])->name('cart.delete-item');
Route::get('/checkout', [App\Http\Controllers\Pagecontroller::class, 'checkout'])->name('checkout');
Route::post('/place-order', [App\Http\Controllers\Pagecontroller::class, 'placeOrder'])->name('place-order');
Route::post('/cancel-order', [App\Http\Controllers\Pagecontroller::class, 'cancelOrder'])->name('cancel-order');
Route::get('/order-success/{orderNumber}', [App\Http\Controllers\Pagecontroller::class, 'orderSuccess'])->name('order-success');

Route::post('cod', [App\Http\Controllers\Admin\PayementController::class, 'cod'])->name('shop.payment.cod');

Route::post('cashfree', [App\Http\Controllers\Admin\PayementController::class, 'cashFree'])->name('shop.payment.cashfree');

Route::get('/privacy-policy', [App\Http\Controllers\Pagecontroller::class, 'privacyPolicy'])->name('page.privacy');
Route::get('/terms-and-conditions', [App\Http\Controllers\Pagecontroller::class, 'termsConditions'])->name('page.terms');
Route::get('/refund-and-cancellation-policy', [App\Http\Controllers\Pagecontroller::class, 'refundPolicy'])->name('page.refund');
Route::get('/return-policy', [App\Http\Controllers\Pagecontroller::class, 'returnPolicy'])->name('page.return');

// if try register then redirect login
Route::get('/register', function () {
    return redirect()->to('/login');
});

Route::get('clear-session', function (Request $request) {
    $request->session()->flush();

    return redirect()->back();
});

Route::middleware(['web', 'auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.pages.dashboard.dashboard');
    })->name('dashboard');

    Route::name('product-control.')->group(function () {
        Route::resource('product', Productcontroller::class);
        Route::resource('product-videos', App\Http\Controllers\Admin\ProductVideoController::class);
        Route::post('product-image/delete', [Productcontroller::class, 'deleteImage'])->name('image.delete');
    });

    Route::name('customer-control.')->group(function () {
        Route::resource('customer', App\Http\Controllers\Admin\CustomerController::class);
        Route::get('customer/{id}/restore', [App\Http\Controllers\Admin\CustomerController::class, 'restore'])->name('customer.restore');
        Route::delete('customer/{id}/force-delete', [App\Http\Controllers\Admin\CustomerController::class, 'forceDelete'])->name('customer.forceDelete');
        Route::get('get/customer/address/{id}', [App\Http\Controllers\Admin\CustomerController::class, 'getCustomerAddresses'])->name('customer.address');
    });

    Route::name('order-control.')->group(function () {
        Route::resource('order', App\Http\Controllers\Admin\OrderController::class);
    });

    Route::name('web-setting.')->group(function () {
        Route::get('web-settings', [App\Http\Controllers\Admin\WebSettingController::class, 'index'])->name('index');
        Route::post('web-settings', [App\Http\Controllers\Admin\WebSettingController::class, 'store'])->name('store');
    });
});

// Migration command
Route::get('/run-migrations', function () {
    Artisan::call('migrate', ['--force' => true]);

    return 'Migrations have been run!';
})->name('run-migrations');

// seed specific class name data
Route::get('/seed-data', function () {
    Artisan::call('db:seed', ['--force' => true]);

    return 'Seeders have been run!';
})->name('seed-data');

// add admin route file
require __DIR__ . '/admin.php';
