<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'profile']);
});

Route::post('/menu', [MenuController::class, 'create']);
Route::get('/menu', [MenuController::class, 'getAll']);
Route::get('/menu/{id}', [MenuController::class, 'getById']);
Route::patch('/menu/{id}', [MenuController::class, 'update']);
Route::delete('/menu/{id}', [MenuController::class, 'delete']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/order', [OrderController::class, 'create']);
    Route::get('/order', [OrderController::class, 'getAllByUserId']);
    Route::get('/order/{id}', [OrderController::class, 'getById']);
    Route::patch('/order/{id}', [OrderController::class, 'update']);
    Route::delete('/order/{id}', [OrderController::class, 'delete']);
});
