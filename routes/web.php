<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JagungController;
use App\Http\Controllers\KecamatanController;
use App\Http\Controllers\PrediksiController;
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
    return redirect('/dashboard');
});

Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'index')->name('login')->middleware('guest');
    Route::post('/login', 'login');
    Route::post('/logout', 'logout');
});

Route::prefix('/dashboard')->middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('/user', UserController::class);
    Route::resource('/kecamatan', KecamatanController::class);
    Route::resource('/produksi', JagungController::class);
    Route::resource('/prediksi', PrediksiController::class);
    Route::put('/resetpassword/{user}', [UserController::class, 'resetPasswordAdmin'])->name('resetpassword.resetPasswordAdmin');
});
