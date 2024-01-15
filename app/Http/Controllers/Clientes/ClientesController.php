<?php

namespace App\Http\Controllers\Clientes;

use App\Http\Controllers\Clientes\Interface\ClienteInterface;
use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Illuminate\Http\Request;

 /*
|--------------------------------------------------------------------------
| Implemneta la interfaz de clientes 
|--------------------------------------------------------------------------
*/
class ClienteImplement implements ClienteInterface
{
    public function newCliente(string $nombre): array
    {
        try {
            $cliente = Cliente::create([
                'nombre' => $nombre
            ]);
            return ['succes'=>'La empresa se creo con exito'];
        } catch (\Throwable $th) {
            return ['error','Error inesperado en el servidor .'.$th];
        }
    }
    public function updateCliente(int $id, string $nombre): array
    {
        try {
            $cliente = Cliente::find($id);
            $cliente->nombre = $nombre;
            $cliente->save();
            return ['succes'=>'La empresa se actualizo con exito'];
        } catch (\Throwable $th) {
            return ['error','Error inesperado en el servidor .'.$th];
        }
    }
    public function deleteCliente(int $id): array
    {
        try {
            $cliente = Cliente::find($id);
            $cliente->delete();
            return ['succes'=>'La empresa se elimino con exito'];
        } catch (\Throwable $th) {
            return ['error','Error inesperado en el servidor .'.$th];
        }
    }
    public function indexCliente(): array
    {
        try {
            $cliente = Cliente::all();
            return ['succes'=>$cliente];
        } catch (\Throwable $th) {
            return ['error','Error inesperado en el servidor .'.$th];
        }
    }
}

 /*
|--------------------------------------------------------------------------
| Maneja las peticiones HTTP referentes a los clientes y extiende a Controller para manejo de HTTP
|--------------------------------------------------------------------------
*/
class ClientesController extends Controller
{
    private $cliente;
    public function __construct(ClienteImplement $cliente)
    {
        $this->cliente = $cliente;
    }
    /** Crea un nuevo cliente
     * @param Request $request
     * 
     * @return object
     */
    public function newCliente(Request $request):object
    {
        /**
         * Validacion de HTTP campos nombre
         */
        $request = $request->validate(
            [
                'nombre' => 'required|min:5|max:25'
            ],
            [
                'nombre.required' => 'El nombre es requerido',
                'nombre.min' => 'El nombre es muy corto minimo 5 caracteres',
                'nombre.max' => ' El nombre es muy largo maximo 25 caracteres'
            ]
        );
        /**
         * Se envia el parametro nombre a la implementacion que creara un nuevo cliente
         */
        $estatus = $this->cliente->newCliente($request['nombre']);
        return response()->json($estatus,array_key_exists('error',$estatus) ? 500 : 200);
    }

    /** Actualiza el nombre del cliente
     * @param Request $request
     * 
     * @return object
     */
    public function updateCliente(Request $request):object
    {
        $request = $request->validate(
            [
                'nombre' => 'required|min:5|max:25',
                'id' =>'required'

            ],
            [
                'nombre.required' => 'El nombre es requerido',
                'nombre.min' => 'El nombre es muy corto minimo 5 caracteres',
                'nombre.max' => ' El nombre es muy largo maximo 25 caracteres',
                'id.required' => ' El id es requerido'
            ]
        );  
        /**
         * Se envia parametro id y nombre a la classe implemntadora para actualizar el cliente
         */
        $estatus = $this->cliente->updateCliente($request['id'],$request['nombre']);
        return response()->json($estatus,array_key_exists('error',$estatus) ? 500 : 200);
    }
    /** Elimina un cliente
     * @param Request $request
     * 
     * @return object
     */
    public function deleteCliente(Request $request):object
    {
        $id = $request->query('id');
        /**
         * Se envia el parametro id a la clase implementadora para eliminar el cliente
         */
        $estatus = $this->cliente->deleteCliente($id);
        return response()->json($estatus,array_key_exists('error',$estatus) ? 500 : 200);
    }
    /** Retorna el listado de clientes
     * @return object
     */
    public function indexCliente():object
    {
        $estatus = $this->cliente->indexCliente();
        return response()->json($estatus,array_key_exists('error',$estatus) ? 500 : 200);
    }
}