<?php

use App\Http\Controllers\Os\OsController;
use Illuminate\Support\Facades\Route;

function ApiOs()
{
    Route::post('/newos',[OsController::class,'newOs']);
    Route::post('/updateos',[OsController::class,'updateos']);
    Route::get('/deleteos',[OsController::class,'deleteos']);
    Route::get('/indexos',[OsController::class,'indexos']);
}