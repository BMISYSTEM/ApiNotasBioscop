<?php

use App\Http\Controllers\Users\UserController;
use Illuminate\Support\Facades\Route;

function ApiUser(){
    Route::post('/newuser',[UserController::class,'newUser']);
    Route::post('/updateuser',[UserController::class,'updateUser']);
    Route::get('/deleteuser',[UserController::class,'deleteUser']);
    Route::get('/indexuser',[UserController::class,'indexUser']);
}