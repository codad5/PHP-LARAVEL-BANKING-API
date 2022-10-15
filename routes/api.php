<?php

use App\Http\Controllers\AccountController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;



Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/login', [AuthController::class, 'login']);

//secured route
//This route is secured by the auth middleware
Route::middleware('auth:sanctum')->group(function(){
    Route::post('/account/balance', [AccountController::class, 'balance']);
    Route::post('/account/transfer', [AccountController::class, 'transfer']);
    Route::post('/account/transactions', [AccountController::class, 'transactions']);
    Route::resource('/account', AccountController::class);
    //logout route
    Route::post('/logout', [AuthController::class, 'logout']);
});
