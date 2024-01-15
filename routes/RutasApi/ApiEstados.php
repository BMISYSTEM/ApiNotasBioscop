<?php

use App\Http\Controllers\Estados\EstadosController;
use Illuminate\Support\Facades\Route;

function ApiEstados()
{
     /**
     * Crea un nuevo estado
     */
    Route::post('/newestado',[EstadosController::class,'newEstado']);
    /**
     * Actualiza Un estado
     */
    Route::post('/updateestado',[EstadosController::class,'updateEstado']);
    /**
     * Elimina un estado
     */
    Route::get('/deleteestado',[EstadosController::class,'deleteEstado']);
    /**
     * Consulta todos los estados
     */
    Route::get('/indexestados',[EstadosController::class,'index']);
}