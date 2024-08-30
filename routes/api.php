<?php

use App\Http\Controllers\Documentacion\DocumentacionController;
use App\Http\Controllers\Estados\EstadosController;
use App\Http\Controllers\Permisos\PermisosController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Project\ProjectController;
use Illuminate\Support\Facades\Artisan;
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
require_once __DIR__ . '/RutasApi/ApiApuntamientos.php';
require_once __DIR__ . '/RutasApi/ApiAreas.php';
require_once __DIR__ . '/RutasApi/ApiRoles.php';


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
    | Enrutadores refrentes a Areas 
    |--------------------------------------------------------------------------
    */
    Route::prefix('Areas')->group(ApiAreas());
    /*
    |--------------------------------------------------------------------------
    | Enrutadores refrentes a Roles
    |--------------------------------------------------------------------------
    */
    Route::prefix('Roles')->group(ApiRoles());
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
    Route::prefix('Apuntamientos')->group(ApiApuntamientos());
     /*
    |--------------------------------------------------------------------------
    | Enrutadores refrentes a projectos
    |--------------------------------------------------------------------------
    */
    Route::post('/newproject',[ProjectController::class,'newProject']);
    /*
    |--------------------------------------------------------------------------
    | Enrutadores refrentes a documentacion
    |--------------------------------------------------------------------------
    */
    Route::post('/createmodulo',[DocumentacionController::class,'createModulo']);
    Route::post('/createdocument',[DocumentacionController::class,'createDocumentacion']);
    Route::post('/updatemodulo',[DocumentacionController::class,'updateModulo']);
    Route::post('/updatedocumentacion',[DocumentacionController::class,'updateDocumentacion']);
    Route::get('/allmodulos',[DocumentacionController::class,'allModulos']);
    Route::get('/alldocumentacion',[DocumentacionController::class,'allDocumentacion']);
    Route::get('/deletemodulo',[DocumentacionController::class,'deleteModulo']);
    Route::get('/deletedocumentacion',[DocumentacionController::class,'deleteDocumentacion']);

      /*
    |--------------------------------------------------------------------------
    | Enrutadores refrentes a estados
    |--------------------------------------------------------------------------
    */
    Route::post('/createestado',[EstadosController::class,'newEstado']);
    Route::get('/allestados',[EstadosController::class,'index']);
});
/**
* Inicio de session
*/
Route::post('/login',[LoginController::class,'login']);
/**
 * En cazo de necesitarse se pueden optimizar las rutas desde el despliegue 
 */
Route::get('/config',function(){
  Artisan::call('optimize');
});

Route::post('/newpermisos',[PermisosController::class,'newPermiso']);
Route::post('/updatepermisos',[PermisosController::class,'updatePermiso']);
Route::post('/deletepermisos',[PermisosController::class,'deletePermiso']);
Route::get('/indexpermisos',[PermisosController::class,'indexPermios']);
Route::get('/findpermisos',[PermisosController::class,'findPermisos']);

