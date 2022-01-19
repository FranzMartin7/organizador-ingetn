<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aula;
use App\Models\Actividade;
use App\Models\Evento;
use App\Models\Asignatura;
use App\Models\Semestre;
use App\Models\Mencione;
use App\Models\Materia;
use App\Models\User;
use App\Models\Programa;

class EventoController extends Controller
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
            'periodo' => 'required',
            'gestion' => 'required',
            'asignatura' => 'required',
            'fecha' => 'required',
            'aula' => 'required',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_final' => 'required|date_format:H:i',
            'actividad' => 'required',
            'tema_desarrollado' => 'required',
            'acontecimiento_id' => 'required',
        ]);
        $respuesta = Evento::create([
            'periodo_id'=>request('periodo'),
            'gestion'=>request('gestion'),
            'asignatura_id'=>request('asignatura'),
            'fecha'=>request('fecha'),
            'aula_id'=>request('aula'),
            'horaInicio'=>request('hora_inicio'),
            'horaFinal'=>request('hora_final'),
            'actividade_id'=>request('actividad'),
            'descripcion'=>request('tema_desarrollado'),
            'enlace'=>request('enlace'),
            'acontecimiento_id'=>request('acontecimiento_id'),
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
        $eventos = Programa::join('materias','materias.id','programas.materia_id')
        ->join('grupos','grupos.materia_id','materias.id')
        ->join('asignaturas','grupos.id','asignaturas.grupo_id')
        ->join('users','users.id','asignaturas.user_id')
        ->join('eventos','eventos.asignatura_id','asignaturas.id')
        ->join('aulas','aulas.id','eventos.aula_id')
        ->join('actividades','actividades.id','eventos.actividade_id')
        ->join('titulos','titulos.id','users.titulo_id')
        ->join('periodos','periodos.id','eventos.periodo_id')
        ->where('programas.semestre_id', $request->idSemestre)
        ->where('programas.mencione_id', $request->idMencion)
        ->where('eventos.periodo_id', $request->idPeriodo)
        ->where('eventos.gestion', $request->gestion)
        ->where('asignaturas.estado_id',2) 
        ->selectRaw("materias.sigla as title,
            concat(eventos.fecha,'T',eventos.horaInicio) as start,
            concat(eventos.fecha,'T',eventos.horaFinal) as end,
            eventos.id as idEvento,
            eventos.acontecimiento_id as idAcontecimiento,
            eventos.actividade_id as idActividad,
            eventos.asignatura_id as idAsignatura,
            eventos.descripcion,
            eventos.enlace,
            eventos.aula_id as idAula,
            eventos.periodo_id as idPeriodo,
            eventos.gestion,      
            grupos.grupo,
            'true' as filtrado,
            grupos.id as idGrupo,
            materias.nombreMat,
            materias.color,
            aulas.aulaAbrev,
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
            $resultado = $mostrarEventos->filtros($eventos,$idGrupo,$idActividad,$idAsignatura,$idAula,$modoEdicion,$idNivel);
        } else {
            $resultado = $eventos;
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
            'periodo' => 'required',
            'gestion' => 'required',
            'asignatura' => 'required',
            'fecha' => 'required',
            'aula' => 'required',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_final' => 'required|date_format:H:i',
            'actividad' => 'required',
            'tema_desarrollado' => 'required',
            'acontecimiento_id' => 'required',
        ]); 
        $respuesta = Evento::find($request->id);
        $respuesta->periodo_id = $request->periodo;
        $respuesta->gestion = $request->gestion;
        $respuesta->asignatura_id = $request->asignatura;
        $respuesta->fecha = $request->fecha;
        $respuesta->aula_id = $request->aula;
        $respuesta->horaInicio = $request->hora_inicio;
        $respuesta->horaFinal = $request->hora_final;
        $respuesta->actividade_id = $request->actividad;
        $respuesta->descripcion = $request->tema_desarrollado;
        $respuesta->enlace = $request->enlace;
        $respuesta->acontecimiento_id = $request->acontecimiento_id;
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
        $respuesta = Evento::find($id);
        $respuesta->delete();
        return response()->json($id);
    }
}
