<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\MasterController::class, 'dashboard'])->name('dashboard');
    Route::get('/dev', [\App\Http\Controllers\Admin\MasterController::class, 'dev'])->name('dev');

    Route::name('customer-control.')->group(function () {
        Route::resource('customers', \App\Http\Controllers\Admin\CustomerController::class);
    });

    Route::name('trip-control.')->group(function () {
        Route::resource('trips-category', \App\Http\Controllers\Admin\TripCategoryController::class);
        Route::resource('trips', \App\Http\Controllers\Admin\TripController::class);
        Route::resource('top-destinations', \App\Http\Controllers\Admin\TopDestinationController::class);
    });

    Route::name('hotel-control.')->group(function () {
        Route::resource('hotels', \App\Http\Controllers\Admin\HotelController::class);
        Route::resource('hotel-booking-enquiries', \App\Http\Controllers\Admin\HotelEnquiryController::class);
        Route::resource('hotel-contacts', \App\Http\Controllers\Admin\HotelContactController::class);
        Route::post('hotels/import', [\App\Http\Controllers\Admin\HotelController::class, 'import'])->name('hotels.import');
        Route::get('hotel/get-room-template', [\App\Http\Controllers\Admin\HotelController::class, 'roomTemplate'])->name('hotel.get-room-template');
        Route::get('google/login', [\App\Http\Controllers\GoogleController::class, 'redirectToGoogle'])->name('google.contact.login');
        Route::get('google/callback', [\App\Http\Controllers\GoogleController::class, 'handleGoogleCallback'])->name('contact');
    });

    Route::name('taxi-control.')->group(function () {
        Route::resource('taxi', \App\Http\Controllers\Admin\TaxiController::class);
        Route::resource('taxi-contacts', \App\Http\Controllers\Admin\TaxiContactController::class);
        Route::resource('taxi-bookings', \App\Http\Controllers\Admin\TaxiBookingController::class);
        Route::resource('taxi-enquiry', \App\Http\Controllers\Admin\TaxiEnquiryController::class);
        Route::get('taxi/get-taxi-vendors/{city_id}', [\App\Http\Controllers\Admin\TaxiEnquiryController::class, 'getTaxiContacts'])->name('get-taxi-vendors');
        Route::post('taxi/taxi-enquiries/delete', [\App\Http\Controllers\Admin\TaxiEnquiryController::class, 'deleteMultiple'])->name('taxi-enquiries.delete');
    });

    Route::name('tour-control.')->group(function () {
        Route::resource('tour-vendor', \App\Http\Controllers\Admin\TourVenodrController::class);
        Route::resource('tour-enquiry', \App\Http\Controllers\Admin\TourEnquiryController::class);
        Route::post('tour-vendor/delete/multiple', [\App\Http\Controllers\Admin\TourEnquiryController::class, 'deleteMultiple'])->name('tour-vendor.delete.multiple');
    });


    Route::name('booking-control.')->group(function () {
        Route::resource('booking', \App\Http\Controllers\Admin\BookingController::class);
    });

    Route::name('web.')->group(function () {
        Route::get('webmaster/edit', [\App\Http\Controllers\Admin\MasterController::class, 'editWebmaster'])->name('webmaster.edit');
        Route::post('webmaster/store', [\App\Http\Controllers\Admin\MasterController::class, 'storeWebmaster'])->name('webmaster.store');
    });


    Route::get('cities/{state_id}', [\App\Http\Controllers\Admin\TaxiContactController::class, 'getCities'])->name('get-cities');
    Route::get('get-hotels/{city_id}', [\App\Http\Controllers\Admin\HotelEnquiryController::class, 'getHotels'])->name('get-hotels');
    Route::get('get-hotel-contacts/{hotel_id}', [\App\Http\Controllers\Admin\HotelEnquiryController::class, 'getHotelContacts'])->name('get-hotel-contacts');

    Route::name('mail-control.')->group(function () {
        Route::resource('mails', \App\Http\Controllers\Admin\EmailController::class);
        Route::post('mails/delete/multiple', [\App\Http\Controllers\Admin\EmailController::class, 'deleteMultiple'])->name('mails.delete.multiple');
        Route::get('fetch-email/{id}', [\App\Http\Controllers\Admin\EmailController::class, 'fetchEmailById'])->name('fetch-email');
        Route::get('delete-email/{id}', [\App\Http\Controllers\Admin\EmailController::class, 'deletone'])->name('delete-email');
        Route::get('read-email/{id}', [\App\Http\Controllers\Admin\EmailController::class, 'markAsRead'])->name('read-email');
        Route::get('destroy-email/{id}', [\App\Http\Controllers\Admin\EmailController::class, 'destroy'])->name('destroy-email');
    });

    Route::name('web-message-control.')->group(function () {
        Route::resource('contact-us', \App\Http\Controllers\Admin\ContactUsController::class);
    });
});
