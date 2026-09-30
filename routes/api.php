<?php
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/users', [UserController::class, 'get']);


Route::post('/users', [UserController::class, 'create']);

Route::post('/users/login', [UserController::class, 'login']);


Route::put('/users/username', [UserController::class, 'updateUsername']);
Route::put('/users/email', [UserController::class, 'updateEmail']);
Route::put('/users/password', [UserController::class, 'updatePassword']);
Route::delete('/users', [UserController::class, 'destroy']);