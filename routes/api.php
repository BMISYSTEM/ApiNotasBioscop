<?php


use App\Http\Controllers\LoginController;
use App\Http\Controllers\Os\OsApuntamientoController;
use App\Http\Controllers\User\UserController;

use Illuminate\Support\Facades\Route;

/**
 * Se adicionan los endpoints para mejora de legibilidad pero se pueden agregar al autoload
 */
require_once __DIR__ . '/RutasApi/ApiLogin.php';
require_once __DIR__ . '/RutasApi/ApiNotas.php';
require_once __DIR__ . '/RutasApi/ApiEstados.php';
require_once __DIR__ . '/RutasApi/ApiClientes.php';
require_once __DIR__ . '/RutasApi/ApiOs.php';
require_once __DIR__ . '/RutasApi/ApiUser.php';


 /*
|--------------------------------------------------------------------------
| Rutas protegidas
|--------------------------------------------------------------------------
|
| Aca se encuentra el listado de agrupamiento de rutas protegidas las cuales deberan pasar
| La seguridad por medio del Bearer Token o tener un Token almacenado en la tabla personal_token
*/
Route::middleware('auth:sanctum')->group(function(){
      /*
    |--------------------------------------------------------------------------
    | Enrutadores refrentes a login, solo cierre de session el login es publico
    |--------------------------------------------------------------------------
    */
    Route::prefix('Login')->group(ApiLogin());
     /*
    |--------------------------------------------------------------------------
    | Enrutadores refrentes a Notas
    |--------------------------------------------------------------------------
    */
    Route::prefix('Notas')->group(ApiNotas());
     /*
    |--------------------------------------------------------------------------
    | Enrutadores refrentes a Estados
    |--------------------------------------------------------------------------
    */
    Route::prefix('Estados')->group(ApiEstados());
     /*
    |--------------------------------------------------------------------------
    | Enrutadores refrentes a Clientes
    |--------------------------------------------------------------------------
    */
    Route::prefix('Clientes')->group(ApiClientes());
      /*
    |--------------------------------------------------------------------------
    | Enrutadores refrentes a OS
    |--------------------------------------------------------------------------
    */
    Route::prefix('Os')->group(ApiOs());
     /*
    |--------------------------------------------------------------------------
    | Enrutadores refrentes a Usuarios
    |--------------------------------------------------------------------------
    */
    Route::prefix('User')->group(ApiUser());
    /*
    |--------------------------------------------------------------------------
    | Enrutadores refrentes a Apuntamiento de OS
    |--------------------------------------------------------------------------
    */
    Route::post('/newapuntamiento',[OsApuntamientoController::class,'newApuntamientoOs']);
    Route::post('/updateapuntamientoos',[OsApuntamientoController::class,'updateApuntamientoOs']);
    Route::get('/deleteapuntamientoos',[OsApuntamientoController::class,'deleteApuntamientoOs']);
    Route::get('/indexapuntamientoos',[OsApuntamientoController::class,'indexApuntamientoOS']);
});
/**
* Inicio de session
*/
Route::post('/login',[LoginController::class,'login']);
// Route::get('/inicio',[AuthController::class,'create']);


