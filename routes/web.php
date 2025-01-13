<?php

use App\Http\Controllers\CarsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BrandsController;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\ReservationController;

Route::get('/', [CommonController::class, 'index']);

Route::get('/cars', [CarsController::class, 'index'])->name('cars.index');
Route::get('/cars/create', [CarsController::class, 'showCreateForm'])->name('cars.create');
Route::post('/cars', [CarsController::class, 'create'])->name('cars.store');


Route::get('/brands/create', [BrandsController::class, 'create'])->name('brands.create');
Route::post('/brands', [BrandsController::class, 'store'])->name('brands.store');
Route::get('/brands/{brand}', action: [BrandsController::class, 'show'])->name('brands.show');

Route::get('/cars/{car}', [CarsController::class, 'show'])->name('cars.show');

Route::middleware(['auth'])->group(function () {
    Route::get('/reservations/{car}', [ReservationController::class, 'create'])->name('reservations.create');
    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
    Route::get('/reservation/{reservation}', [ReservationController::class, 'show'])->name('reservations.show');
    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::post('/reservations/{reservation}/cancel', [ReservationController::class, 'cancelReservation'])->name('reservations.cancel');
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
?>