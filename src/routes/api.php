<?php

use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\VehicleController;
use Illuminate\Support\Facades\Route;

Route::get('/vehicles', [VehicleController::class, 'index']);
Route::post('/bookings', [BookingController::class, 'store']);
