<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\CategoryController;

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

Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

Route::middleware(['auth'])->group(function () {
    Route::get('category', [CategoryController::class, 'index'])->name('category.index');
    Route::get('category/create', [CategoryController::class, 'create'])->name('category.create');
    Route::post('category', [CategoryController::class, 'store'])->name('category.store'); // Add this line
    Route::get('category/{id}/edit', [CategoryController::class, 'edit'])->name('category.edit');
    Route::put('category/{id}', [CategoryController::class, 'update'])->name('category.update');
    //category delete
    Route::delete('category/{category}', [CategoryController::class, 'destroy'])->name('category.destroy');
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
