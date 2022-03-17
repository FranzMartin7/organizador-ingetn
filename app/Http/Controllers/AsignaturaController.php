<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asignatura;
use App\Models\Mencione;
use App\Models\Programa;
use App\Models\Registro;

class AsignaturaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $asignaturas = Asignatura::all();
        return $asignaturas;
    }
    public function datosAsignatura(Request $request)
    {
        
        switch ($request->dato) {
            case 'todos':
                $resultado = Asignatura::join('grupos','asignaturas.grupo_id','grupos.id')
                ->join('materias','materias.id','grupos.materia_id')
                ->join('users','users.id','asignaturas.user_id')
                ->join('titulos','titulos.id','users.titulo_id')
                ->where('asignaturas.id', $request->identificador)
                ->selectRaw("materias.*,     
                    asignaturas.*,
                    grupos.grupo,
                    concat(titulos.tituloAbrev,' ',users.apPaterno) as docAbrev")
                ->get()->first();
                return response()->json($resultado);
                break;
            case 'gruposSemestre':
                $resultado = Programa::join('materias','materias.id','programas.materia_id')
                ->join('grupos','grupos.materia_id','materias.id')
                ->join('asignaturas','asignaturas.grupo_id','grupos.id')
                ->join('actividades','actividades.id','asignaturas.actividade_id')
                ->where('programas.semestre_id', $request->idSemestre)
                ->where('programas.mencione_id', $request->idMencion)
                ->where('asignaturas.estado_id', 2)
                ->where('materias.estado_id', 2)
                ->selectRaw("distinct materias.nombreMat,
                    materias.sigla,      
                    grupos.id,
                    grupos.grupo")
                ->orderBy('nombreMat')
                ->orderBy('grupo')
                ->get();
                return response()->json($resultado);
                break;
            case 'asigSemestre':
                $resultado = Programa::join('materias','materias.id','programas.materia_id')
                ->join('grupos','grupos.materia_id','materias.id')
                ->join('asignaturas','asignaturas.grupo_id','grupos.id')
                ->join('actividades','actividades.id','asignaturas.actividade_id')
                ->join('users','users.id','asignaturas.user_id')
                ->join('titulos','titulos.id','users.titulo_id')
                ->where('programas.semestre_id', $request->idSemestre)
                ->where('programas.mencione_id', $request->idMencion)
                ->where('asignaturas.estado_id', 2)
                ->where('materias.estado_id', 2)
                ->selectRaw("distinct materias.nombreMat,
                    materias.sigla,
                    actividades.actividad,
                    grupos.grupo,        
                    asignaturas.id,
                    concat(titulos.tituloAbrev,' ',users.apPaterno) as docAbrev")
                ->orderBy('nombreMat')
                ->orderBy('grupo')
                ->get();
                return response()->json($resultado);
                break;
            case 'asigEstudiante':
                $idUsuario = $request->user()->id;
                $resultado = Registro::join('grupos','grupos.id', 'registros.grupo_id')
                ->where('registros.user_id', $idUsuario)
                ->where('registros.periodo_id',$request->idPeriodo)
                ->where('registros.gestion',$request->gestion)
                ->selectRaw("grupos.id")
                ->get()->toArray();
                return response()->json($resultado);
                break;
            default:
                # code...
                break;
        }
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
            'materia'=> 'required|unique:asignaturas,grupo_id,null,id,user_id,'.$request->docente.',actividade_id,'.$request->actividad.',docencia_id,'.$request->docencia,
            'docente'=> 'required',
            'actividad'=> 'required',
            'docencia'=> 'required',
            'carga_horaria'=> 'required|integer|min:0',
            'estado'=> 'required',
        ]);
        $respuesta = Asignatura::create([
            'user_id'=>request('docente'),
            'grupo_id'=>request('materia'),
            'actividade_id'=>request('actividad'),
            'docencia_id'=>request('docencia'),
            'carga'=>request('carga_horaria'),
            'estado_id'=>request('estado')
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
        $asignaturas = Asignatura::join('users','users.id','asignaturas.user_id')
        ->join('grupos','grupos.id','asignaturas.grupo_id')
        ->join('materias','materias.id','grupos.materia_id')
        ->join('titulos','titulos.id','users.titulo_id')
        ->join('actividades','actividades.id','asignaturas.actividade_id')
        ->leftJoin('docencias','docencias.id','asignaturas.docencia_id')
        ->join('estados','estados.id','users.estado_id')
        ->where('materias.estado_id',2) 
        ->where('users.estado_id',2)
        ->selectRaw("actividades.actividad,
            estados.estado,
            materias.nombreMat,
            materias.sigla,
            concat(titulos.tituloAbrev,' ',users.apPaterno) as docAbrev,
            estados.estado,
            asignaturas.id,
            docencias.docencia,
            asignaturas.user_id,
            asignaturas.docencia_id,
            asignaturas.grupo_id as idGrupo,
            asignaturas.actividade_id,
            asignaturas.estado_id,
            asignaturas.carga,
            grupos.grupo
            ")
        ->orderBy('materias.nombreMat','asc')
        ->get();
        return response()->json($asignaturas);
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
            'materia'=> 'required|unique:asignaturas,grupo_id,'.$request->id.',id,user_id,'.$request->docente.',actividade_id,'.$request->actividad.',docencia_id,'.$request->docencia,
            'docente'=> 'required',
            'actividad'=> 'required',
            'docencia'=> 'required',
            'carga_horaria'=> 'required|integer|min:0',
            'estado'=> 'required'
        ]);
        $respuesta = Asignatura::find($request->id);
        $respuesta->user_id = $request->docente;
        $respuesta->grupo_id = $request->materia;
        $respuesta->actividade_id = $request->actividad;
        $respuesta->docencia_id = $request->docencia;
        $respuesta->carga = $request->carga_horaria;
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
        $respuesta = Asignatura::find($id);
        $respuesta->delete();
        return response()->json($respuesta);
    }
}
