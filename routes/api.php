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
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\TransferController;
use App\Http\Controllers\Api\IncomeController;
use App\Http\Controllers\Api\DepositController;
use App\Http\Controllers\Api\TeamController;
use App\Http\Controllers\Api\P2PController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\UserProfile;
use App\Http\Controllers\Api\ClientNetworkController;
use App\Http\Controllers\Api\VerificationController;
use App\Http\Controllers\Api\ParameterController;




/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

 
Route::post(
    '/verify-login-device',
    [LoginController::class, 'verifyDevice']
);

Route::post(
    '/client-login',
    [LoginController::class, 'login']
);

Route::post(
    '/check-id',
    [ResetPasswordController::class, 'checkID']
);

Route::post(
    '/check-otp',
    [ResetPasswordController::class, 'checkOtp']
);

Route::post(
    '/reset',
    [ResetPasswordController::class, 'reset']
);

Route::post(
    '/check-ref',
    [RegistrationController::class, 'checkRef']
);

Route::post(
    '/registration',
    [RegistrationController::class, 'store']
);

Route::post(
    '/register',
    [RegistrationController::class, 'varifiy']
);


/*
|--------------------------------------------------------------------------
| AUTHENTICATED CLIENT ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {


    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/get-profile',
        [UserProfile::class, 'getProfile']
    );

    Route::post(
        '/update-profile',
        [UserProfile::class, 'updateProfile']
    );


    /*
    |--------------------------------------------------------------------------
    | Verification
    |--------------------------------------------------------------------------
    */

    Route::prefix('verification')->group(function () {

        Route::get(
            '/{clientId}',
            [VerificationController::class, 'show']
        );

        Route::put(
            '/{clientId}/step-1',
            [VerificationController::class, 'updateStep1']
        );

        Route::put(
            '/{clientId}/step-2',
            [VerificationController::class, 'updateStep2']
        );

        Route::post(
            '/{clientId}/step-3',
            [VerificationController::class, 'updateStep3']
        );

    });


    /*
    |--------------------------------------------------------------------------
    | Network
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/client/{id}/network-investments',
        [ClientNetworkController::class, 'getNetworkInvestmentBalances']
    );


    /*
    |--------------------------------------------------------------------------
    | Accounts
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/client-accounts',
        [ClientAccountController::class, 'index']
    );

    Route::post(
        '/client-accounts',
        [ClientAccountController::class, 'save']
    );


    /*
    |--------------------------------------------------------------------------
    | Operators / Business
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/bank-operators',
        [BankOperatorController::class, 'index']
    );

    Route::get(
        '/business-accounts',
        [BusinessAccountController::class, 'index']
    );

    Route::get(
        '/business-doc',
        [BusinessAccountController::class, 'pdf_doc']
    );


    /*
    |--------------------------------------------------------------------------
    | Deposits
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/deposits',
        [DepositController::class, 'index']
    );

    Route::post(
        '/deposits',
        [DepositController::class, 'save']
    );


    /*
    |--------------------------------------------------------------------------
    | Transfers
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/transfer',
        [TransferController::class, 'index']
    );

    Route::post(
        '/transfer',
        [TransferController::class, 'store']
    );


    /*
    |--------------------------------------------------------------------------
    | Client
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/client',
        [ClientController::class, 'show']
    );


    /*
    |--------------------------------------------------------------------------
    | P2P
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/p2p',
        [P2PController::class, 'index']
    );

    Route::post(
        '/p2p',
        [P2PController::class, 'save']
    );


    /*
    |--------------------------------------------------------------------------
    | Investment
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/investment',
        [InvestmentController::class, 'index']
    );

    Route::post(
        '/investment',
        [InvestmentController::class, 'save']
    );

    Route::post(
        '/investment/upgrade',
        [InvestmentController::class, 'upgrade']
    );


    /*
    |--------------------------------------------------------------------------
    | Refund
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/refund',
        [RefundController::class, 'index']
    );

    Route::post(
        '/refund',
        [RefundController::class, 'save']
    );


    /*
    |--------------------------------------------------------------------------
    | Withdraw
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/withdraw',
        [WithdrawController::class, 'index']
    );

    Route::post(
        '/withdraw',
        [WithdrawController::class, 'save']
    );

    Route::post(
        '/withdraw/send-otp',
        [WithdrawController::class, 'sendOtp']
    );


    /*
    |--------------------------------------------------------------------------
    | Team
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/team-summary',
        [TeamController::class, 'summary']
    );


    /*
    |--------------------------------------------------------------------------
    | Commission
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/deposite-commissions',
        [DepositeCommissionController::class, 'index']
    );


    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/dashboard-summary',
        [DashboardController::class, 'dashboardSummary']
    );

    Route::get(
        '/income-breakdown',
        [DashboardController::class, 'incomeBreakdown']
    );


    /*
    |--------------------------------------------------------------------------
    | Income
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/incomes',
        [IncomeController::class, 'index']
    );

    /*
    |--------------------------------------------------------------------------
    | Income
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/parameters',
        [ParameterController::class, 'index']
    );

});