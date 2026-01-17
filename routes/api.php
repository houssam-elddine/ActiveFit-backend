<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\SubscriptionController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::post('/clients', [ClientController::class, 'store']);
    Route::get('/clients', [ClientController::class, 'index']);
    Route::delete('/clients/{id}', [ClientController::class, 'destroy']);
    Route::apiResource('/subscriptions', SubscriptionController::class);
}); 
Route::middleware(['auth:sanctum', 'role:client'])->group(function () {
    Route::post('/attendance/check-in', [AttendanceController::class, 'checkIn']);
    Route::post('/subscriptions/assign', [SubscriptionController::class, 'assign']);
});