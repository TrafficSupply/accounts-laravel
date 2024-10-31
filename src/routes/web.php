<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use TrafficSupply\TSAccountsLaravelPackage\Controllers\TSAccountsController;

Route::middleware('web')->group(function(){
    Route::middleware(['guest', 'noToken'])->group(function(){
        Route::view('/login', 'TSAccounts::login')->name('login');
        Route::get('/tsaccounts-login', [TSAccountsController::class, 'login'])->name('tsaccounts-login');
        Route::get('/callback', [TSAccountsController::class, 'callback'])->name('callback');
    });
    Route::middleware('token')->group(function(){
        Route::view('/home', 'TSAccounts::home')->name('home');
        Route::get('/logout', [TSAccountsController::class, 'logout'])->name('logout');
    });
});
