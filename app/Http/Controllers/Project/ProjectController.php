<?php 

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Project\Interfaces\ProjectInterfaces;
use App\Models\project;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Http\Request;

class ProjectImplement implements ProjectInterfaces
{
    /** crea un nuevo projecto
     * @param string $nombre
     * @param int $horas
     * @param int $id_nombre
     * 
     * @return array
     */
    function newProject(string $nombre, int $horas, int $id_cliente): array
    {
        try {
           $project = project::create([
                'nombre' => $nombre,
                'horas'=>$horas,
                'id_cliente'=>$id_cliente
           ]);
           return ['succes'=>'Se creo el projecto de forma correcta'];
        } catch (\Throwable $th) {
            return ['error' => 'Error inesperado en el servidor '.$th];
        }
    }
    /** Actualiza un projecto existente solo se actualiza nombre y horas
     * @param int $id
     * @param string $nombre
     * @param int $horas
     * 
     * @return array
     */
    function updateProject(int $id, string $nombre, int $horas): array
    {
        try {
            $project = project::find($id);
            $project->nombre = $nombre;
            $project->horas = $horas;
            $project->save();
            return ['succes'=>'Se actualizo el projecto de forma correcta'];
         } catch (\Throwable $th) {
             return ['error' => 'Error inesperado en el servidor '.$th];
         }
    }

    /** Elimina un projecto
     * @param int $id
     * 
     * @return array
     */
    function deleteProject(int $id): array
    {
        try {
            $project = project::find($id);
            $project->delete();
            return ['succes'=>'Se elimino el projecto de forma correcta'];
         } catch (\Throwable $th) {
             return ['error' => 'Error inesperado en el servidor '.$th];
         }
    }
    /** consulta todos los projectos
     * @return array
     */
    function indexProject(): array
    {
        try {
            $project = project::all();
            return ['succes'=>$project];
         } catch (\Throwable $th) {
             return ['error' => 'Error inesperado en el servidor '.$th];
         }
    }
    /** Devuelve solo la informacion de un project
     * @param int $id
     * 
     * @return array
     */
    function findProject(int $id): array
    {
        try {
            $project = project::find($id);
            return ['succes'=>$project];
         } catch (\Throwable $th) {
             return ['error' => 'Error inesperado en el servidor '.$th];
         }
    }
}

class ProjectController extends Controller
{
    private $project;

    function __construct(ProjectImplement $implement)
    {
        $this->project = $implement;
    }

    /** crea un proyecto mediante la implementacion
     * @param Request $request
     * 
     * @return object
     */
    function newProject(Request $request):object
    {
        $request = $request->validate(
            [
                'nombre' => 'required',
                'horas'=>'required|numeric',
                'id_cliente'=>'required|exists:clientes,id',
            ],
            [
                'nombre.required' => 'El nombre es requerido',
                'horas.required' => 'El horas es requerido',
                'id_cliente.required' => 'El id_cliente es requerido',
                'id_cliente.exists' => 'El cliente no existe ',
            ]
        );
        $estatus = $this->project->newProject($request['nombre'],$request['horas'],$request['id_cliente']);
        return response()->json($estatus,array_key_exists('error',$estatus) ? 500 : 200);
    }
    /** Actualiza un projecto mediante la implementacion
     * @param ClientRequest $request
     * 
     * @return object
     */
    function updateProject(ClientRequest $request):object
    {
        $request = $request->validate(
            [
                'nombre' => 'required',
                'horas'=>'required|numeric',
                'id'=>'required|exists:projects,id',
            ],
            [
                'nombre.required' => 'El nombre es requerido',
                'horas.required' => 'El horas es requerido',
                'id.required' => 'El id_cliente es requerido',
                'id.exists' => 'El cliente no existe ',
            ]
        );
        $estatus = $this->project->updateProject($request['id'],$request['nombre'],$request['horas']);
        return response()->json($estatus,array_key_exists('error',$estatus) ? 500 : 200);
    }

    /** Elimina un projecto mediante la implementacion
     * @param Request $request
     * 
     * @return object
     */
    function deleteProject(Request $request):object
    {
        $request = $request->validate(
            [
                'id'=>'required|exists:projects,id',
            ],
            [
                'id.required' => 'El id_cliente es requerido',
                'id.exists' => 'El cliente no existe ',
            ]
        );
        $estatus = $this->project->deleteProject($request['id']);
        return response()->json($estatus,array_key_exists('error',$estatus) ? 500 : 200);
    }

    /** consulta todos los projectos
     * @return object
     */
    function indexProject():object
    {
        $estatus = $this->project->indexProject();
        return response()->json($estatus,array_key_exists('error',$estatus) ? 500 : 200);
    }

    function findProject(Request $request):object
    {
        $request = $request->validate(
            [
                'id'=>'required|exists:projects,id',
            ],
            [
                'id.required' => 'El id_cliente es requerido',
                'id.exists' => 'El cliente no existe ',
            ]
        );
        $estatus = $this->project->findProject($request['id']);
        return response()->json($estatus,array_key_exists('error',$estatus) ? 500 : 200);
    }
}
