<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\CreateUserInterface;
use App\Http\Requests\login;
use App\Models\User;
use Illuminate\Http\Request;

class CreateUserImplementation implements CreateUserInterface
{
    public function createUsers($nombre, $email, $password):array
    {
        try {
            $status = User::create([
                'email' => $email,
                'password' => bcrypt($password),
                'name' => $nombre
            ]);
            return ['sucess' => 'El usuario se creo de forma correcta','user' => $status];
        } catch (\Throwable $th) {
            return ['error' => 'Error generado en el servidor ','Trow'=>$th];
        }
    }
}

class CreateUserController extends Controller
{
    private $createUsers;

    public function __construct(CreateUserImplementation $createUsers)
    {
        $this->createUsers = $createUsers;
    }

    public function create(login $request)
    {
        $status = $this->createUsers->createUsers($request['nombre'],$request['email'],$request['password']);
        return response()->json($status,$status['error'] ? 422 : 200);
    }
}
