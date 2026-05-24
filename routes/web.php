<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\EventController as EventAdminController;

// Route User Area
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/event', [EventController::class, 'show'])->name('events.show');
Route::get('/checkout', [EventController::class, 'checkout'])->name('checkout');
Route::post('/checkout', [EventController::class, 'processCheckout'])->name('checkout.process');
Route::get('/my-ticket', [EventController::class, 'ticket'])->name('ticket');

// Route Admin Area

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('events', EventAdminController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('partners', \App\Http\Controllers\Admin\PartnerController::class);
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('events', EventAdminController::class);
});

// Route admin/trancation/index
Route::get('/admin/transactions', function () {
    return view('admin.transactions.index');
})->name('admin.transactions.index');



