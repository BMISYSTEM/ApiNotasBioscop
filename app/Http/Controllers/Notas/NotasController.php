<?php 

namespace App\Http\Controllers\Notas;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Notas\interfaces\NotasInterfaces;
use App\Http\Interfaces\CreateUserInterface;
use App\Models\Nota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


// implementacion
class Notasimplement implements NotasInterfaces
{
  public function NewNote(string $text, string $data): array
  {
    try {
      $idUser = Auth::user()->id;
      $nota = Nota::create([
        'text' => $text,
        'data' => $data,
        'user_id' => $idUser
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
      $index = Nota::where('user_id',$idUser)->where('data',$dataMin)->get();
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
          'data' => 'required|date',
        ],
        [
          'text.required' => 'Se requiere el texto',
          'data.required' => 'Se requiere fecha',
          'text.min' => 'Minimo se permiten 10 carcateres',
          'text.max' => 'Maximo se permiten 500 caracteres'
        ]
      );
      $estatus = $this->nota->NewNote($request['text'],$request['data']);
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
}