<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReserveController;
use App\Http\Controllers\ReservationMailController;
use App\Http\Controllers\CreateDayController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\CreateNewsController;

// Home
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Reserve (client)

Route::get('/rijeka', [ReserveController::class, 'reserveRijeka'])->name('rijeka');
Route::get('/crikvenica', [ReserveController::class, 'reserveCrikvenica'])->name('crikvenica');
Route::post('/send-reservation', [ReservationMailController::class, 'send'])->name('reservation.send');



//CREATE DAY ADMIN
Route::get('/kreiraj', [CreateDayController::class, 'dayAdminView'])->name('kreiraj');

Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/day/create', [CreateDayController::class, 'dayAdminView'])->name('admin.day.create');
    Route::post('/day/store', [CreateDayController::class, 'store'])->name('admin.day.store');
    Route::get('/day/{id}/edit', [CreateDayController::class, 'edit'])->name('admin.day.edit');
    Route::put('/day/{id}/update', [CreateDayController::class, 'update'])->name('admin.day.update');
    Route::delete('/day/{id}/delete', [CreateDayController::class, 'delete'])->name('admin.day.delete');
});


// Depricated news view route

// Route::get('/novosti', [NewsController::class, 'newsView'])->name('news.view');


// News view(admin)

    Route::get('/admin/novosti', [CreateNewsController::class, 'createNewsView'])->name('admin.news.view');


// News CRUD admin

Route::middleware(['auth'])->group(function () {
    Route::post('/admin/novosti', [CreateNewsController::class, 'store'])->name('admin.news.store');
    Route::put('/admin/novosti/{id}', [CreateNewsController::class, 'update'])->name('admin.news.update');
    Route::delete('/admin/novosti/{id}', [CreateNewsController::class, 'destroy'])->name('admin.news.delete');
    Route::delete('/admin/novosti/{id}/image', [CreateNewsController::class, 'deleteImage'])->name('admin.news.deleteImage');


});





// Auth

Route::get('/register', [AuthController::class, 'register'])->name('register')->middleware('guest');
Route::get('/login', [AuthController::class, 'login'])->name('login')->middleware('guest');


Route::post('/register', [AuthController::class, 'store']);
Route::post('/login', [AuthController::class, 'authenticate']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
