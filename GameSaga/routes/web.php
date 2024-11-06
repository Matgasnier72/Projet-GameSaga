<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

Route::get('/', function () {
    return view('welcome');
});
 Route::post('/authenticate',[LoginController::class, 'authenticate'])
    ->name('authenticate')
    /* ->middleware(['throttle:login', 'verified']) */;
 Route::get('/logout',[LoginController::class, 'logout'])
    ->name('logout')/* 
    ->middleware('auth') */;
 