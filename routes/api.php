<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\VacancyController;
use App\Models\Company;
use App\Models\Vacancy;
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

    Route::post('/vacancies', [VacancyController::class, 'store'])->name('store');

    Route::controller(CompanyController::class)->prefix('companies')->name('companies.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{company}', 'show')->name('show');
        Route::post('/', 'store')->name('store');
        Route::put('/{company}', 'update')->name('update');
        Route::delete('/{company}', 'destroy')->name('destroy');
        Route::get('/user', 'userCompanies')->name('userCompanies');
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

// Route::get('/', function() {
//     $company = Company::find(10);
//     $vacancy = new Vacancy();
//     $vacancy->sub_category_id = 1;
//     $vacancy->title = 'title';
//     $vacancy->salary = 50000;
//     $vacancy->description = 'ddddddddddddddd';
//     $vacancy->job_type_id = 1;
//     $vacancy->experience_years = 3;
//     $company->vacancies()->save($vacancy);

//     $user = Company::find(1);
//     $vacancy = new Vacancy();
//     $vacancy->sub_category_id = 1;
//     $vacancy->title = 'title';
//     $vacancy->salary = 50000;
//     $vacancy->description = 'ddddddddddddddd';
//     $vacancy->job_type_id = 1;
//     $vacancy->experience_years = 3;
//     $user->vacancies()->save($vacancy);
// });
