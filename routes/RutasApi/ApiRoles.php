<?php

use App\Http\Controllers\Roles\RolesController;
use Illuminate\Support\Facades\Route;

function ApiRoles()
{
    Route::post('/newrol',[RolesController::class,'newRol']);
    Route::get('/indexrol',[RolesController::class,'indexRol']);
    Route::post('/updaterol',[RolesController::class,'updateRol']);
    Route::post('/deleterol',[RolesController::class,'deleteRol']);  
}