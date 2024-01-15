<?php

use App\Http\Controllers\Notas\NotasController;
use Illuminate\Support\Facades\Route;

function ApiNotas()
{
     /**
     *  Se crea una nueva nota 
     */
    Route::post('/newnota',[NotasController::class,'NewNote']);
    /**
     * Consulta todas las notas de un rango de tiempo deteminado que se pasa por qeryparameter
     */
    Route::get('/indexnota',[NotasController::class,'index']);
    /**
     *  Actualiza la nota que se envia mediante id del post
     */
    Route::post('/updatenota',[NotasController::class,'update']);
    /**
     * Elimina una nota en la base de datos
     */
    Route::get('/deletenota',[NotasController::class,'delete']);
}