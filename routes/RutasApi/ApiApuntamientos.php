<?php

use App\Http\Controllers\Os\OsApuntamientoController;
use Illuminate\Support\Facades\Route;

function ApiApuntamientos()
{
    Route::post('/newapuntamiento',[OsApuntamientoController::class,'newApuntamientoOs']);
    Route::post('/updateapuntamientoos',[OsApuntamientoController::class,'updateApuntamientoOs']);
    Route::get('/deleteapuntamientoos',[OsApuntamientoController::class,'deleteApuntamientoOs']);
    Route::get('/indexapuntamientoos',[OsApuntamientoController::class,'indexApuntamientoOS']);  
}