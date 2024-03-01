<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\RateController;
use App\Http\Controllers\UserController;
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

    Route::post('/courses/{course}/rates', [RateController::class, 'store'])->name('store.rate');

    Route::get('/cities', [CityController::class, 'index'])->name('index');

    Route::controller(CourseController::class)->prefix('courses')->group(function () {
        Route::get('/user-courses', 'getUserCourses')->name('getUserCourses');
        Route::get('/', 'index')->name('index');
        Route::get('/{course}', 'show')->name('show');
        Route::post('/', 'storeCourseAsUser')->name('storeCourseAsUser');
        Route::post('/store-as-company', 'storeCourseAsCompany')->name('storeCourseAsCompany');
        Route::put('/{course}', 'update')->name('update');
        Route::delete('/{course}', 'destroy')->name('destroy');
    });

    Route::controller(CompanyController::class)->prefix('companies')->name('companies.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{company}', 'show')->name('show');
        Route::post('/', 'store')->name('store');
        Route::put('/{company}', 'update')->name('update');
        Route::delete('/{company}', 'destroy')->name('destroy');
        Route::get('/user', 'userCompanies')->name('userCompanies');
        Route::post('{company}/toggle-follow', 'toggleFollow');
    });

    Route::controller(VacancyController::class)->prefix('vacancies')->name('vacancies.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{vacancy}', 'show')->name('show');
        Route::post('/as-company', 'storeVacancyAsCompany')->name('AsCompany');
        Route::post('/as-user', 'storeVacancyAsUser')->name('AsUser');
        Route::post('/{id}/views', 'updateViews')->name('views');
        Route::put('/{vacancy}', 'update')->name('update');
        Route::delete('/{vacancy}', 'destroy')->name('destroy');
    });

    Route::controller(UserController::class)->group(function () {
        Route::put('user/update', 'update')->name('user.update');
        Route::post('user/add-email', 'addEmail')->name('email.add');
        Route::post('confirm-account/{user}', 'confirmEmail')->name('confirm-account');
    });

    Route::controller(FavoriteController::class)->group(function () {
        Route::post('/toggle-favorite-course/{course}', 'toggleFavoriteCourse');
        Route::post('/toggle-favorite-vacancy/{vacancy}', 'toggleFavoriteVacancy');
        Route::get('/all-favorites', 'allFavorites');
        Route::get('/all-favorite-courses', 'allFavoriteCourses');
        Route::get('/all-favorite-vacancies', 'allFavoriteVacancies');
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
