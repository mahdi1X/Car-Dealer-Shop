<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CarsController;
use App\Http\Controllers\MyPageController;
use App\Http\Controllers\PolicyController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BrandsController;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\RecommendedController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AdminReportController;
use App\Http\Controllers\UserBanController;


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
    Route::get('/admin/analytics', [AdminDashboardController::class, 'show'])->name('analytics.index');

    Route::get('/cars/create', [CarsController::class, 'showCreateForm'])->name('cars.create');
    Route::get('/cars/{car}/edit', [CarsController::class, 'edit'])->name('cars.edit');
    Route::post('/cars', action: [CarsController::class, 'create'])->name('cars.store');
    Route::put('cars/{id}', [CarsController::class, 'update'])->name('cars.update');
    Route::delete('cars/{id}', [CarsController::class, 'destroy'])->name('cars.destroy');
    // Route::get('', [CarsController::class, 'destroy'])->name('cars.destroy');
    Route::middleware('auth')->post('/like-toggle', [LikeController::class, 'toggle'])->name('like.toggle');
    Route::get('/my-liked-cars', [CarsController::class, 'myLikedCars'])->middleware('auth')->name('cars.liked');


    Route::get('/reservations/{car}', [ReservationController::class, 'create'])->name('reservations.create');
    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
    Route::get('/reservation/{reservation}', [ReservationController::class, 'show'])->name('reservations.show');
    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::post('/reservations/{reservation}/cancel', [ReservationController::class, 'cancelReservation'])->name('reservations.cancel');
    Route::get('/my-reservations/calendar', [ReservationController::class, 'calendar'])->name('reservations.calendar');
    Route::get('/reservations/events', [ReservationController::class, 'calendarEvents'])->name('reservations.events');


    // Route::post(uri: '/reservations/{reservation}/complete', [ReservationController::class, 'cancelReservation'])->name('reservations.completed');
    Route::post('/reservations/{reservation}/complete', [ReservationController::class, 'completeReservation'])->name('reservations.complete');
    Route::get('/reservations/{reservation}/view', [ReservationController::class, 'view'])->name('reservations.view');




});
Route::get('/users/{user}/report', [ReportController::class, 'create'])->name('user-reports.create');
Route::post('/user-reports', [ReportController::class, 'store'])->name('user-reports.store');
Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
Route::get('/reports/{id}', [ReportController::class, 'show'])->name('reports.show');
Route::post('/admin-reports/submit/{report}', [AdminReportController::class, 'store'])->name('admin-reports.store');
Route::get('/admin-reports/{id}', [AdminReportController::class, 'show'])->name('admin-reports.show');
Route::post('/users/{user}/ban', [UserBanController::class, 'ban'])->name('users.ban');
Route::post('/users/{user}/unban', [UserBanController::class, 'unban'])->name('users.unban');




Route::get('/users', [UserController::class, 'index'])->name('users.index');

Route::get('/user/{id}/profile', [UserController::class, 'showProfile'])->name('user.profile');
Route::put('/user/{id}/profile', [UserController::class, 'updateProfile'])->name('user.update');
Route::get('/brands/{brand}', action: [BrandsController::class, 'show'])->name('brands.show');
Route::put('/brands/{id}', [BrandsController::class, 'update'])->name('brands.update');
Route::get('/brands/{brand}/edit', [BrandsController::class, 'edit'])->name('brands.edit');


Route::get('/cars/{car}', [CarsController::class, 'show'])->name('cars.show');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
?>