<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\FavoriteController;
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
    Route::prefix('courses')->group(function () {
        Route::get('/user-courses', [CourseController::class, 'getUserCourses']);
        Route::get('/', [CourseController::class, 'index']);
        Route::get('/{course}', [CourseController::class, 'show']);
        Route::post('/', [CourseController::class, 'storeCourseAsUser']);
        Route::post('/store-as-company', [CourseController::class, 'storeCourseAsCompany']);
        Route::put('/{course}', [CourseController::class, 'update']);
        Route::delete('/{course}', [CourseController::class, 'destroy']);
    });

    Route::post('/toggle-favorite-course/{course}', [FavoriteController::class, 'toggleFavoriteCourse']);
    Route::post('/toggle-favorite-vacancy/{vacancy}', [FavoriteController::class, 'toggleFavoriteVacancy']);
    Route::get('/all-favorites', [FavoriteController::class, 'allFavorites']);
    Route::get('/all-favorite-courses', [FavoriteController::class, 'allFavoriteCourses']);
    Route::get('/all-favorite-vacancies', [FavoriteController::class, 'allFavoriteVacancies']);
});

Route::controller(AuthController::class)->group(function () {
    Route::post('register', 'register')->name('register');
    Route::post('login', 'login')->name('login');
    Route::post('email/verify', 'verify')->name('verification.notice');
    Route::post('logout', 'logout')->name('logout');

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
        Route::put('/{vacancy}', 'update')->name('update');
        Route::delete('/{vacancy}', 'destroy')->name('destroy');
    });

});

Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register')->name('register');
    Route::post('/login', 'login')->name('login');
    Route::post('/email/verify', 'verify')->name('verification.notice');
    Route::post('/logout', 'logout')->name('logout');
});

Route::controller(PasswordResetController::class)->name('password.')->group(function () {
    Route::post('/forgot-password', 'forgotPassword')->name('email');
    Route::post('/reset-password', 'passwordUpdate')->name('reset');
});
