<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Auth\Login;
use App\Livewire\Dashboard\Dashboard;
use App\Livewire\Parameter\ParameterCrud;

use App\Livewire\Settings\BusinessCrud;
use App\Livewire\Settings\ProfileCrud;

use App\Livewire\Clients\ClientsCrud;

use App\Livewire\Settings\GlobalSettingsCrud;
use App\Livewire\Settings\GenerationCommissionCrud;
use App\Livewire\Settings\DepositeCommissionCrud;



Route::get('/', function () {
    return view('home');
});





Route::get('/portal', Login::class)->name('login');

Route::middleware(['auth'])->group(function () {

Route::get('/dashboard', Dashboard::class)->name('dashboard');
Route::get('/profile', ProfileCrud::class)->name('profile.index');
Route::get('/bussiness', BusinessCrud::class)->name('bussiness.index');
 
Route::get('/global-settings', GlobalSettingsCrud::class)->name('global-settings.index');
Route::get('/generation-commission', GenerationCommissionCrud::class)->name('generation-commission.index');
Route::get('/deposite-commission', DepositeCommissionCrud::class)->name('deposite-commission.index');
 
Route::get('/clients', ClientsCrud::class)->name('clients.index');


   // Route::get('/parameter', ParameterCrud::class)->name('parameter.index');



    Route::post('/logout', function () {
        auth()->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/');
    })->name('logout');
    

}); 
