<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\login;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use League\CommonMark\Node\Block\Document;
use App\Http\Interfaces\LoginInterface;
use PhpParser\Node\Expr\Cast\Object_;

class LoginImplementacion implements LoginInterface
{
    public function login($request): array
    {
        try {
            if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                return ['error' => 'El email o el password son incorrectos'];
            }
            $user = Auth::user();
            $token = $user->createToken('token')->plainTextToken;
            return [
                'succes' => 'Autenticacion con exito',
                'token' => $token
            ];
        } catch (Exception) {
            return ['error'=>'Error interno'];
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
}
