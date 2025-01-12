<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::middleware(['auth'])->group(function () {
    Route::get('home', [\App\Http\Controllers\DashboardController::class, 'index'])->name('home');

    // Route::get('dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('user', UserController::class);
    Route::resource('product', \App\Http\Controllers\ProductController::class);
    Route::resource('order', \App\Http\Controllers\OrderController::class);
    Route::get('reports/daily', [\App\Http\Controllers\OrderController::class, 'dailyReport'])->name('reports.daily');
    Route::get('reports/monthly', [\App\Http\Controllers\OrderController::class, 'monthlyReport'])->name('reports.monthly');
    Route::get('reports', function () {
        return view('pages.report.index');
    })->name('report.index');
    Route::get('orders/filter', [\App\Http\Controllers\OrderController::class, 'filterByDate'])->name('orders.filter');
});
