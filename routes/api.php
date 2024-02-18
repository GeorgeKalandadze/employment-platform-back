<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\VacancyController;
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

    Route::controller(CompanyController::class)->prefix('companies')->name('companies.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{company}', 'show')->name('show');
        Route::post('/', 'store')->name('store');
        Route::put('/{company}', 'update')->name('update');
        Route::delete('/{company}', 'destroy')->name('destroy');
        Route::get('/user', 'userCompanies')->name('userCompanies');
    });

    Route::controller(VacancyController::class)->prefix('vacancies')->name('vacancies.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{vacancy}', 'show')->name('show');
        Route::post('/as-company', 'storeVacancyAsCompany')->name('AsCompany');
        Route::post('/as-user', 'storeVacancyAsUser')->name('AsUser');
        Route::delete('/{vacancy}', 'delete')->name('delete');
    });

});

Route::controller(AuthController::class)->group(function () {
    Route::post('register', 'register')->name('register');
    Route::post('login', 'login')->name('login');
    Route::post('email/verify', 'verify')->name('verification.notice');
    Route::post('logout', 'logout')->name('logout');
});

Route::controller(PasswordResetController::class)->name('password.')->group(function () {
    Route::post('forgot-password', 'forgotPassword')->name('email');
    Route::post('reset-password', 'passwordUpdate')->name('reset');
});
