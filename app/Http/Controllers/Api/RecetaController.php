<?php

namespace App\Http\Controllers\Api;

use App\Models\Receta;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\IndexRecetaRequest;
use App\Http\Requests\Api\CreateRecetaRequest;
use App\Http\Requests\Api\UpdateRecetaRequest;

class RecetaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IndexRecetaRequest $request)
    {
        $input = $request->validated();
        $rows = Receta::search($input);

        return response()->json(['message'=>'Todos los Datos', 'data'=> $rows]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateRecetaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRecetaRequest $request)
    {
        $receta =new Receta();
        $receta->title = $request->input('title');
        $receta->content =$request->input('content');
        $receta->category =$request->input('category');
        $receta->user_id = auth()->user('user_id');
        $receta->save();
        
        return response()->json(['message'=> 'Datos Json', 'data'=>$receta]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $receta = Receta::find($id);

        if($receta){
            return response()->json(['message' =>'Datos obtenidos', 'data'=> $receta]); 
        }
        
        return response()->json(['message' =>'El ID no fue encontrado ', 404]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRecetaRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRecetaRequest $request, Receta $receta)
    {
        $input = $request->validated();

        $receta->update($input);
        $receta->refresh();

        return response()->json(['message' =>'Datos Actualizados', 'data'=> $receta]); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Receta $receta)//Borrado Logico, aun aparece en BD "deleted_at"
    {
        $receta->delete();

        return response()->json(['message' =>'Receta Eliminada, ID '. $receta->id], 202); 
    }

    public function forceDestroy(Receta $receta)//borrado de BD (Borrado fisico)
    {
        $receta->forceDelete();

        return response()->json(['message' =>'Receta Eliminada, ID '. $receta->id], 202); 
    }
}
