<?php

use App\Http\Controllers\AuthController;
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
    
Route::controller(AuthController::class)->group(function() {
    Route::post('register', 'register')->name('register');
    Route::post('login', 'login')->name('login');
    Route::post('email/verify', 'verify')->name('verification.notice');
	Route::post('logout', 'logout')->name('logout');
});
