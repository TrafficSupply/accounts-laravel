<?php

namespace TrafficSupply\AccountsLaravel\Routes;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use TrafficSupply\AccountsLaravel\Controllers\AccountsController;

Route::middleware('web')->group(function(){
    Route::middleware(['guest', 'noToken'])->group(function(){
        Route::view('/login', 'Accounts::login')->name('login');
        Route::get('/accounts-login', [AccountsController::class, 'login'])->name('accounts-login');
        Route::get('/callback', [AccountsController::class, 'callback'])->name('callback');
    });
    Route::middleware('token')->group(function(){
        Route::view('/home', 'Accounts::home')->name('home');
        Route::get('/logout', [AccountsController::class, 'logout'])->name('logout');
    });
});
