<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use Illuminate\Http\Request;

class GrupoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'materia'=> 'required',
            'grupo'=> 'required'
        ]);
        $respuesta = Grupo::create([
            'materia_id'=>request('materia'),
            'grupo'=>request('grupo')
        ]);
        return response()->json($respuesta);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $grupos = Grupo::join('materias','materias.id','grupos.materia_id')
        ->where('materias.estado_id',2)  
        ->selectRaw("materias.nombreMat,
            materias.sigla,
            grupos.*
            ")
        ->orderBy('materias.nombreMat','asc')
        ->orderBy('grupo','asc')
        ->get();
        return response()->json($grupos);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'materia'=> 'required',
            'grupo'=> 'required'
        ]);
        $respuesta = Grupo::find($request->id);
        $respuesta->materia_id = $request->materia;
        $respuesta->grupo = $request->grupo;
        $respuesta->save();
        return response()->json($respuesta);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $respuesta = Grupo::find($id);
        $respuesta->delete();
        return response()->json($respuesta);
    }
}
