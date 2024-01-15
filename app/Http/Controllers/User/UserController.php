<?php 

namespace App\Http\Controllers\User;
// interface

use App\Http\Controllers\Controller;
use App\Http\Controllers\User\Interface\userInterface;
use App\Models\User;
use Illuminate\Http\Request;


// implementacion
class userImplement implements userInterface
{
    public function newUser(string $nombre,string $email,string $password):array
    {
        try {
            $usuario = User::create([
                'name' => $nombre,
                'email' => $email,
                'password' => bcrypt($password),
            ]);
            return ['succes'=>'Se creo el usuario de forma correcta'];
        } catch (\Throwable $th) {
            return ['error'=> 'Error inesperado del lado del servidor .'.$th];
        }
    }
    public function updateUser(int $id, string $nombre,string $email):array
    {
        try {
            $usuario = User::find($id);
            $usuario->name = $nombre;
            $usuario->email = $email;
            $usuario->save();
            return ['succes'=> 'Se actualizo el usuario'];
        } catch (\Throwable $th) {
            return ['error'=> 'Error inesperado del lado del servidor .'.$th];
        }
    }
    public function deleteUser(int $id):array
    {
        try {
            $usuario = User::find($id);
            $usuario->delete();
            return ['succes'=> 'Se elimino el usuario'];
        } catch (\Throwable $th) {
            return ['error'=> 'Error inesperado del lado del servidor .'.$th];
        }
    }
    public function indexUser():array
    {
        try {
            $usuarios = User::all();
            return ['succes'=> $usuarios];
        } catch (\Throwable $th) {
            return ['error'=> 'Error inesperado del lado del servidor .'.$th];
        }
    }
}
// ejecucion
class UserController extends Controller
{
    private $user;
    public function __construct(userImplement $user)
    {
        $this->user = $user;
    }
    /** Valida y ejecuta en la implementacion el usuario
     * @param Request $request
     * 
     * @return object
     */
    public function newUser(Request $request):object
    {
        $request = $request->validate(
            [
                'nombre' => 'required|min:10|max:100',
                'email' => 'required|email',
                'password'=> 'required|regex:/^(?=.*[0-9])(?=.*[a-zA-Z])(?=.*[@$!%*#?&])[A-Za-z0-9@$!%*#?&]+$/|min:8'
            ],
            [
                'nombre.required' => 'El nombre es obligatorio',
                'nombre.min' => 'El nombre es muy corto',
                'nombre.max' => 'El nombre es muy largo',
                'email.required' => 'El email es requerido',
                'email.email' => 'Ingrese un email valido',
                'password.min' => 'El password debe contener minimo 8 caracteres',
                'password.required' => 'El password es requerido',
                'password.regex' => 'El password debe contener un numero del 0 al 9 un caracter especial [@$!%*#?&] y minimo 8 carcateres'
            ]
        );
        $estatus = $this->user->newUser($request['nombre'],$request['email'],$request['password']);
        return response()->json($estatus,array_key_exists('error',$estatus) ? 500 : 200);
    }
    /** Actualiza el usuario nombre y email
     * @param Request $request
     * 
     * @return object
     */
    public function updateUser(Request $request ):object
    {
        $request = $request->validate(
            [
                'id' => 'required',
                'nombre' => 'required|min:10|max:100',
                'email' => 'required|email',
            ],
            [
                'id.required' => 'Se requiere el id del usuario',
                'nombre.required' => 'El nombre es obligatorio',
                'email.required' => 'El email es requerido',
                'email.email' => 'Ingrese un email valido',
                'nombre.min' => 'El nombre es muy corto',
                'nombre.max' => 'El nombre es muy largo',
            ]
        );
        $estatus = $this->user->updateUser($request['id'],$request['nombre'],$request['email']);
        return response()->json($estatus,array_key_exists('error',$estatus) ? 500 : 200);
    }
    /** Elimina un usuario
     * @param Request $request
     * 
     * @return object
     */
    public function deleteUser(Request $request):object
    {
        $id = $request->query('id');
        $estatus = $this->user->deleteUser($id);
        return response()->json($estatus,array_key_exists('error',$estatus) ? 500 : 200);
    }
    /** retorna un listado de usuarios
     * @return object
     */
    public function indexUser():object
    {
        $estatus = $this->user->indexUser();
        return response()->json($estatus,array_key_exists('error',$estatus) ? 500 : 200);
    }
}