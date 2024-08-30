<?php
namespace App\Http\Controllers\Documentacion;
use App\Http\Controllers\Controller;
use App\Models\documentacion_modulo;
use App\Models\documentacion_modulos_detalle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DocumentacionController extends Controller {

    function __construct()
    {
        
    }

    // crear un modulo
    public function createModulo(Request $request)
    {
        $request = $request->validate(
            [
                'nombre' =>'required',
                'sistema'=>'required'
            ],
            [
                'nombree.required'=>'el nombre es requerido',
                'sistema.required'=>'el sistema es requerido'
            ]
            );
        $estatus = documentacion_modulo::create([
            'nombre'=>$request['nombre'],
            'sistema'=>$request['sistema']
        ]);

        return response()->json('Se creo el modulo...');
    }

    // leer modulos 
    public function allModulos()
    {
        $estatus = documentacion_modulo::all();
        return response()->json($estatus);
    }

    // editar modulos
    public function updateModulo(Request $request)
    {
        $request = $request->validate(
            [
                'id_modulo'=>'required',
                'nombre' =>'required',
                'sistema'=>'required'
            ],
            [
                'id_modulo.required'=>'el id es obligatorio',
                'nombree.required'=>'el nombre es requerido',
                'sistema.required'=>'el sistema es requerido'
            ]
            );
        $update = documentacion_modulo::find($request['id_modulo']);
        $update->nombre = $request['nombre'];
        $update->sistema = $request['sistema'];
        $update->save();
        return response()->json('Se edito el modulo...');
    }

    // elimina modulos
    public function deleteModulo(Request $request)
    {
        $id = $request->query('id');
        $delete = documentacion_modulo::find($id)->delete();
        return response()->json('Se elimino el modulo...');
        
    }

    // agregar documentacion
    public function createDocumentacion(Request $request)
    {
        $request = $request->validate(
            [
                'posicion'=>'required',
                'tipo'=>'required',
                'title'=>'required',
                'image'=>'required',
                'text'=>'required',
                'id_modulo'=>'required'
            ]
            );
        $estatus = documentacion_modulos_detalle::create([
            'posicion'=>$request['posicion'],
            'tipo'=>$request['tipo'],
            'title'=>$request['title'],
            'image'=>$request['image'],
            'text'=>$request['text'],
            'id_modulo'=>$request['id_modulo'],
        ]);

        return response()->json('Se actualizo el documento...');
    }
    // consulta toda la documentacion de un modulo
    public function allDocumentacion(Request $request)
    {
        $id = $request->query('id');
        $estatus = DB::select('select * from documentacion_modulos_detalles where id_modulo = '.$id);
        return response()->json($estatus);
    }
    // editar documentacion
    public function updateDocumentacion(Request $request)
    {
        $request = $request->validate(
            [
                'posicion'=>'required',
                'tipo'=>'required',
                'title'=>'required',
                'image'=>'required',
                'text'=>'required',
                'id_modulo'=>'required',
                'id_documentacion'=>'required'
            ],
            [
                'nombree.required'=>'el nombre es requerido',
                'sistema.required'=>'el sistema es requerido'
            ]
            );
        $update = documentacion_modulos_detalle::find($request['id_documentacion']);
        $update->posicion  = $request['posicion'];
        $update->tipo  = $request['tipo'];
        $update->title  = $request['title'];
        $update->image  = $request['image'];
        $update->text  = $request['text'];
        $update->id_modulo  = $request['id_modulo'];
        $update->save();
        return response()->json('Se edito el documento...');
    }

    // eliminar documentacion

    public function deleteDocumentacion(Request $request)
    {
        $id = $request->query('id');
        $delete = documentacion_modulos_detalle::find($id)->delete();
        return response()->json('Se elimino el withget...');
        
    }




}