<?php

use App\Http\Controllers\CarsController;
use App\Http\Controllers\MyPageController;
use App\Http\Controllers\PolicyController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BrandsController;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\RecommendedController;
use App\Http\Controllers\AdminUserController;

Route::get('/', [CommonController::class, 'index']);

Route::get('/cars', [CarsController::class, 'index'])->name('cars.index');


Route::get('/brands', action: [BrandsController::class, 'index'])->name('brands.index');

Route::get('/recommended-cars', [RecommendedController::class, 'recommended'])->name('recommended.cars');
Route::get('/policy', [PolicyController::class, 'index'])->name('policy');


Route::middleware(['auth'])->group(function () {

    Route::get('/mypage', [MyPageController::class, 'index'])->name('mypage');

    Route::resource('admin_users', AdminUserController::class)->except(['show']);


    Route::get('/brands/create', [BrandsController::class, 'create'])->name('brands.create');
    Route::post('/brands', [BrandsController::class, 'store'])->name('brands.store');

    Route::get('/cars/create', [CarsController::class, 'showCreateForm'])->name('cars.create');
    Route::get('/cars/{car}/edit', [CarsController::class, 'edit'])->name('cars.edit');
    Route::post('/cars', action: [CarsController::class, 'create'])->name('cars.store');
    Route::put('cars/{id}', [CarsController::class, 'update'])->name('cars.update');
    Route::delete('cars/{id}', [CarsController::class, 'destroy'])->name('cars.destroy');
    // Route::get('', [CarsController::class, 'destroy'])->name('cars.destroy');

    Route::get('/reservations/{car}', [ReservationController::class, 'create'])->name('reservations.create');
    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
    Route::get('/reservation/{reservation}', [ReservationController::class, 'show'])->name('reservations.show');
    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::post('/reservations/{reservation}/cancel', [ReservationController::class, 'cancelReservation'])->name('reservations.cancel');
    // Route::post(uri: '/reservations/{reservation}/complete', [ReservationController::class, 'cancelReservation'])->name('reservations.completed');
    Route::post('/reservations/{reservation}/complete', [ReservationController::class, 'completeReservation'])->name('reservations.complete');
});

Route::get('/brands/{brand}', action: [BrandsController::class, 'show'])->name('brands.show');

Route::get('/cars/{car}', [CarsController::class, 'show'])->name('cars.show');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
?>