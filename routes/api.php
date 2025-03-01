<?php

use App\Http\Controllers\PackageController;
use App\Http\Controllers\ServiceController;
use App\Http\Middleware\TokenVerificationMiddleware;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/services', [ServiceController::class, 'index'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/packages', [PackageController::class, 'index'])->middleware([TokenVerificationMiddleware::class]);
