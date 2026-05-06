<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
Route::put('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');


Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
Route::get('/bookings/create', [BookingController::class, 'create'])->name('bookings.create');
Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
Route::delete('/bookings/{booking}', [BookingController::class, 'destroy'])->name('bookings.destroy');

Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/tables', [AdminController::class, 'tables'])->name('tables');
    Route::post('/tables', [AdminController::class, 'storeTable'])->name('tables.store');
    Route::put('/tables/{table}', [AdminController::class, 'updateTable'])->name('tables.update');
    Route::delete('/tables/{table}', [AdminController::class, 'deleteTable'])->name('tables.delete');
    
    Route::get('/menu', [AdminController::class, 'menu'])->name('menu');
    Route::post('/menu', [AdminController::class, 'storeMenuItem'])->name('menu.store');
    Route::put('/menu/{menuItem}', [AdminController::class, 'updateMenuItem'])->name('menu.update');
    Route::delete('/menu/{menuItem}', [AdminController::class, 'deleteMenuItem'])->name('menu.delete');
    
    Route::get('/bookings', [AdminController::class, 'allBookings'])->name('bookings');
    Route::put('/bookings/{booking}/status', [AdminController::class, 'updateBookingStatus'])->name('bookings.status');
});