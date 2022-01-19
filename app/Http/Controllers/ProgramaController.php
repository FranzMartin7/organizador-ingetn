<?php

namespace App\Http\Controllers;

use App\Models\Programa;
use Illuminate\Http\Request;

class ProgramaController extends Controller
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
            'mencione_id'=> 'required',
            'semestre'=> 'required'
        ]);
        $respuesta = Programa::create([
            'materia_id'=>request('materia'),
            'mencione_id'=>request('mencione_id'),
            'semestre_id'=>request('semestre')
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
        $programas = Programa::join('materias','materias.id','programas.materia_id')
        ->join('semestres','semestres.id','programas.semestre_id')
        ->join('menciones','menciones.id','programas.mencione_id')
        ->join('areas','areas.id','materias.area_id')
        ->where('programas.mencione_id',$id)
        ->where('materias.estado_id',2)
        ->selectRaw("
            materias.nombreMat,
            materias.sigla,
            semestres.semestre,
            menciones.mencion,
            areas.area,
            programas.*
            ")
        ->orderBy('semestres.id','asc')
        ->orderBy('materias.nombreMat','asc')
        ->get();
        return response()->json($programas);
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
            'mencione_id'=> 'required',
            'semestre'=> 'required'
        ]);
        $respuesta = Programa::find($request->id);
        $respuesta->materia_id = $request->materia;
        $respuesta->mencione_id = $request->mencione_id;
        $respuesta->semestre_id = $request->semestre;
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
        $respuesta = Programa::find($id);
        $respuesta->delete();
        return response()->json($id);
    }
}
