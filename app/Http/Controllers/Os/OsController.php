<?php

namespace App\Http\Controllers\Os;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Os\Interfaces\OsInterface;
use App\Models\Os;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// implementacion
class OsImplement implements OsInterface
{
    public function newOs(int $cliente,int $user, int $estado, string $descripcion): array
    {
        try {
            $os = Os::create(
                [
                    'descripcion' => $descripcion,
                    'id_cliente' => $cliente,
                    'user_id' =>    $user,
                    'estado_id' => $estado
                ]
                );
            return ['succes'=> 'La OS fue creada con exito'];
        } catch (\Throwable $th) {
            return ['error' => 'Error inesperado en el servidor '. $th];
        }
    }

    public function updateOs(int $id,int $user, int $estado, string $descripcion): array
    {
        try {
            $os = Os::find($id);
            $os->user_id = $user;
            $os->estado_id = $estado;
            $os->descripcion = $descripcion;
            $os->save();
            return ['succes'=> 'La OS fue actualizada con exito'];
        } catch (\Throwable $th) {
            return ['error' => 'Error inesperado en el servidor '. $th];
        }
    }

    public function deleteOs(int $id): array
    {
        try {
            $os = Os::find($id);
            $os->delete();
            return ['succes'=> 'La OS fue eliminada con exito'];
        } catch (\Throwable $th) {
            return ['error' => 'Error inesperado en el servidor '. $th];
        }
    }
    public function indexOs(): array
    {
        try {
            $os = DB::select('
            select o.id,o.descripcion,o.user_id,o.estado_id,o.id_cliente,
                    u.name as consultor,
                    e.nombre as estado,e.color,
                    c.nombre as empresa 
            from os o 
            inner join users u on o.user_id = u.id
            inner join estados e on o.estado_id = e.id
            inner join clientes c on o.id_cliente = c.id
            order by o.created_at desc');
            return ['succes'=> $os];
        } catch (\Throwable $th) {
            return ['error' => 'Error inesperado en el servidor '. $th];
        }
    }

    public function getResumen(): array
    {
        try {
            $osActiva = DB::select('select count(*) as osActivas from os where activo = 1');
            $osInactiva = DB::select('select count(*) as osInactiva from os where activo = 0');
            return ['succes'=>[$osActiva[0],$osInactiva[0]]];
        } catch (\Throwable $th) {
            return ['error'=> 'Error inesperado en el servidor '.$th];
        }
    }
}
// controlador
class OsController extends Controller
{
    private $os;

    public function __construct(OsImplement $os)
    {
        $this->os = $os;
    }
    public function newOs(Request $request): object
    {
        $request = $request->validate(
            [
                'descipcion'    => 'required|min:10|max:500',
                'cliente'       => 'required|exists:clientes,id',
                'user'          => 'required|exists:users,id',
                'estado'        => 'required|exists:estados,id'
            ],
            [
                'descipcion.required'  => 'Se requiere la descripcion',
                'descipcion.min'       => 'La descripcion es muy corta minimo 10 carcateres',
                'descipcion.max'       => 'La descripcion es muy larga maximo 500 carcateres',
                'cliente.required'      => 'El cliente es requerido',
                'cliente.exists'        => 'El cliente no existe',
                'user.required'         => 'El usuario es requerido',
                'user.exists'           => 'El usuario no existe',
                'estado.required'       => 'El estado es requerido',
                'estado.exists'         => 'El estado no existe'
            ]
        );
        $estatus = $this->os->newOs($request['cliente'],
                                    $request['user'],
                                    $request['estado'],
                                    $request['descipcion']);
        return response()->json($estatus,array_key_exists('error',$estatus) ? 500 : 200);
    }
    public function updateOs(Request $request): object
    {
        $request = $request->validate(
            [
                'descripcion'    => 'required|min:10|max:500',
                'id'            => 'required|exists:os,id',
                'user'          => 'required|exists:users,id',
                'estado'        => 'required|exists:estados,id'
            ],
            [
                'descripcion.required'  => 'Se requiere la descripcion',
                'descripcion.min'       => 'La descripcion es muy corta minimo 10 carcateres',
                'descripcion.max'       => 'La descripcion es muy larga maximo 500 carcateres',
                'id.required'           => 'El id de la os es requerido',
                'id.exists'             => 'El id de la os no existe',
                'user.required'         => 'El usuario es requerido',
                'user.exists'           => 'El usuario no existe',
                'estado.required'       => 'El estado es requerido',
                'estado.exists'         => 'El estado no existe'
            ]
        );
        $estatus = $this->os->updateOs( $request['id'],
                                        $request['user'],
                                        $request['estado'],
                                        $request['descripcion']);
        return response()->json($estatus,array_key_exists('error',$estatus) ? 500 : 200);
    }

    public function deleteOs(Request $request): object
    {
        $id = $request->query('id');
        $estatus = $this->os->deleteOs( $id);
        return response()->json($estatus,array_key_exists('error',$estatus) ? 500 : 200);
    }
    public function indexOs(): object
    {
        $estatus = $this->os->indexOs();
        return response()->json($estatus,array_key_exists('error',$estatus) ? 500 : 200);
    }

    public function getResumen()
    {
        $estatus = $this->os->getResumen();
        return response()->json($estatus,array_key_exists('error',$estatus) ? 500 : 200);
    }
}