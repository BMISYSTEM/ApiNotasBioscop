<?php

namespace App\Http\Controllers\Os;

use App\Http\Controllers\Controller;
use App\Models\OsApuntamiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

// interfaz 
interface OsApuntamientoInterfaz 
{
  
    /** Crea una nota o apuntamiento
     * @param int $id_user
     * @param int $id_os
     * @param int $id_estado
     * @param string $nota
     * @param string $fecha
     * @param string $hora
     * 
     * @return array
     */
    public function newApuntamientoOs( 
                                        int $id_os,
                                        int $id_estado,
                                        string $nota,
                                        string $fecha,
                                        string $hora):array;

    /** Actualiza una nota o apuntamiento
     * @param int $id_apuntamiento
     * @param int $id_estado
     * @param string $nota
     * @param string $fecha
     * @param string $hora
     * 
     * @return array
     */
    public function updateApuntamientoOs(   int $id_apuntamiento,
                                            int $id_estado,
                                            string $nota,
                                            string $fecha,
                                            string $hora):array;

    /** Elimina un apuntamiento
     * @param int $id_apuntamiento
     * 
     * @return array
     */
    public function deleteApuntamientoOs(int $id_apuntamiento):array;
    /** Consulta todos los apuntamientos de una OS
     * @param int $id_os
     * 
     * @return array
     */
    public function indexApuntamientoOs(int $id_os):array;
}
// implementacion
class OsApuntamientoImplement implements OsApuntamientoInterfaz
{
    public function newApuntamientoOs(
                                        int $id_os,
                                        int $id_estado,
                                        string $nota,
                                        string $fecha,
                                        string $hora):array
    {
        try {
            $id_user = Auth::user()->id;
            $apuntamiento = OsApuntamiento::create([
                'id_user' => $id_user,
                'id_os' => $id_os,
                'id_estado' => $id_estado,
                'nota' => $nota,
                'fecha' => $fecha,
                'hora' => $hora
            ]);
            return ['succes' => 'Se creo la nota de forma correcta'];
        } catch (\Throwable $th) {
            return ['error' => 'Error inesperado del lado del servidor. '.$th];
        }
    }
    public function updateApuntamientoOs(   int $id_apuntamiento,
                                            int $id_estado,
                                            string $nota,
                                            string $fecha,
                                            string $hora):array
    {
        try {
            $apuntamiento = OsApuntamiento::find($id_apuntamiento);
            $apuntamiento->id_estado = $id_estado;
            $apuntamiento->nota = $nota;
            $apuntamiento->fecha = $fecha;
            $apuntamiento->hora = $hora;
            $apuntamiento->save();
            return ['succes' => 'Se Actualizo de forma correcta'];
        } catch (\Throwable $th) {
            return ['error' => 'Error inesperado del lado del servidor. '.$th];
        }
    }
    public function deleteApuntamientoOs(int $id_apuntamiento):array
    {
        try {
            $apuntamiento = OsApuntamiento::find($id_apuntamiento);
            $apuntamiento->delete();
            return ['succes' => 'Se Eliminino de forma correcta'];
        } catch (\Throwable $th) {
            return ['error' => 'Error inesperado del lado del servidor. '.$th];
        }
    }
    public function indexApuntamientoOs(int $id_os):array
    {
        try {
            $apuntamientos = DB::select('
            select 
            ap.nota,ap.fecha,ap.hora,ap.id_os,ap.id_user,ap.id_estado,ap.id as id_apunte,
            u.name as nombre_usuario,
            e.nombre as nombre_estado,
            e.id,e.color
            from os_apuntamientos ap
            inner join users u on ap.id_user = u.id
            inner join os o on ap.id_os = o.id
            inner join estados e on ap.id_estado = e.id
            where ap.id_os = '.$id_os.' order by ap.fecha desc
            ');
            return ['succes' => $apuntamientos];
        } catch (\Throwable $th) {
            return ['error' => 'Error inesperado del lado del servidor. '.$th];
        }
    }
}

// controller
class OsApuntamientoController extends Controller
{
    private $apuntamiento;
    public function __construct(OsApuntamientoImplement $apuntamiento)
    {
        $this->apuntamiento = $apuntamiento;
    }
    public function newApuntamientoOs(Request $request):object
    {
        $request = $request->validate(
            [
                'id_os'     => 'required|exists:os,id',
                'id_estado' => 'required|exists:estados,id',
                'nota'      => 'required|min:10|max:500',
                'fecha'     => 'required',
                'hora'      => 'required'
            ],
            [
                'id_os.required' => 'El campo id_os es obligatorio',
                'id_estado.required' => 'El campo id_estado es obligatorio',
                'nota.required' => 'El campo nota es obligatorio',
                'fecha.required' => 'El campo fecha es obligatorio',
                'hora.required' => 'El campo hora es obligatorio',
                'id_os.exists' => 'El id_os no exite',
                'id_estado.exists' => 'El id_estado no exite',
                'nota.min' => 'La nota requiere minimo 10 caracteres',
                'nota.max' => 'La nota requiere maximo 500 caracteres',
                'fecha.required'     => 'El campo fecha es obligatorio',
                'hora.required'      => 'El campo hora es obligatorio'
            ]
        );
        $estatus = $this->apuntamiento->newApuntamientoOs(  $request['id_os'],
                                                            $request['id_estado'],
                                                            $request['nota'],
                                                            $request['fecha'],
                                                            $request['hora']);
        return response()->json($estatus,array_key_exists('error',$estatus) ? 500 : 200);
    }
    public function updateApuntamientoOs(Request $request):object
    {
        $request = $request->validate(
            [
                'id_apuntamiento'     => 'required|exists:os_apuntamientos,id',
                'id_estado' => 'required|exists:estados,id',
                'nota'      => 'required|min:10|max:500',
                'fecha'     => 'required',
                'hora'      => 'required'
            ],
            [
                'id_apuntamiento.required' => 'El campo id apuntamiento es obligatorio',
                'id_apuntamiento.exists' => 'El apuntamiento no existe',
                'id_estado.required' => 'El campo id_estado es obligatorio',
                'nota.required' => 'El campo nota es obligatorio',
                'fecha.required' => 'El campo fecha es obligatorio',
                'hora.required' => 'El campo hora es obligatorio',
                'id_estado.exists' => 'El id_estado no exite',
                'nota.min' => 'La nota requiere minimo 10 caracteres',
                'nota.max' => 'La nota requiere maximo 500 caracteres',
                'fecha.required'     => 'El campo fecha es obligatorio',
                'hora.required'      => 'El campo hora es obligatorio'
            ]
        );
        $estatus = $this->apuntamiento->updateApuntamientoOs(   $request['id_apuntamiento'],
                                                                $request['id_estado'],
                                                                $request['nota'],
                                                                $request['fecha'],
                                                                $request['hora']);
        return response()->json($estatus,array_key_exists('error',$estatus) ? 500 : 200);
    }
    public function deleteApuntamientoOs(Request $request):object
    {
        $id = $request->query('id');
        $estatus = $this->apuntamiento->deleteApuntamientoOs($id);
        return response()->json($estatus,array_key_exists('error',$estatus) ? 500 : 200);
    }
    public function indexApuntamientoOs(Request $request):object
    {
        $id = $request->query('id');
        $estatus = $this->apuntamiento->indexApuntamientoOs($id);
        return response()->json($estatus,array_key_exists('error',$estatus) ? 500 : 200);

    }
}