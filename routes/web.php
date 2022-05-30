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
Route::get('/forgot-password', [HomeController::class, 'forgotPassword'])->name('forgot_password');
Route::post('/send-token-forgot-password', [HomeController::class, 'sendTokenForgotPassword'])->name('send_token_forgot_password');
Route::get('/update-new-password',[HomeController::class, 'updateNewPassword'])->name('update-new-password');
Route::post('/reset-new-password',[HomeController::class, 'resetNewPassword'])->name('reset-new-password');

Route::middleware('guest')->group(function () {
    Route::get('/login', [HomeController::class, 'login'])->name('login');
    Route::post('/login', [HomeController::class, 'doLogin'])->name('do_login');
});
Route::middleware('auth')->group(function () {
    Route::get('/logout', [HomeController::class, 'logout'])->name('logout');
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
});

Route::get('auth/redirect/{provider}', [HomeController::class, 'redirect']);
Route::get('callback/{provider}', [HomeController::class, 'callback']);

Route::prefix('hop-dong')->group(function() {
    Route::name('contract.')->group(function() {
        Route::get('/', [DashboardController::class, 'index'])->name('list');
        Route::get('/them-moi', [DashboardController::class, 'create'])->name('create');
        Route::post('/them-moi', [DashboardController::class, 'store'])->name('store');
        Route::get('/cap-nhat/{id}', [DashboardController::class, 'edit'])->name('edit');
        Route::post('/cap-nhat', [DashboardController::class, 'update'])->name('update');
        Route::post('/xoa', [DashboardController::class, 'destroy'])->name('destroy');
        Route::get('/load-ajax-ds-contract', [DashboardController::class, 'loadAjax'])->name('load_ajax_contract');
    }); 
});
