<?php

use App\Http\Controllers\Clientes\ClientesController;
use Illuminate\Support\Facades\Route;

function ApiClientes()
{
    /**
     * Crea un nuevo cliente
     */
    Route::post('/newcliente',[ClientesController::class,'newCliente']);
    /**
     * Actualiza el nombre del cliente
     */
    Route::post('/updatecliente',[ClientesController::class,'updateCliente']);
    /**
     * Elimina el nombre del cliente
     */
    Route::get('/deletecliente',[ClientesController::class,'deleteCliente']);
    /**
     * Tare todos los clientes
     */
    Route::get('/indexclientes',[ClientesController::class,'indexCliente']);
}