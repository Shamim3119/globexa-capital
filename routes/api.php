<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\RegistrationController;
use App\Http\Controllers\Api\ResetPasswordController;

Route::post('/client-login', [LoginController::class, 'login']);

Route::post('/check-id', [ResetPasswordController::class, 'checkID']);
Route::post('/check-otp', [ResetPasswordController::class, 'checkOtp']);
Route::post('/reset', [ResetPasswordController::class, 'reset']);

Route::post('/check-ref', [RegistrationController::class, 'checkRef']);
Route::post('/registration', [RegistrationController::class, 'store']);
Route::post('/register', [RegistrationController::class, 'varifiy']);

/*
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;   
//use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RegistrationController;

use App\Http\Controllers\Api\LoginController;
// use App\Http\Controllers\Api\ResetPasswordController;


 
Route::post('/client-login', [LoginController::class, 'login'])
    ->name('client-login');

Route::post('/check-ref', [RegistrationController::class, 'checkRef'])
    ->name('check-ref');

Route::post('registration', [RegistrationController::class, 'store'])
    ->name('registration');
    
 

Route::post('register', [RegistrationController::class, 'varifiy'])
    ->name('register');
    
//Route::post('/register', [RegistrationController::class, 'store']);


/*
Route::get('/user', [AuthController::class, 'user'])->name('user');

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/profile', [AuthController::class, 'profile']);

});
*/