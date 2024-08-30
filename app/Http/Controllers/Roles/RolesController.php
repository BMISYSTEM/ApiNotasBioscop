<?php

namespace App\Http\Controllers\Roles;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Roles\Interfaces\RolesInterfaces;
use App\Models\rol;
use Illuminate\Http\Request;



class RolesImplement implements RolesInterfaces
{
    function newRol(string $nombre): array
    {
        try {
            $rol = rol::create([
                'nombre' => $nombre
            ]);
            return ['succes'=>'Se creo de forma correcta'];
        } catch (\Throwable $th) {
            return ['error'=>'Error inesperado del lado del servidor '.$th];
        }
    }
    function updateRol(int $id, string $nombre): array
    {
        try {
            $rol = rol::find($id);
            $rol->nombre = $nombre;
            $rol->save();
            return ['succes'=>'Se actualizo de forma correcta'];
        } catch (\Throwable $th) {
            return ['error'=>'Error inesperado del lado del servidor '.$th];
        }
    }
    function deleteRol(int $id): array
    {
        try {
            $rol = rol::find($id);
            $rol->delete();
            return ['succes'=>'Se elimino de forma correcta'];
        } catch (\Throwable $th) {
            return ['error'=>'Error inesperado del lado del servidor '.$th];
        }
    }

    function indexRol(): array
    {
        try {
            $rol = rol::all();
            return ['succes'=>$rol];
        } catch (\Throwable $th) {
            return ['error'=>'Error inesperado del lado del servidor '.$th];
        }
    }
}

class RolesController extends Controller
{
    private $rol;
    function __construct(RolesImplement $rol)
    {
        $this->rol = $rol;
    }

    function newRol(Request $request):object
    {
        $request = $request->validate(
            [
                'nombre' => 'required|min:5|max:255'
            ],
            [
                'nombre.required' => 'El nombre es requerido',
                'nombre.min' => 'El nombre es muy corto',
                'nombre.max' => 'El nombre es muy largo'
            ]
        );
        $estatus = $this->rol->newRol($request['nombre']);
        return response()->json($estatus,array_key_exists('error',$estatus) ? 500 : 200);
    }
    function updateRol(Request $request):object
    {
        $request = $request->validate(
            [
                'nombre' => 'required|min:5|max:355',
                'id' => 'required|exists:rols,id'
            ],
            [
                'nombre.required' => 'El nombre es requerido',
                'nombre.min' => 'El nombre es muy corto',
                'nombre.max' => 'El nombre es muy largo',
                'id.required' => 'El id es requerido',
                'id.exists' => 'El id no existe'
            ]
        );
        $estatus = $this->rol->updateRol($request['id'],$request['nombre']);
        return response()->json($estatus,array_key_exists('error',$estatus) ? 500 : 200);
    }
    function deleteRol(Request $request):object
    {
        $request = $request->validate(
            [
                'id' => 'required|exists:rols,id'
            ],
            [

                'id.required' => 'El id es requerido',
                'id.exists' => 'El id no existe'
            ]
        );
        $estatus = $this->rol->deleteRol($request['id']);
        return response()->json($estatus,array_key_exists('error',$estatus) ? 500 : 200);
    }
    function indexRol():object
    {
        $estatus = $this->rol->indexRol();
        return response()->json($estatus,array_key_exists('error',$estatus) ? 500 : 200);
    }
}