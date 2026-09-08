<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // Policy-based: viewAny — только админ, view — свой профиль или админ
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{user}', [UserController::class, 'show']);

    // Middleware-based Gate-эквивалент (роль без привязки к записи)
    Route::middleware('role:admin')->get('/admin/ping', function () {
        return response()->json(['message' => 'ok, ты администратор']);
    });
});
