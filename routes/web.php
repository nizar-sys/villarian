<?php

use App\Http\Controllers\Admin\BookingCrudController;
use App\Http\Controllers\Admin\DataTableController;
use App\Http\Controllers\Admin\VillaCrudController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Frontend\FrontEndController;
use App\Http\Controllers\GlobalSearchController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

# ------ Front routes ------ #
Route::get('/', [FrontEndController::class, 'index']);
Route::get('/villa/{id}', [FrontEndController::class, 'villaDetail'])->name('villa.detail');

# ------ Home routes ------ #
Route::name('api.')->prefix('api')->group(function () {
    Route::get('/villa', [DataTableController::class, 'dataVilla'])->name('data.villa');
});

# ------ Login Sociallite routes ------ #
Route::name('login.socialite.')->group(function () {
    Route::get('/{provider}/login', [LoginController::class, 'redirect'])->name('redirect');
    Route::get('/{provider}/callback', [LoginController::class, 'callback'])->name('callback');
});

# ------ Unauthenticated routes ------ #
Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('login.store');

# ------ Authenticated routes ------ #

Route::middleware(['auth'])->group(function () {

    # ------ User routes ------ #
        Route::name('booking.')->prefix('booking')->group(function () {

            Route::get('/villa/{id}', [BookingController::class, 'bookingVilla'])->name('villa');
            Route::post('/villa/{id}/sewa', [BookingController::class, 'bookingStoreVilla'])->name('villa.post');
            Route::delete('/villa/{bookingId}/batal', [BookingController::class, 'bookingDestroyVilla'])->name('villa.batal');
            Route::get('/list', [BookingController::class, 'listBookingVilla'])->name('list');

            Route::get('/data', [DataTableController::class, 'dataBookingVilla'])->name('data');

            Route::put('/bayar', [BookingController::class, 'bayarBooking'])->name('bayar');
        });

    # ------ Admin routes ------ #
        Route::middleware('role:admin')->group(function () {
            Route::get('/home', [HomeController::class, 'index'])->name('home');
            Route::post('/ckeditor/upload', [HomeController::class, 'uploadCkEditor'])->name('ckeditor.upload');


            # ------ Profile routes ------ #
            Route::prefix('profile')->group(function () {
                Route::get('/', [ProfileController::class, 'index'])->name('profile');
                Route::name('profile.')->group(function () {
                    Route::put('/change-ava', [ProfileController::class, 'changeAva'])->name('change-ava');
                    Route::put('/change-info', [ProfileController::class, 'changeInformation'])->name('change-info');
                    Route::put('/change-password', [ProfileController::class, 'changePassword'])->name('change-password');
                });
            });

            # ------ Verification email ------- #
            Route::prefix('email')->group(function () {
                Route::post('/verification-notification', [ProfileController::class, 'sendVerifyEmail'])->name('verification.send');
                Route::get('/verify/{id}/{hash}', [ProfileController::class, 'verifyEmail'])->name('verification.verify');
            });

            # ------- Data routes ------ #
            Route::name('datatable.')->prefix('data')->group(function () {
                Route::get('/villa', [DataTableController::class, 'dataVilla'])->name('villa');
            });


            # ------ Villa CRUD Routes ------ #
            Route::resource('villas', VillaCrudController::class);

            # ------ Booking CRUD Routes ------ #
            Route::resource('bookings', BookingCrudController::class);
        });
    
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
});

Route::get('search', [GlobalSearchController::class, 'search'])->name('search');

