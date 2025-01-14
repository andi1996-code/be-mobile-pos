<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('pages.auth.login');
});

// Route::middleware(['auth'])->group(function () {
//     Route::get('home', [\App\Http\Controllers\DashboardController::class, 'index'])->name('home');

//     // Route::get('dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
//     Route::resource('user', UserController::class);
//     Route::resource('product', \App\Http\Controllers\ProductController::class);
//     Route::resource('order', \App\Http\Controllers\OrderController::class);
//     //report
//     Route::get('report', [\App\Http\Controllers\ReportController::class, 'index'])->name('report.index');
//     Route::get('orders/filter', [\App\Http\Controllers\OrderController::class, 'filter'])->name('orders.filter');
// });

Route::middleware(['auth'])->group(function () {
    Route::get('home', [DashboardController::class, 'index'])->name('home');

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('user', UserController::class);
    Route::resource('product', ProductController::class);
    Route::resource('order', OrderController::class);

    // Report routes
    Route::get('report', [ReportController::class, 'index'])->name('report.index');
    Route::post('report/generate', [ReportController::class, 'generate'])->name('report.generate');

    // Order filter route
    Route::get('orders/filter', [OrderController::class, 'filter'])->name('orders.filter');
});
