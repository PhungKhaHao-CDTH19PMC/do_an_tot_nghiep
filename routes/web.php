<?php

use Illuminate\Support\Facades\Route;
use App\http\controllers\DashboardController;
use App\http\controllers\HomeController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('guest')->group(function () {
    Route::get('/dang-nhap', [HomeController::class, 'login'])->name('login');
    Route::post('/dang-nhap', [HomeController::class, 'doLogin'])->name('do_login');
});
Route::middleware('auth')->group(function () {
    Route::get('/dang-xuat', [HomeController::class, 'logout'])->name('logout');
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
});