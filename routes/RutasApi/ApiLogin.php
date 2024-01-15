<?php

// namespace routes\RutasApi;

use App\Http\Controllers\Logoutcontroller;
use Illuminate\Support\Facades\Route;

function ApiLogin()
{
    /**
    * Se encarga del cierre de session eliminando el token generado
    */
    Route::get('/logout',[Logoutcontroller::class,'logout']);
}