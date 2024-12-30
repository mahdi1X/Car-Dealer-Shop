<?php

use App\Http\Controllers\CarsController;
use Illuminate\Support\Facades\Route;
use Illuminate\Container\Attributes\Auth;
use App\Http\Controllers\BrandsController;
use App\Http\Controllers\CommonController;


Route::get('/', [CommonController::class, 'index']);

// function () {
//     return view('welcome');
// });

Route::get('cars', [CarsController::class, 'index'])->name('cars.index');
Route::get('/cars/create', [CarsController::class, 'showCreateForm'])->name('cars.create');
Route::post('/cars', [CarsController::class, 'create'])->name('cars.store');


Route::get('/brands/create', [BrandsController::class, 'create'])->name('brands.create');
Route::post('/brands', [BrandsController::class, 'store'])->name('brands.store');
// Auth::routes();

// Route::au
