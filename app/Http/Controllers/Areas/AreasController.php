<?php
namespace App\Http\Controllers\Areas;

use App\Http\Controllers\Areas\Interface\AreasInterfaces;
use App\Http\Controllers\Controller;
use App\Models\area;
use Illuminate\Http\Request;



 /*
|--------------------------------------------------------------------------
| Implementacion de interfaz
|--------------------------------------------------------------------------
|
| Crea nuevas areas como proyectos,desarrollo,gerencia y demas
|
*/
class AreasImplement implements AreasInterfaces 
{
    function newArea(string $nombre): array
    {
        try {
            $area = area::create(
                [
                    'nombre' => $nombre
                ]
            );
            return ['succes' => 'Se creo de forma correcta el area '];
        } catch (\Throwable $th) {
            return ['error' => 'Error inesperado en el servidor '.$th];
        }
    }

    function updateArea(int $id, string $nombre): array
    {
        try {
            $area = area::find($id);
            $area->nombre = $nombre;
            $area->save();
            return ['succes' => 'Se actualizo de forma correcta el area '];
        } catch (\Throwable $th) {
            return ['error' => 'Error inesperado en el servidor '.$th];
        }
    }
    function deleteArea(int $id): array
    {
        try {
            $area = area::find($id);
            $area->delete();
            return ['succes' => 'Se elimino de forma correcta el area '];
        } catch (\Throwable $th) {
            return ['error' => 'Error inesperado en el servidor '.$th];
        }
    }

    function indexArea(): array
    {
        try {
            $area = area::all();
            return ['succes' => $area];
        } catch (\Throwable $th) {
            return ['error' => 'Error inesperado en el servidor '.$th];
        }
    }
}

class AreasController extends Controller
{   private $areas;
    public function __construct(AreasImplement $areas)
    {
        $this->areas = $areas;
    }

    function newArea(Request $request):object
    {   
        $request = $request->validate(
            [
                'nombre' => 'required|min:5|max:255'
            ],
            [
                'nombre.required' => 'El nombre es requerido ',
                'nombre.min' => 'El nombre es muy corto',
                'nombre.max' => 'El nombre es muy largo',
            ]
        );
        $estatus = $this->areas->newArea($request['nombre']);
        return response()->json($estatus,array_key_exists('error',$estatus) ? 500 : 200);
    }
    function updateArea(Request $request):object
    {   
        $request = $request->validate(
            [
                'id' => 'required|exists:areas,id',
                'nombre' => 'required|min:5|max:255'
            ],
            [
                'id.required' => 'El id del area es obligatorio',
                'id.exists' => 'El id del area  no existe',
                'nombre.required' => 'El nombre es requerido ',
                'nombre.min' => 'El nombre es muy corto',
                'nombre.max' => 'El nombre es muy largo',
            ]
        );
        $estatus = $this->areas->updateArea($request['id'],$request['nombre']);
        return response()->json($estatus,array_key_exists('error',$estatus) ? 500 : 200);
    }
    function deleteArea(Request $request):object
    {   
        $request = $request->validate(
            [
                'id' => 'required|exists:areas,id',
            ],
            [
                'id.required' => 'El id del area es obligatorio',
                'id.exists' => 'El id del area  no existe',
            ]
        );
        $estatus = $this->areas->deleteArea($request['id']);
        return response()->json($estatus,array_key_exists('error',$estatus) ? 500 : 200);
    }

    function indexArea():object
    {
        $estatus = $this->areas->indexArea();
        return response()->json($estatus,array_key_exists('error',$estatus) ? 500 : 200); 
    }
}