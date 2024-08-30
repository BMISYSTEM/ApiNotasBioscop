<?php 

namespace App\Http\Controllers\Notas;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Notas\interfaces\NotasInterfaces;
use App\Http\Interfaces\CreateUserInterface;
use App\Models\Nota;
use App\Models\OsApuntamiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

// implementacion
class Notasimplement implements NotasInterfaces
{
  public function NewNote(string $text, string $datai,string $dataf,string $horai,string $horaf,int $reunion, int $apuntamiento): array
  {
    try {
      $idUser = Auth::user()->id;
      $nota = Nota::create([
        'text' => $text,
        'fecha_inicio' => $datai,
        'fecha_fin' => $dataf,
        'hora_inicio' => $horai,
        'hora_fin' => $horaf,
        'user_id' => $idUser,
        'reunion' => $reunion,
        'apuntamiento'=>$apuntamiento
      ]);
      return ['succes'=> 'Se creo la nota de forma correcta'];
    } catch (\Throwable $th) {
      return ['error'=> 'Error inesperado en el servidor error:'.$th];
    }
  }
  public function index(string $dataMin): array
  {
    try {
      $idUser = Auth::user()->id;
      $index = DB::select('
      select * from notas 
      where  '. $dataMin .' BETWEEN fecha_inicio and fecha_fin  ');
      return ['succes'=>$index]; 
    } catch (\Throwable $th) {
      return ['error'=> 'Error inesperado en el servidor error: '. $th];
    }
  }
  public function indexGantt(int $mes): array
  {
    try {
      $idUser = Auth::user()->id;
      $index = DB::select('
      select *,DAY(fecha_inicio) as dia_inicio,DAY(fecha_fin) as dia_fin   from notas 
      where  '. $mes .' BETWEEN MONTH(fecha_inicio) and MONTH(fecha_fin)');
      return ['succes'=>$index]; 
    } catch (\Throwable $th) {
      return ['error'=> 'Error inesperado en el servidor error: '. $th];
    }
  }

  public function update(int $id, string $text, string $data): array
  {
    try {
      $nota = Nota::find($id);
      $nota->text = $text;
      $nota->data = $data;
      $nota->save();
      return ['succes'=>'La nota fue actualizada de forma correcta'];
    } catch (\Throwable $th) {
      return ['error' => 'Error inesperado se presento en el servidor '. $th];
    }
  }
  public function delete($id): array
  {
    try {
      $nota = Nota::find($id);
      $nota->delete();
      return ['succes'=>'La nota fue eliminada de manera correcta'];
    } catch (\Throwable $th) {
      return ['error'=>'Error inesperado en el servidor '.$th ];
    }
  }
  public function getResumen(): array
  {
    try {
      $tareasPendientes = DB::select('select count(*) tareasPendientes from notas where completado = 0');
      $tareasCompletas = DB::select('select count(*) tareasCompletas from notas where completado = 1');
      $reuniones = DB::select('select count(*) reuniones from notas where reunion = 1');
      $reunionesPendientes = DB::select('select count(*) reunionesPendientes from notas where reunion = 1 and completado = 0');
      return ['succes'=>[ $tareasPendientes[0],
                          $tareasCompletas[0],
                          $reuniones[0],
                          $reunionesPendientes[0]]];
    } catch (\Throwable $th) {
      return ['error'=>'Error inesperado en el servidor '.$th];
    }
  }
  public function confirmaNota(string $comentario, string $data, string $horai, string $horaf, int $os, int $id_nota,int $id_estado): array
  {
    try {
      $id_user = Auth::user()->id;
      /**Confirmacion de nota  */
      $nota = Nota::find($id_nota);
      $nota->completado = 1;
      /** Crear el apuntamiento  */
      $apuntamiento = OsApuntamiento::create(
        [
          'id_user' => $id_user,
          'id_os' => $os,
          'id_estado'=>$id_estado,
          'nota' => $comentario,
          'fecha' => $data,
          'hora' => $horai
        ]
        );
      $nota->save();
      return ['succes'=>'Se confirmo la nota de forma exitosa y se genero el apuntamiento '];
    } catch (\Throwable $th) {
      return ['error'=>'Error inesperado en el servidor '.$th];
    }
  }
}
// controlador
class NotasController extends Controller
{
    private $nota;
    public function __construct(Notasimplement $Notas)
    {
      $this->nota = $Notas; 
    }
  
    /** crea un nueva nota 
     * @param Request $request
     * 
     * @return object
     */
    public function NewNote(Request $request): object
    {
      $request = $request->validate(
        [
          'text' => 'required|min:10|max:500',
          'datai' => 'required|date',
          'dataf' => 'required|date',
          'horai' => 'required',
          'horaf' => 'required',
          'reunion' => 'required|integer',
          'apuntamiento' => 'required|integer',
        ],
        [
          'text.required' => 'Se requiere el texto',
          'datai.required' => 'Se requiere fecha de inicio',
          'dataf.required' => 'Se requiere fecha final',
          'horai.required' => 'Se requiere hora inicial',
          'horaf.required' => 'Se requiere hora final',
          'text.min' => 'Minimo se permiten 10 carcateres',
          'text.max' => 'Maximo se permiten 500 caracteres',
          'reunion.required' => 'Se requiere el check de reunion ya sea 0 o 1 ',
          'reunion.integer' => 'reunion Debe ser numerico',
          'apuntamiento.integer' => 'apuntamiento Debe ser numerico',
          'apuntamiento.required' => 'Se requiere el check de apuntamiento ya sea 0 o 1 '       
           ]
      );
      $estatus = $this->nota->NewNote($request['text'],$request['datai'],$request['dataf'],$request['horai'],$request['horaf'],$request['reunion'],$request['apuntamiento']);
      return response()->json($estatus,array_key_exists('error',$estatus) ? 500 : 200);
    }
    
    /** devuelve todos las notas de un periodo de tiempo
     * @param Request $request
     * 
     * @return object
     */
    public function index(Request $request): object
    {
      $dataMin = $request->query('min');
      $estatus = $this->nota->index($dataMin);
      return response()->json($estatus,array_key_exists('error',$estatus) ? 500 : 200);
    } 
    /** devuelve todos las notas de un mes seleccionado de tiempo
     * @param Request $request
     * 
     * @return object
     */
    public function indexGantt(Request $request): object
    {
      $mes = $request->query('mes');
      $estatus = $this->nota->indexGantt($mes);
      return response()->json($estatus,array_key_exists('error',$estatus) ? 500 : 200);
    } 
    /** Ejecuta la implementacion de update que actualiza una nota
     * @param Request $request
     * 
     * @return object
     */
    public function update(Request $request): object
    {
      $request = $request->validate(
        [
          'id'    => 'required',
          'text'  => 'required|min:10|max:500',
          'data'  =>'required'
        ],
        [
          'id.required'   => 'El campo id es requerido',
          'text.required' => 'El campo text es requerido',
          'text.min'      => 'El campo text debe tener minimo 10 caracteres',
          'text.max'      => 'El campo text debe tener maximo 500 caracteres',
          'data.required' => 'El campo data es requerido'
        ]
      );
      $estatus = $this->nota->update($request['id'],$request['text'],$request['data']);
      return response()->json($estatus,array_key_exists('error',$estatus) ? 500 : 200);
    }

    /** Elimina una nota 
     * @param Request $request
     * 
     * @return object
     */
    public function delete(Request $request):object
    {
      $id = $request->query('id');
      $estatus = $this->nota->delete($id);
      return response()->json($estatus,array_key_exists('error',$estatus) ? 500 : 200);
    }

    public function getResumen():object
    {
      $estatus = $this->nota->getResumen();
      return response()->json($estatus,array_key_exists('error',$estatus) ? 500 : 200);
    }

    public function confirmaNota(Request $request):object
    {
      $request = $request->validate(
        [
          'comentario' => 'required',
          'data'  => 'required',
          'horai' => 'required',
          'horaf' => 'required',
          'os' => 'required|exists:os,id',
          'id_nota' => 'required|exists:notas,id',
          'id_estado' => 'required|exists:estados,id',
        ],
        [
          'comentario.required' => 'El comentario es obligatorio',
          'data.required' => 'El campo fecha es obligatorio',
          'horai.required' => 'La hora inicial es obligatorio',
          'horaf.required' => 'la hora final es obligatorio',
          'os.required' => 'la os es obligatorio',
          'os.exists' => 'la os no existe',
          'id_nota.exists' => 'el id de nota no existe',
          'id_nota.required' => 'El id_nota es obligatorio',
          'id_estado.exists' => 'el estado no existe',
          'id_estado.required' => 'El estado es obligatorio',
        ]
        );
      $estatus = $this->nota->confirmaNota($request['comentario'],$request['data'],$request['horai'],$request['horaf'],$request['os'],$request['id_nota'],$request['id_estado']);
      return response()->json($estatus,array_key_exists('error',$estatus) ? 500 : 200);
    }
}