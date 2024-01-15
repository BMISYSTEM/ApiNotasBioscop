<?php
namespace App\Http\Controllers\Estados;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Estados\Interface\EstadosInterface;
use App\Models\Estado;
use Illuminate\Http\Request;



// implementacion 

class EstadosImplement implements EstadosInterface
{
    public function newEstado(string $nombre, string $color): array
    {
        try {
            $estado = Estado::create([
                'nombre' => $nombre,
                'color' => $color
            ]);
            return ['succes' => 'Se creo con exito el estado'];
        } catch (\Throwable $th) {
            return ['error' => 'Error inesperado del lado del servidor .'.$th];
        }
    }
    public function updateEstado(int $id, string $nombre, string $color): array
    {
        try {
            $estado = Estado::find($id);
            $estado->nombre = $nombre;
            $estado->color = $color;
            $estado->save();
            return ['succes' => 'Se actualizo con exito el estado'];
        } catch (\Throwable $th) {
            return ['error' => 'Error inesperado del lado del servidor .'.$th];
        }
    }
    public function deleteEstado(int $id): array
    {
        try {
            $estado = Estado::find($id);
            // En caso de que el id proporcionado no se encuentre en la bd 
            if (!$estado) return ['alert' => 'No se encuentra un estado con codigo:'.$id];
            $estado->delete();
            return ['succes' => 'Se elimino con exito el estado'];
        } catch (\Throwable $th) {
            return ['error' => 'Error inesperado del lado del servidor .'.$th];
        }
    }

    public function index(): array
    {
        try {
            $estados = Estado::all();
            return ['succes' => $estados];
        } catch (\Throwable $th) {
            return ['error' => 'Error inesperado del lado del servidor .'.$th];
        }
    }
}
// controller

class EstadosController extends Controller
{
    private $estados;
    public function __construct(EstadosImplement $estados)
    {
        $this->estados = $estados;
    }

    /** Validacion Http y ejecucion de implementacion newestado
     * @param Request $request
     * 
     * @return object
     */
    public function newEstado(Request $request):object
    {
        $request = $request->validate(
            [
                'nombre' => 'required',
                'color' => 'required'

            ],
            [
                'nombre.required' => 'El nombre es requerido',
                'color.required' => 'El color es requerido',
            ]
        );
        $estatus = $this->estados->newEstado($request['nombre'],$request['color']);
        return response()->json($estatus,array_key_exists('error',$estatus) ? 500 : 200);
    }

    /** Validacion HTTP y ejecuta implemnetacion updateestado
     * @param Request $request
     * 
     * @return object
     */
    public function updateEstado(Request $request):object
    {
        $request = $request->validate(
            [
                'id'    => 'required|exists:estados,id',
                'nombre' => 'required',
                'color' => 'required'

            ],
            [
                'id.required' => 'Se requiere el id del estado',
                'id.exists' => 'El estado que intenta actualiza no existe',
                'nombre.required' => 'El nombre es requerido',
                'color.required' => 'El color es requerido'
            ]
        );
        $estatus = $this->estados->updateEstado($request['id'],$request['nombre'],$request['color']);
        return response()->json($estatus,array_key_exists('error',$estatus) ? 500 : 200);
    }
    /** Validacion HTTP y ejecuta implemnetacion deleteEstado
     * @param Request $request
     * 
     * @return object
     */
    public function deleteEstado(Request $request):object
    {
        $id = $request->query('id');
        $estatus = $this->estados->deleteEstado($id);
        return response()->json($estatus,array_key_exists('error',$estatus) ? 500 : 200);
    }
    /** Consulta todos los estados 
     * @return object
     */
    public function index():object
    {
        $estatus = $this->estados->index();
        return response()->json($estatus,array_key_exists('error',$estatus) ? 500 : 200);
    }
}

