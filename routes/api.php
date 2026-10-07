<?php
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Rutas públicas
Route::get('/users', [AuthController::class, 'getUsers']);
Route::post('/users/register', [AuthController::class, 'register']);
Route::post('/users/login', [AuthController::class, 'login']);

// Rutas protegidas por Token (Sanctum)
Route::middleware('auth:sanctum')->group(function () {
    Route::put('/user/name', [AuthController::class, 'updateName']);
});