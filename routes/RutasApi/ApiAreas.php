<?php

use App\Http\Controllers\Areas\AreasController;
use Illuminate\Support\Facades\Route;

function ApiAreas()
{
    Route::post('/newarea',[AreasController::class,'newArea']);
    Route::get('/indexarea',[AreasController::class,'indexArea']);
    Route::post('/updatearea',[AreasController::class,'updateArea']);
    Route::post('/deletearea',[AreasController::class,'deleteArea']);
}