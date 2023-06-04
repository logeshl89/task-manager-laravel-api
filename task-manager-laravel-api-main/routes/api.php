<?php

use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\v1\TaskController;
use App\Http\Controllers\Api\v1\UserController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->prefix('v1')->middleware('throttle:400,60')->group(function () {
    Route::post('/auth/login', 'login');
    Route::post('/auth/logout', 'logout')->middleware('auth:sanctum');
    Route::get('/profile', 'profile')->middleware('auth:sanctum');
});

Route::controller(UserController::class)->prefix('v1')->middleware('throttle:400,60')->group(function () {
    Route::post('/users', 'store');
    Route::get('/users/{id}', 'show')->middleware('auth:sanctum');
    Route::patch('/users/{id}', 'update')->middleware('auth:sanctum');
    Route::delete('/users/{id}', 'destroy')->middleware('auth:sanctum');
});

Route::controller(TaskController::class)->prefix('v1')->middleware(['auth:sanctum', 'throttle:400,60'])->group(function () {
    Route::post('/tasks', 'store');
    Route::get('/tasks/{id}', 'show');
    Route::patch('/tasks/{id}', 'update');
    Route::delete('/tasks/{id}', 'destroy');
});
