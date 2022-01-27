<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use App\Models\Programa;
use App\Models\Evento;
use Illuminate\Http\Request;


class HorarioController extends Controller
{
    public function generarEventos(Request $request){
        $request->validate([
            'periodo'=> 'required',
            'gestion'=> 'required',
            'asignatura'=> 'required',
            'dia'=> 'required',
            'aula'=> 'required',
            'hora_inicio'=> 'required',
            'hora_final'=> 'required|after:hora_inicio',
            'generado'=> 'required'
        ]);
        switch ($request->periodo) {
            case '1':
                $fechaInicio = strtotime($request->gestion.'-02-01');
                $fechaFinal = strtotime($request->gestion.'-06-30');
                break;
            case '2':
                $fechaInicio = strtotime($request->gestion.'-08-01');
                $fechaFinal = strtotime($request->gestion.'-12-31');
                break;
            case '3':
                $fechaInicio = strtotime($request->gestion.'-01-01');
                $fechaFinal = strtotime($request->gestion.'-01-31');
                break;
            case '4':
                $fechaInicio = strtotime($request->gestion.'-07-01');
                $fechaFinal = strtotime($request->gestion.'-07-31');
                break;
        };
        for($i=$fechaInicio; $i<=$fechaFinal; $i+=86400){
            $dias = date('N',$i);
            if($dias==$request->dia){
                $fecha = date("Y-m-d",$i);
                $respuesta = Evento::create([
                    'periodo_id'=>request('periodo'),
                    'gestion'=>request('gestion'),
                    'asignatura_id'=>request('asignatura'),
                    'fecha'=>$fecha,
                    'aula_id'=>request('aula'),
                    'horaInicio'=>request('hora_inicio'),
                    'horaFinal'=>request('hora_final'),
                    'actividade_id'=>request('actividade_id'),
                    'acontecimiento_id'=>1,
                ]);
            }
        }
        return response()->json($respuesta);
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
            'periodo'=> 'required',
            'gestion'=> 'required',
            'asignatura'=> 'required',
            'dia'=> 'required',
            'aula'=> 'required',
            'hora_inicio'=> 'required',
            'hora_final'=> 'required|after:hora_inicio',
            'generado'=> 'required'
        ]);
        $respuesta = Horario::create([
            'asignatura_id'=>request('asignatura'),
            'dia'=>request('dia'),
            'horaInicio'=>request('hora_inicio'),
            'horaFinal'=>request('hora_final'),
            'aula_id'=>request('aula'),
            'generado'=>request('generado'),
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
    public function show(Request $request)
    {
        $idNivel = $request->user()->nivele_id;
        $horarios = Programa::join('materias','materias.id','programas.materia_id')
        ->join('grupos','grupos.materia_id','materias.id')
        ->join('asignaturas','grupos.id','asignaturas.grupo_id')
        ->join('users','users.id','asignaturas.user_id')
        ->join('horarios','horarios.asignatura_id','asignaturas.id')
        ->join('aulas','aulas.id','horarios.aula_id')
        ->join('actividades','actividades.id','asignaturas.actividade_id')
        ->join('titulos','titulos.id','users.titulo_id')
        ->join('periodos','periodos.id','horarios.periodo_id')
        ->where('programas.semestre_id', $request->idSemestre)
        ->where('programas.mencione_id', $request->idMencion)
        ->where('horarios.periodo_id', $request->idPeriodo)
        ->where('horarios.gestion', $request->gestion)
        ->where('asignaturas.estado_id',2) 
        ->where('materias.estado_id',2) 
        ->selectRaw("materias.sigla as title,
            horarios.horaInicio as startTime,
            horarios.horaFinal as endTime,
            horarios.id as idHorario,
            horarios.id as groupId,
            concat('[',horarios.dia,']') as daysOfWeek,
            horarios.dia,
            asignaturas.actividade_id as idActividad,
            horarios.asignatura_id as idAsignatura,
            horarios.aula_id as idAula,
            horarios.generado,
            horarios.periodo_id as idPeriodo, 
            horarios.gestion,        
            grupos.grupo,
            grupos.id as idGrupo,
            materias.nombreMat,
            materias.color,
            aulas.aulaAbrev,
            'true' as filtrado,
            aulas.aula,
            actividades.actividad,
            periodos.periodoAbrev,
            concat(titulos.tituloAbrev,' ',users.apPaterno) as docAbrev")
        ->get()->toArray();
        $idGrupo = $request->idGrupo;
        $idAsignatura = $request->idAsignatura;
        $idActividad = $request->idActividad;
        $idAula = $request->idAula;
        $modoEdicion = $request->modoEdicion;
        if (!empty($idAsignatura)  || !empty($idActividad) || !empty($idAula)  || !empty($idGrupo) || $modoEdicion!='false') {
            $mostrarEventos = new MostrarEventos();
            $resultado = $mostrarEventos->filtros($horarios,$idGrupo,$idActividad,$idAsignatura,$idAula,$modoEdicion,$idNivel);
        } else {
            $resultado = $horarios;
        }        
        return response()->json($resultado);
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
            'periodo'=> 'required',
            'gestion'=> 'required',
            'asignatura'=> 'required',
            'dia'=> 'required',
            'aula'=> 'required',
            'hora_inicio'=> 'required',
            'hora_final'=> 'required|after:hora_inicio',
            'generado'=> 'required'
        ]);
        $respuesta = Horario::find($request->id);
        $respuesta->asignatura_id = $request->asignatura;
        $respuesta->dia = $request->dia;
        $respuesta->horaInicio = $request->hora_inicio;
        $respuesta->horaFinal = $request->hora_final;
        $respuesta->aula_id = $request->aula;
        $respuesta->generado = $request->generado;
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
        $respuesta = Horario::find($id);
        $respuesta->delete();
        return response()->json($id);
    }
}
