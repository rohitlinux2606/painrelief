<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Admin\Productcontroller;

// Route::get('/', function () {
//     return redirect()->to('/index.html');
// });
Route::view('/', 'index');
// Route::get('/{any}', function () {
//     return redirect()->to('/index.html');
// })->where('any', '.*');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::middleware(['web', 'auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.pages.dashboard.dashboard');
    })->name('dashboard');

    Route::name('product-control.')->group(function () {
        Route::resource('product', Productcontroller::class);
        Route::post('product-image/delete', [ProductController::class, 'deleteImage'])->name('image.delete');
    });
});
