<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;

Route::prefix('v1')->group(function(){
    Route::apiResource('users',UserController::class);
    Route::post('login',[AuthController::class,'login']);
});
