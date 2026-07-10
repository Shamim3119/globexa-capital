<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\RegistrationController;
use App\Http\Controllers\Api\ResetPasswordController;
use App\Http\Controllers\Api\ClientAccountController;
use App\Http\Controllers\Api\BankOperatorController;
use App\Http\Controllers\Api\BusinessAccountController;
use App\Http\Controllers\Api\WithdrawController;
use App\Http\Controllers\Api\InvestmentController;
use App\Http\Controllers\Api\DepositeCommissionController;

use App\Http\Controllers\Api\RefundController;
 
use App\Http\Controllers\Api\DepositController;
use App\Http\Controllers\Api\TeamController;
use App\Http\Controllers\Api\P2PController;
use App\Http\Controllers\Api\DashboardController;

use App\Http\Controllers\Api\UserProfile;


Route::post('/client-login', [LoginController::class, 'login']);

Route::post('/check-id', [ResetPasswordController::class, 'checkID']);
Route::post('/check-otp', [ResetPasswordController::class, 'checkOtp']);
Route::post('/reset', [ResetPasswordController::class, 'reset']);

Route::post('/check-ref', [RegistrationController::class, 'checkRef']);
Route::post('/registration', [RegistrationController::class, 'store']);
Route::post('/register', [RegistrationController::class, 'varifiy']);

Route::get('/get-profile', [UserProfile::class, 'getProfile']);
Route::post('/update-profile', [UserProfile::class, 'updateProfile']);


Route::get('/client-accounts', [ClientAccountController::class, 'index']);
Route::post('/client-accounts', [ClientAccountController::class, 'save']);


Route::get('/bank-operators', [BankOperatorController::class, 'index']);
Route::get('/business-accounts',[BusinessAccountController::class, 'index']);

Route::get('/deposits', [DepositController::class, 'index']);
Route::post('/deposits', [DepositController::class, 'save']);

 

Route::get('/p2p', [P2PController::class, 'index']);
Route::post('/p2p', [P2PController::class, 'save']);

Route::get('/investment', [InvestmentController::class, 'index']);
Route::post('/investment', [InvestmentController::class, 'save']);
Route::post('/investment/upgrade', [InvestmentController::class, 'upgrade']);


Route::get('/refund', [RefundController::class, 'index']);
Route::post('/refund', [RefundController::class, 'save']);


Route::get('/withdraw', [WithdrawController::class, 'index']);
Route::post('/withdraw', [WithdrawController::class, 'save']);
Route::post('/withdraw/send-otp',[WithdrawController::class,'sendOtp']);
 
Route::get('/team-summary', [TeamController::class, 'summary']);

Route::get('/deposite-commissions', [DepositeCommissionController::class, 'index']);

Route::get('/dashboard-summary', [DashboardController::class, 'dashboardSummary']);
Route::get('/income-breakdown', [DashboardController::class, 'incomeBreakdown']);
 

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