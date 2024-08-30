<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Users\Interface\LogoutInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 *  LogoutImplementation funtions [logout():array]
 */
class LogoutImplementation implements LogoutInterface
{
    public function logout():array
    {
        try {
            $user = Auth::user();
            $status = $user->currentAccessToken()->delete();
            return ['succes' => 'El cierre de session se completo con exito'];
        } catch (\Throwable $th) {
            return ['error' => 'Error interno en el servidor'];
        }
    }
}
 /*
|--------------------------------------------------------------------------
| Logoutcontroller
|--------------------------------------------------------------------------
|
| Se encarga de eliminar el token en la tabla personal_acces_token 
| Devuelve un mensaje el cual de ser 200 debere eliminar el token almacendo en el frontend 
*/
class Logoutcontroller extends Controller
{
    private $logoutUser;
    public function __construct(LogoutImplementation $logoutUser)
    {
        $this->logoutUser = $logoutUser;
    }
    public function logout()
    {
        $estatus = $this->logoutUser->logout();
        return response()->json($estatus,array_key_exists('error',$estatus) ? 422 : 200);
    }
}
