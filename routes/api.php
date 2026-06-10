<?php

use App\Http\Controllers\Api\AuthController;

Route::get('/user', [AuthController::class, 'user'])->name('user');

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/profile', [AuthController::class, 'profile']);

});