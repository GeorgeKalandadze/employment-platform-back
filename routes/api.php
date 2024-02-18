<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\CompanyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['middleware' => ['api', 'auth:api']], function () {
    Route::get('/user', [AuthController::class, 'user'])->name('user');

});

Route::controller(AuthController::class)->group(function () {
    Route::post('register', 'register')->name('register');
    Route::post('login', 'login')->name('login');
    Route::post('email/verify', 'verify')->name('verification.notice');
    Route::post('logout', 'logout')->name('logout');
});

Route::controller(PasswordResetController::class)->group(function () {
    Route::post('forgot-password', 'forgotPassword')->name('password.email');
    Route::post('reset-password', 'passwordUpdate')->name('password.reset');
});



Route::prefix('companies')->group(function () {
    Route::get('/', [CompanyController::class, 'index']);
    Route::get('/{company}', [CompanyController::class, 'show']);
    Route::post('/', [CompanyController::class, 'store']);
    Route::put('/{company}', [CompanyController::class, 'update']);
    Route::delete('/{company}', [CompanyController::class, 'destroy']);
    Route::get('/user', [CompanyController::class, 'userCompanies']);
});
