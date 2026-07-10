<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Auth\Login;
use App\Livewire\Dashboard\Dashboard;
use App\Livewire\Parameter\ParameterCrud;
use App\Livewire\Parameter\BankOperatorCrud;
use App\Livewire\Parameter\WalletTypeCrud;
use App\Livewire\Parameter\WalletTransferCrud;


use App\Livewire\Settings\BusinessCrud;
use App\Livewire\Settings\ProfileCrud;
use App\Livewire\Settings\ChangePasswordCrud;

use App\Livewire\Clients\ClientsCrud;

use App\Livewire\Settings\GlobalSettingsCrud;
use App\Livewire\Settings\GenerationCommissionCrud;
use App\Livewire\Settings\DepositeCommissionCrud;
use App\Livewire\Settings\InvestmentChargeCrud;
use App\Livewire\Refund\RefundCrud;



use App\Livewire\Income\IncomeDailyCrud;
use App\Livewire\Income\IncomeGenerationCrud;
use App\Livewire\Income\IncomeReferenceCrud;
use App\Livewire\Income\IncomeSalaryCrud;
use App\Livewire\Income\IncomeIBCrud;

 
use App\Livewire\Settings\RateCrud;
use App\Livewire\Settings\SalarySlotCrud;

use App\Livewire\Deposit\DepositCrud;
use App\Livewire\Withdraw\WithdrawCrud;

 

Route::get('/', function () {
    return view('home');
});



Route::get('/portal', Login::class)->name('login');

Route::middleware(['auth'])->group(function () {
    

    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    Route::get('/profile', ProfileCrud::class)->name('profile.index');
    Route::get('/change-password', ChangePasswordCrud::class)->name('change-password.index');



    Route::get('/bussiness', BusinessCrud::class)->name('bussiness.index');

    Route::get('/parameter', ParameterCrud::class)->name('parameter.index');
    Route::get('/bank-operator', BankOperatorCrud::class)->name('bank-operator.index');
    Route::get('/wallet-type', WalletTypeCrud::class)->name('wallet-type.index');
    Route::get('/wallet-transfer', WalletTransferCrud::class)->name('wallet-transfer.index');



    Route::get('/rate', RateCrud::class)->name('rate.index');
    Route::get('/global-settings', GlobalSettingsCrud::class)->name('global-settings.index');

    Route::get('/salary-slot', SalarySlotCrud::class)->name('salary-slot.index');


    Route::get('/generation-commission', GenerationCommissionCrud::class)->name('generation-commission.index');
    Route::get('/investment-commission', DepositeCommissionCrud::class)->name('deposite-commission.index');
    Route::get('/investment-charge', InvestmentChargeCrud::class)->name('investment-charge.index');
    
    Route::get('/clients', ClientsCrud::class)->name('clients.index');
    Route::get('/deposit', DepositCrud::class)->name('deposit.index');
    Route::get('/withdraw', WithdrawCrud::class)->name('withdraw.index');
    Route::get('/refund', RefundCrud::class)->name('refund.index');

 


    Route::get('/reference', IncomeReferenceCrud::class)->name('reference.index');
    Route::get('/daily', IncomeDailyCrud::class)->name('daily.index');
    Route::get('/generation', IncomeGenerationCrud::class)->name('generation.index');
    Route::get('/salary', IncomeSalaryCrud::class)->name('salary.index');
    Route::get('/ib', IncomeIBCrud::class)->name('ib.index');

 
   // Route::get('/parameter', ParameterCrud::class)->name('parameter.index');



    Route::post('/logout', function () {
        auth()->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/');
    })->name('logout');
    

}); 
