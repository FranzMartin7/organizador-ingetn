<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use Illuminate\Http\Request;

class MateriaController extends Controller
{
    public function datosMateria(Request $request)
    {
        switch ($request->dato) {
            case 'noMencion':               
                $materiasMencion = Materia::join('programas','programas.materia_id','materias.id')
                
                ->where('programas.mencione_id',$request->idMencion) 
                ->selectRaw("distinct programas.materia_id")   
                /* ->orderBy('materias.nombreMat') */
                ->get()->toArray();
                $materias_id = array();
                foreach ( $materiasMencion as $clave => $valor ) {
                    foreach ( $valor as $key => $value ) {
                        $materias_id[] = $value;
                    }
                }
                $resultado = Materia::join('programas','programas.materia_id','materias.id')
                ->selectRaw("distinct materias.*,programas.materia_id")
                ->whereNotIn('programas.materia_id',$materias_id)
                ->where('materias.estado_id',2)      
                ->orderBy('materias.nombreMat')
                ->get();            
                return response()->json($resultado);
                break;
            case 'siMencion':               
                $resultado = Materia::join('programas','programas.materia_id','materias.id')
                ->selectRaw("distinct materias.*,
                    programas.semestre_id")
                ->where('programas.mencione_id','=',$request->idMencion)  
                ->where('materias.estado_id',2)   
                ->orderBy('materias.nombreMat')
                ->get();
                return response()->json($resultado);
                break;
            default:
                # code...
                break;
        }
    }
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
            'nombre'=> 'required',
            'sigla'=> 'required|max:10',
            'area'=> 'required',
            'estado'=> 'required',
            'color'=> 'required|notIn:#000000'
        ]);
        $respuesta = Materia::create([
            'nombreMat'=>request('nombre'),
            'sigla'=>request('sigla'),
            'area_id'=>request('area'),
            'estado_id'=>request('estado'),
            'color'=>request('color')
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
        $materias = Materia::join('estados','estados.id','materias.estado_id')  
        ->join('areas','areas.id','materias.area_id')  
        ->selectRaw("areas.area,
            estados.estado,
            materias.*
            ")
        ->orderBy('materias.nombreMat','asc')
        ->get();
        return response()->json($materias);
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
            'nombre'=> 'required',
            'sigla'=> 'required|max:10',
            'area'=> 'required',
            'estado'=> 'required',
            'color'=> 'required|notIn:#000000'
        ]);
        $respuesta = Materia::find($request->id);
        $respuesta->nombreMat = $request->nombre;
        $respuesta->sigla = $request->sigla;
        $respuesta->area_id = $request->area;
        $respuesta->color = $request->color;
        $respuesta->estado_id = $request->estado;
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
        $respuesta = Materia::find($id);
        $respuesta->delete();
        return response()->json($id);
    }
}
