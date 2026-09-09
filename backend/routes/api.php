<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CalculatorController;
use App\Http\Controllers\Api\InsuranceTypeController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

// Публичные
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/calculator/quote', [CalculatorController::class, 'quote']);
Route::get('/insurance-types', [InsuranceTypeController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{user}', [UserController::class, 'show']);

    Route::middleware('role:admin')->get('/admin/ping', function () {
        return response()->json(['message' => 'ok, ты администратор']);
    });
});
