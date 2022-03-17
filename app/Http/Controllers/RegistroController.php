<?php

namespace App\Http\Controllers;

use App\Models\Registro;
use App\Models\Grupo;
use Illuminate\Http\Request;

class RegistroController extends Controller
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
    public function datosRegistro(Request $request)
    {
        switch ($request->dato) {
            case 'materiasInscritas':
                $registros = Registro::join('users','users.id','registros.user_id')
                ->join('grupos','grupos.id','registros.grupo_id')
                ->join('materias','materias.id','grupos.materia_id')
                ->where('registros.user_id', $request->user()->id)
                ->where('registros.periodo_id', $request->idPeriodo)
                ->where('registros.gestion', $request->gestion)
                ->selectRaw("materias.nombreMat,
                    materias.sigla,
                    grupos.id,
                    grupos.grupo
                    ")
                ->orderBy('materias.nombreMat','asc')
                ->get();
                return response()->json($registros);
            case 'regEstudiante':
                $registros = Registro::join('users','users.id','registros.user_id')
                ->join('grupos','grupos.id','registros.grupo_id')
                ->join('asignaturas','asignaturas.grupo_id','grupos.id')
                ->join('materias','materias.id','grupos.materia_id')
                ->join('periodos','periodos.id','registros.periodo_id')
                ->join('programas','programas.materia_id','materias.id')
                ->join('semestres','programas.semestre_id','semestres.id')
                ->where('registros.user_id', $request->user()->id)
                ->where('registros.periodo_id', $request->idPeriodo)
                ->where('registros.gestion', $request->gestion)
                ->selectRaw("distinct materias.nombreMat,
                    materias.sigla,
                    grupos.id as idGrupo,
                    grupos.grupo,
                    registros.id,
                    registros.updated_at,
                    registros.gestion,
                    registros.periodo_id,
                    programas.semestre_id as idSemestre,
                    semestres.semestre,
                    users.id as idUsuario,
                    concat(periodos.periodoAbrev,' / ',registros.gestion) as semestralAnual,
                    concat(users.apPaterno,' ',users.apMaterno,' ',users.name) as estCompleto
                    ")
                ->orderBy('materias.nombreMat','asc')
                ->get();
                return response()->json($registros);
            case 'regDocente':
                $registros = Registro::join('users','users.id','registros.user_id')
                ->join('grupos','grupos.id','registros.grupo_id')
                ->join('asignaturas','asignaturas.grupo_id','grupos.id')
                ->join('materias','materias.id','grupos.materia_id')
                ->join('periodos','periodos.id','registros.periodo_id')
                ->join('programas','programas.materia_id','materias.id')
                ->join('semestres','programas.semestre_id','semestres.id')
                ->where('grupos.id', $request->idGrupo)
                ->where('registros.periodo_id', $request->idPeriodo)
                ->where('registros.gestion', $request->gestion)
                ->selectRaw("distinct materias.nombreMat,
                    materias.sigla,
                    grupos.id as idGrupo,
                    grupos.grupo,
                    registros.id,
                    registros.updated_at,
                    registros.gestion,
                    registros.periodo_id,
                    programas.semestre_id as idSemestre,
                    semestres.semestre,
                    users.id as idUsuario,
                    concat(periodos.periodoAbrev,' / ',registros.gestion) as semestralAnual,
                    concat(users.apPaterno,' ',users.apMaterno,' ',users.name) as estCompleto
                    ")
                ->orderBy('materias.nombreMat','asc')
                ->get();
                return response()->json($registros);
            default:
                # code...
                break;
        }
    } 
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
            'estudiante'=> 'required',
            'materia'=> 'required|unique:registros,grupo_id,null,id,periodo_id,'.$request->periodo.',gestion,'.$request->gestion.',user_id,'.$request->estudiante,
            'periodo'=> 'required',
            'gestion'=> 'required'
        ]);
        $respuesta = Registro::create([
            'user_id'=>request('estudiante'),
            'grupo_id'=>request('materia'),
            'periodo_id'=>request('periodo'),
            'gestion'=>request('gestion')
        ]);
        return response()->json($respuesta);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id,Request $request)
    {
        $registros = Registro::join('users','users.id','registros.user_id')
        ->join('grupos','grupos.id','registros.grupo_id')
        ->join('materias','materias.id','grupos.materia_id')
        ->join('periodos','periodos.id','registros.periodo_id')
        ->where('materias.estado_id',2) 
        ->where('users.estado_id',2)
        ->where('registros.periodo_id', $request->idPeriodo)
        ->where('registros.gestion', $request->gestion)
        ->selectRaw("materias.nombreMat,
            materias.sigla,
            concat(users.apPaterno,' ',users.apMaterno,' ',users.name) as estCompleto,
            concat(periodos.periodoAbrev,'/',registros.gestion) as semestralAnual,
            registros.id,
            registros.user_id,
            registros.periodo_id,
            registros.gestion,
            registros.grupo_id as idGrupo,
            registros.updated_at,
            grupos.grupo
            ")
        ->orderBy('users.apPaterno','asc')
        ->orderBy('materias.nombreMat','asc')
        ->get();
        return response()->json($registros);
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
            'estudiante'=> 'required',
            'materia'=> 'required|unique:registros,grupo_id,'.$request->id.',id,periodo_id,'.$request->periodo.',gestion,'.$request->gestion,
            'periodo'=> 'required',
            'gestion'=> 'required'
        ]);
        $respuesta = Registro::find($request->id);
        $respuesta->user_id = $request->estudiante;
        $respuesta->grupo_id = $request->materia;
        $respuesta->periodo_id = $request->periodo;
        $respuesta->gestion = $request->gestion;
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
        $registro = Registro::findOrFail($id);
        Registro::destroy($id);
        return response()->json($id);
    }
}
