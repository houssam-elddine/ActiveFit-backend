<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CoachController;
use App\Http\Controllers\AbonnementController;
use App\Http\Controllers\DisciplineController;
use App\Http\Controllers\ReservationController;

Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout',[AuthController::class,'logout']);

    Route::middleware('role:admin')->group(function () {
        Route::apiResource('disciplines',DisciplineController::class);
        Route::apiResource('coaches',CoachController::class);
        Route::apiResource('abonnements',AbonnementController::class);

        Route::get('reservations',[ReservationController::class,'index']);
        Route::put('reservations/{id}/status',[ReservationController::class,'adminUpdate']);
    });

    Route::middleware('role:client')->group(function () {
        Route::post('reservations',[ReservationController::class,'store']);
        Route::get('my-reservations',[ReservationController::class,'myReservations']);
        Route::put('reservations/{id}/cancel',[ReservationController::class,'cancel']);
    });
});

Route::get('disciplines',[DisciplineController::class,'index']);
Route::get('abonnements/discipline/{id}',[AbonnementController::class,'byDiscipline']);
