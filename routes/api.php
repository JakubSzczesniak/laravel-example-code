<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/users/{user}', \App\Http\Controllers\User\ShowUserController::class)->middleware(['auth:sanctum']);
Route::post('/users', \App\Http\Controllers\User\StoreUserController::class);

Route::post('/bookings', \App\Http\Controllers\Booking\StoreBookingController::class)->middleware(['auth:sanctum']);
Route::get('/bookings', \App\Http\Controllers\Booking\IndexBookingController::class)->middleware(['auth:sanctum']);
Route::get('/bookings/{booking}', \App\Http\Controllers\Booking\ShowBookingController::class)->middleware(['auth:sanctum']);
Route::post('/bookings/{booking}/cancel', \App\Http\Controllers\Booking\CancelBookingController::class)->middleware(['auth:sanctum']);
Route::post('/bookings/calculate', \App\Http\Controllers\Booking\CalculateBookingController::class);

Route::post('login', \App\Http\Controllers\User\LoginUserController::class)->name('login');
