<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\login;
use App\Models\permiso;
use Illuminate\Support\Facades\Auth;



class LoginImplementacion implements LoginInterface
{
    public function login($request): array
    {
        try {
            if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                return ['error' => 'El email o el password son incorrectos'];
            }
            $user = Auth::user();
            $userRol = Auth::user()->id_rol;
            $permisos = permiso::where('id_rol',$userRol)->get();
            $token = $user->createToken('token')->plainTextToken;
            return [
                'succes' => 'Autenticacion con exito',
                'token' => $token,
                'foto' => $user->foto,
                'rol'=>$userRol,
                'permisos'=>$permisos 
            ];
        } catch (\Throwable $th) {
            return ['error'=>'Error interno'];
        }
    }

    public function index(): array
    {
        try {
            $user = Auth::user();
            return ['succes'=>$user];
        } catch (\Throwable $th) {
            return ['error'=>$th];
        }
    }
    public function userPermisos(): array
    {
        try {
            $user = Auth::user();
            $permisos = permiso::where('id_rol',$user->id_rol)->get();
            return [
                'succes'=>$user,
                'permisos' =>$permisos
            ];
        } catch (\Throwable $th) {
            return ['error'=>$th];
        }
    }
}
/*
|--------------------------------------------------------------------------
| LoginController LoginController
|--------------------------------------------------------------------------
|
| Se realiza la inyeccion de dependencias por medio de la implementacion
| de la clase LoginImplementacion que a su vez implementa la interfaz de LoginInterface 
|
*/
class LoginController extends Controller
{
    private $LoginUser;
    /** 
     * @param LoginImplementacion $LoginUser
     */
    public function __construct(LoginImplementacion $LoginUser)
    {
        $this->LoginUser = $LoginUser;
    }
    
    /** Login de la aplicacion
     * @param login $request
     * 
     * @return Object
     */
    public function login(login $request):Object
    {
        $status = $this->LoginUser->login($request);
        return response()->json($status,array_key_exists('error',$status) ? 422 :200 );
    }

    public function index():object
    {
        $status = $this->LoginUser->index();
        return response()->json($status,array_key_exists('error',$status) ? 422 :200 ); 
    }
    public function userPermisos():object
    {
        $status = $this->LoginUser->userPermisos();
        return response()->json($status,array_key_exists('error',$status) ? 422 :200 ); 
    }
}
