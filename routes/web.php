<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\TokenVerificationMiddleware;
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
    return view('welcome');
});
Route::post('/user-registration', [UserController::class, 'userRegistration']);
Route::post('/user-login', [UserController::class, 'userLogin']);
Route::post('/send-otp', [UserController::class, 'sentOTPCode']);
Route::post('/verify-otp', [UserController::class, 'verifyOTP']);

Route::post('/reset-password', [UserController::class, 'ResetPassword'])->middleware([TokenVerificationMiddleware::class]);

//Order
Route::post('/orders', [OrderController::class, 'store'])->middleware([TokenVerificationMiddleware::class]);


// services & packages
Route::get('/services', [ServiceController::class, 'index'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/packages', [PackageController::class, 'index'])->middleware([TokenVerificationMiddleware::class]);