<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Http\Controllers\Admin\Productcontroller;

// Route::get('/', function () {
//     return redirect()->to('/index.html');
// });
Route::view('/c', 'checkout');
Route::view('/cart', 'cart');
Route::view('/product', 'product-detail');
// Route::get('/{any}', function () {
//     return redirect()->to('/index.html');
// })->where('any', '.*');

Auth::routes();

Route::get('/', [App\Http\Controllers\Pagecontroller::class, 'home'])->name('page.home');
Route::get('/product/{id}', [App\Http\Controllers\Pagecontroller::class, 'productDetail'])->name('product-detail');
Route::get('/cart/add/{id}', [App\Http\Controllers\Pagecontroller::class, 'addToCart'])->name('add-to-cart');
Route::get('/cart/show', [App\Http\Controllers\Pagecontroller::class, 'showCart'])->name('show-cart');
Route::post('/cart/update', [App\Http\Controllers\Pagecontroller::class, 'updateQuantity'])->name('update-cart');
Route::get('/checkout/delete-item/{id}', [App\Http\Controllers\Pagecontroller::class, 'removeItem'])->name('checkout.delete-item');
Route::get('/checkout', [App\Http\Controllers\Pagecontroller::class, 'checkout'])->name('checkout');
Route::post('/place-order', [App\Http\Controllers\Pagecontroller::class, 'placeOrder'])->name('place-order');
Route::get('/order-success/{orderNumber}', [App\Http\Controllers\Pagecontroller::class, 'orderSuccess'])->name('order-success');
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// if try register then redirect login
Route::get('/register', function () {
    return redirect()->to('/login');
});

Route::get('clear-session', function (Request $request) {
    $request->session()->flush();
});


Route::middleware(['web', 'auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.pages.dashboard.dashboard');
    })->name('dashboard');

    Route::name('product-control.')->group(function () {
        Route::resource('product', Productcontroller::class);
        Route::resource('product-videos', App\Http\Controllers\Admin\ProductVideoController::class);
        Route::post('product-image/delete', [ProductController::class, 'deleteImage'])->name('image.delete');
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
});
