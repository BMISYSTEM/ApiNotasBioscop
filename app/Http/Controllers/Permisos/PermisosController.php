<?php
namespace App\Http\Controllers\Permisos;

use App\Http\Controllers\Controller;
use App\Models\permiso;
use Illuminate\Http\Request;

interface PermisosInterface {

    /**
     * Crea un nuevo permiso por roles
     * @param int $id_rol
     * @param int $home
     * @param int $os
     * @param int $permisos
     * @param int $sharepoint
     * @param int $intinerario
     * @param int $docs
     * @param int $configuraciones
     * 
     * @return array
     */
    function newPermiso(int $id_rol,
                        int $home,
                        int $os,
                        int $permisos,
                        int $sharepoint,
                        int $intinerario, 
                        int $docs, 
                        int $configuraciones):array;

    /**
     * Actualiza el listado de permisos
     * @param int $id_permiso
     * @param int $home
     * @param int $os
     * @param int $permisos
     * @param int $sharepoint
     * @param int $intinerario
     * @param int $docs
     * @param int $configuraciones
     * 
     * @return array
     */
    function updatePermiso( int $id_permiso,
                            int $home,
                            int $os,
                            int $permisos,
                            int $sharepoint,
                            int $intinerario, 
                            int $docs, 
                            int $configuraciones):array;
    /** 
     * Elimina un permio
     * @param int $id_permiso
     * 
     * @return array
     */
    function deletePermiso(int $id_permiso):array;

    /** 
     * Consulta todos los permisos
     * @return array
     */
    function indexPermios():array;

    /** 
     * Consulta un solo permios con el id que se pasara por get
     * @param int $id_permiso
     * 
     * @return array
     */
    function findPermisos(int $id_permiso):array;
}


class PermisosImplement implements PermisosInterface
{
    function newPermiso(int $id_rol, int $home, int $os, int $permisos, int $sharepoint, int $intinerario, int $docs, int $configuraciones): array
    {
        try {
            $permiosRol = permiso::create([
                'id_rol' =>$id_rol,
                'home' =>$home,
                'os' =>$os,
                'permisos' =>$permisos,
                'sharepoint' =>$sharepoint,
                'intinerario' =>$intinerario,
                'docs' =>$docs,
                'configuracion' =>$configuraciones,
            ]);
            return ['succes' => 'Se creo de forma correcta'];
        } catch (\Throwable $th) {
            return ['error' => 'Error inesperado en el servidor '.$th];
        }
    }

    function updatePermiso(int $id_permiso, int $home, int $os, int $permisos, int $sharepoint, int $intinerario, int $docs, int $configuraciones): array
    {
        try {
            /**
             * update permisos set home = $home,os = $os where id = $id_permiso
             */
            $permiosRol = permiso::find($id_permiso);
            $permiosRol->home = $home;
            $permiosRol->os = $os;
            $permiosRol->permisos = $permisos;
            $permiosRol->sharepoint = $sharepoint;
            $permiosRol->intinerario = $intinerario;
            $permiosRol->docs = $docs;
            $permiosRol->configuracion = $configuraciones;
            $permiosRol->save();
            return ['succes' => 'Se Actualizo de forma correcta'];
        } catch (\Throwable $th) {
            return ['error' => 'Error inesperado en el servidor '.$th];
        }
    }

    function deletePermiso(int $id_permiso): array
    {
        try {
             /**
             * delete from permosos where id = $id_permiso
             */
            $permisos = permiso::find($id_permiso);
            $permisos->delete();
            return ['succes' => 'Se Elimino de forma correcta'];
        } catch (\Throwable $th) {
            return ['error' => 'Error inesperado en el servidor '.$th];
        }
    }

    function indexPermios(): array
    {
        try {
             /**
             * select * from permisos 
             */
            $permisos = permiso::all();
            return ['succes' => $permisos];
        } catch (\Throwable $th) {
            return ['error' => 'Error inesperado en el servidor '.$th];
        }
    }

    function findPermisos(int $id_permiso): array
    {
        try {
            /**
             * select * from permisos where id = $id_permiso
             */
            $permisos = permiso::where('id_rol',$id_permiso)->get();
            return ['succes' => $permisos];
        } catch (\Throwable $th) {
            return ['error' => 'Error inesperado en el servidor '.$th];
        }
    }
}

class PermisosController extends Controller
{
    private $permisos;
    function __construct(PermisosImplement $implement)
    {
        $this->permisos = $implement;
    }

    /** creacion de un nuevo permisos por rol
     * @param Request $request
     * 
     * @return object
     */
    function newPermiso(Request $request):object
    {
        $request = $request->validate(
            [
                'id_rol'=>'required|numeric|exists:rols,id',
                'home'=>'required|numeric',
                'os'=>'required|numeric',
                'permisos'=>'required|numeric',
                'sharepoint'=>'required|numeric',
                'intinerario'=>'required|numeric',
                'docs'=>'required|numeric',
                'configuracion'=>'required|numeric', 
            ],
            [
                'id_rol.required' => 'El campo id_rol es requerido',
                'id_rol'=>'El id del rol no existe',
                'home.required' => 'El campo home es requerido',
                'os.required' => 'El campo os es requerido',
                'permisos.required' => 'El campo permisos es requerido',
                'sharepoint.required' => 'El campo sharepoint es requerido',
                'intinerario.required' => 'El campo intinerario es requerido',
                'docs.required' => 'El campo docs es requerido',
                'configuracion.required' => 'El campo configuraciones es requerido',
            ]
            );
            $estatus = $this->permisos->newPermiso($request['id_rol'],
                                                    $request['home'],
                                                    $request['os'],
                                                    $request['permisos'],
                                                    $request['sharepoint'],
                                                    $request['intinerario'],
                                                    $request['docs'],
                                                    $request['configuracion'],
            );

            return response()->json($estatus,array_key_exists('error',$estatus ) ? 500 : 200);                      
    }

    /** Update de permisos
     * @param Request $request
     * 
     * @return object
     */
    function updatePermiso(Request $request):object
    {
        $request = $request->validate(
            [
                'id_permiso'=>'required|numeric|exists:permisos,id',
                'home'=>'required|numeric',
                'os'=>'required|numeric',
                'permisos'=>'required|numeric',
                'sharepoint'=>'required|numeric',
                'intinerario'=>'required|numeric',
                'docs'=>'required|numeric',
                'configuracion'=>'required|numeric', 
            ],
            [
                'id_permiso.required' => 'El campo id_permiso es requerido',
                'id_permiso'=>'El id del rol no existe',
                'home.required' => 'El campo home es requerido',
                'os.required' => 'El campo os es requerido',
                'permisos.required' => 'El campo permisos es requerido',
                'sharepoint.required' => 'El campo sharepoint es requerido',
                'intinerario.required' => 'El campo intinerario es requerido',
                'docs.required' => 'El campo docs es requerido',
                'configuracion.required' => 'El campo configuraciones es requerido',
            ]
            );
            $estatus = $this->permisos->updatePermiso($request['id_permiso'],
                                                    $request['home'],
                                                    $request['os'],
                                                    $request['permisos'],
                                                    $request['sharepoint'],
                                                    $request['intinerario'],
                                                    $request['docs'],
                                                    $request['configuracion'],
            );

            return response()->json($estatus,array_key_exists('error',$estatus ) ? 500 : 200);                      
    }
    /** Elimina un permiso
     * @param Request $request
     * 
     * @return object
     */
    function deletePermiso(Request $request):object
    {
        $request = $request->validate(
            [
                'id_permiso'=>'required|numeric|exists:permisos,id',
            ],
            [
                'id_permiso.required' => 'El campo id_permiso es requerido',
                'id_permiso'=>'El id del rol no existe'
            ]
            );
        $estatus = $this->permisos->deletePermiso($request['id_permiso']);
        return response()->json($estatus,array_key_exists('error',$estatus ) ? 500 : 200);  
    }
    /** devuelve todos los permisos y los roles que esta asignado
     * @return object
     */
    function indexPermios():object
    {
        $estatus = $this->permisos->indexPermios();
        return response()->json($estatus,array_key_exists('error',$estatus ) ? 500 : 200);  
    }
    /** Retorna la informacion de los permisos segun el rol seleccionado
     * @param Request $request
     * 
     * @return object
     */
    function findPermisos(Request $request):object
    {   
        $id_rol = $request->query('id_rol');
        $estatus = $this->permisos->findPermisos($id_rol);
        return response()->json($estatus,array_key_exists('error',$estatus ) ? 500 : 200);  
    }
}