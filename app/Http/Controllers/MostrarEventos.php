<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ev_unico;
use App\Models\Asignatura;
use App\Models\Materia;
use App\Models\Registro;
use App\Models\User;
use App\Models\Programa;
use App\Models\Nivele;
use App\Models\Grupo;

class MostrarEventos extends Controller
{
    public function eventosAlarma(Request $request){
        $idUsuario = $request->user()->id;
        $eventos = User::join('asignaturas','asignaturas.user_id','users.id')
        ->join('grupos','grupos.id','asignaturas.grupo_id')
        ->join('materias','materias.id','grupos.materia_id')
        ->join('eventos','eventos.asignatura_id','asignaturas.id')
        ->join('aulas','aulas.id','eventos.aula_id')
        ->join('actividades','actividades.id','eventos.actividade_id')
        ->join('titulos','titulos.id','users.titulo_id')
        ->join('periodos','periodos.id','eventos.periodo_id')
        ->where('users.id', $idUsuario)
        ->whereRaw('eventos.fecha="'.$request->fecha.'"')
        ->whereRaw('eventos.horaInicio BETWEEN "'.$request->tiempoAntes.'" AND "'.$request->tiempoDespues.'"')
        ->where('asignaturas.estado_id',2) 
        ->where('materias.estado_id',2) 
        ->selectRaw("materias.sigla as title,
            eventos.horaInicio,
            eventos.horaFinal,
            eventos.fecha,
            eventos.id as idEvento,
            eventos.descripcion,
            eventos.enlace, 
            eventos.gestion, 
            grupos.grupo,
            materias.nombreMat,
            materias.color,
            aulas.aulaAbrev,
            aulas.aula,
            actividades.actividad,
            periodos.periodoAbrev,
            concat(titulos.tituloAbrev,' ',users.apPaterno) as docAbrev")
        ->get()->toArray();
        return response()->json($eventos);
    }
    public function eventosAlarmaEst(Request $request){
        $idUsuario = $request->user()->id;
        $eventos = Registro::join('grupos','grupos.id','registros.grupo_id')
        ->join('materias','materias.id','grupos.materia_id')
        ->join('asignaturas','asignaturas.grupo_id','grupos.id')
        ->join('eventos','eventos.asignatura_id','asignaturas.id')
        ->join('aulas','aulas.id','eventos.aula_id')
        ->join('actividades','actividades.id','eventos.actividade_id')
        ->join('users','asignaturas.user_id','users.id') 
        ->join('titulos','titulos.id','users.titulo_id') 
        ->join('periodos','periodos.id','eventos.periodo_id')      
        ->where('registros.user_id', $idUsuario)
        ->whereRaw('eventos.fecha="'.$request->fecha.'"')
        ->whereRaw('eventos.horaInicio BETWEEN "'.$request->tiempoAntes.'" AND "'.$request->tiempoDespues.'"')
        ->where('asignaturas.estado_id',2) 
        ->where('materias.estado_id',2) 
        ->selectRaw("materias.sigla as title,
        eventos.horaInicio,
        eventos.horaFinal,
        eventos.fecha,
        eventos.id as idEvento,
        eventos.descripcion,
        eventos.enlace, 
        eventos.gestion, 
        grupos.grupo,
        materias.nombreMat,
        materias.color,
        aulas.aulaAbrev,
        aulas.aula,
        actividades.actividad,
        periodos.periodoAbrev,
        concat(titulos.tituloAbrev,' ',users.apPaterno) as docAbrev")
        ->get()->toArray();
        return response()->json($eventos);
    }
    public function eventosDia(Request $request){
        $idUsuario = $request->user()->id;
        $eventos = User::join('asignaturas','asignaturas.user_id','users.id')
        ->join('grupos','grupos.id','asignaturas.grupo_id')
        ->join('materias','materias.id','grupos.materia_id')
        ->join('eventos','eventos.asignatura_id','asignaturas.id')
        ->join('aulas','aulas.id','eventos.aula_id')
        ->join('actividades','actividades.id','eventos.actividade_id')
        ->join('titulos','titulos.id','users.titulo_id')
        ->join('periodos','periodos.id','eventos.periodo_id')
        ->where('users.id', $idUsuario)
        ->whereRaw('eventos.fecha="'.$request->fecha.'"')
        ->whereRaw('eventos.horaInicio>"'.$request->hora.'"')
        ->where('asignaturas.estado_id',2) 
        ->where('materias.estado_id',2) 
        ->selectRaw("materias.sigla as title,
            eventos.horaInicio,
            eventos.horaFinal,
            eventos.fecha,
            eventos.id as idEvento,
            eventos.descripcion,
            eventos.enlace, 
            eventos.gestion, 
            grupos.grupo,
            materias.nombreMat,
            materias.color,
            aulas.aulaAbrev,
            aulas.aula,
            actividades.actividad,
            periodos.periodoAbrev,
            concat(titulos.tituloAbrev,' ',users.apPaterno) as docAbrev")
        ->get()->toArray();
        return response()->json($eventos);
    }
    public function eventosDocente(Request $request){
        $idUsuario = $request->user()->id;
        $idNivel = $request->user()->nivele_id;
        $eventos = User::join('asignaturas','asignaturas.user_id','users.id')
        ->join('grupos','grupos.id','asignaturas.grupo_id')
        ->join('materias','materias.id','grupos.materia_id')
        ->join('eventos','eventos.asignatura_id','asignaturas.id')
        ->join('aulas','aulas.id','eventos.aula_id')
        ->join('actividades','actividades.id','eventos.actividade_id')
        ->join('titulos','titulos.id','users.titulo_id')
        ->join('periodos','periodos.id','eventos.periodo_id')
        ->where('users.id', $idUsuario)
        ->where('eventos.periodo_id',$request->idPeriodo)
        ->where('eventos.gestion',$request->gestion)
        ->where('asignaturas.estado_id',2) 
        ->where('materias.estado_id',2) 
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
            materias.nombreMat,
            materias.color,
            aulas.aulaAbrev,
            aulas.aula,
            actividades.actividad,
            periodos.periodoAbrev,
            'true' as filtrado,
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
    public function eventosReporte(Request $request){
        $idUsuario = $request->user()->id;
        $eventos = User::join('asignaturas','asignaturas.user_id','users.id')
        ->join('grupos','grupos.id','asignaturas.grupo_id')
        ->join('materias','materias.id','grupos.materia_id')
        ->join('eventos','eventos.asignatura_id','asignaturas.id')
        ->join('aulas','aulas.id','eventos.aula_id')
        ->join('actividades','actividades.id','eventos.actividade_id')
        ->join('titulos','titulos.id','users.titulo_id')
        ->where('asignaturas.estado_id',2) 
        ->where('materias.estado_id',2) 
        ->where('users.id', $idUsuario)
        ->where('eventos.asignatura_id', $request->idAsignatura)
        ->whereRaw('month(eventos.fecha)='.$request->mes)
        ->whereRaw('year(eventos.fecha)='.$request->gestion)
        ->selectRaw("materias.sigla as title,
            eventos.*,        
            grupos.grupo,
            materias.nombreMat,
            materias.color,
            aulas.aulaAbrev,
            aulas.aula,
            actividades.actividad,
            concat(titulos.tituloAbrev,' ',users.apPaterno) as docAbrev")
        ->orderBy('eventos.fecha','asc')
        ->get();
        return response()->json($eventos);
    }
    public function eventosEstudiante(Request $request){
        $idUsuario = $request->user()->id;
        $idNivel = $request->user()->nivele_id;
        $eventos = Registro::join('grupos','grupos.id','registros.grupo_id')
        ->join('materias','materias.id','grupos.materia_id')
        ->join('asignaturas','asignaturas.grupo_id','grupos.id')
        ->join('eventos','eventos.asignatura_id','asignaturas.id')
        ->join('aulas','aulas.id','eventos.aula_id')
        ->join('actividades','actividades.id','eventos.actividade_id')
        ->join('users','asignaturas.user_id','users.id') 
        ->join('titulos','titulos.id','users.titulo_id') 
        ->join('periodos','periodos.id','eventos.periodo_id')      
        ->where('registros.user_id', $idUsuario)
        ->where('eventos.periodo_id',$request->idPeriodo)
        ->where('eventos.gestion',$request->gestion)
        ->where('registros.periodo_id',$request->idPeriodo)
        ->where('registros.gestion',$request->gestion)
        ->where('asignaturas.estado_id',2) 
        ->where('materias.estado_id',2) 
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
            grupos.id as idGrupo,
            materias.nombreMat,
            materias.color,
            aulas.aulaAbrev,
            aulas.aula,
            actividades.actividad,
            periodos.periodoAbrev,
            'true' as filtrado,
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
    public function filtros($eventos,$idGrupo,$idActividad,$idAsignatura,$idAula,$modoEdicion,$idNivel){
        /* $idUsuario = Request::user()->id; */
        $resultado = array();
        foreach ($eventos as $valores) {
            if(!empty($idGrupo) && $idGrupo!=$valores["idGrupo"]){
                $valores["color"]="#626567";
                $valores["filtrado"]=false;
            }elseif(!empty($idActividad) && $idActividad!=$valores["idActividad"]){
                $valores["color"]="#626567";
                $valores["filtrado"]=false;
            }elseif(!empty($idAsignatura) && $idAsignatura!=$valores["idAsignatura"]){
                $valores["color"] = "#626567";
                $valores["filtrado"] = false;
            }elseif(!empty($idAula) && $idAula!=$valores["idAula"]){
                $valores["color"] = "#626567";
                $valores["filtrado"] = false;
            };
            if ($modoEdicion=='true' && $valores['filtrado']=='true') {
                if ($idNivel==1) {
                    $valores["editable"] = true;
                }
                if ($idNivel>1  && $valores['idAcontecimiento']==2) {
                    $valores["editable"] = true;
                }
            }
            $resultado[] = $valores;
        }
        return $resultado;
    }
    public function horAula(Request $request){
        $horarios = Programa::join('materias','materias.id','programas.materia_id')
        ->join('grupos','grupos.materia_id','materias.id')
        ->join('asignaturas','grupos.id','asignaturas.grupo_id')
        ->join('users','users.id','asignaturas.user_id')
        ->join('horarios','horarios.asignatura_id','asignaturas.id')
        ->join('aulas','aulas.id','horarios.aula_id')
        ->join('actividades','actividades.id','asignaturas.actividade_id')
        ->join('titulos','titulos.id','users.titulo_id')
        ->where('horarios.periodo_id', $request->idPeriodo)
        ->where('horarios.gestion', $request->gestion)
        ->where('horarios.aula_id', $request->idAula)
        ->where('asignaturas.estado_id',2) 
        ->where('materias.estado_id',2) 
        ->selectRaw("distinct horarios.horaInicio as startTime,
            horarios.horaFinal as endTime,
            horarios.id as idAulaOcup,
            concat('[',horarios.dia,']') as daysOfWeek")
        ->get();
        return response()->json($horarios);
    }
    public function horarios(Request $request){
        $idUsuario =$request->user()->id;
        $idPeriodo = $request->idPeriodo;
        $gestion = $request->gestion;
        $horarios = Grupo::join('asignaturas','asignaturas.grupo_id','grupos.id')
        ->join('materias','materias.id','grupos.materia_id')
        ->join('users','users.id','asignaturas.user_id')
        ->join('horarios','horarios.asignatura_id','asignaturas.id')
        ->join('aulas','aulas.id','horarios.aula_id')
        ->join('actividades','actividades.id','asignaturas.actividade_id')
        ->join('titulos','titulos.id','users.titulo_id')
        ->join('periodos','periodos.id','horarios.periodo_id')
        ->where('horarios.periodo_id', $request->idPeriodo)
        ->where('horarios.gestion', $request->gestion)
        ->where('asignaturas.estado_id', 2)
        ->where('materias.estado_id', 2)
        ->whereIn('asignaturas.grupo_id',explode(",", $request->idGrupo))
        /* ->orWhere('asignaturas.user_id',$request->user()->id) */
        ->orWhere(function ($query) use ($idUsuario,$idPeriodo,$gestion) {
            $query->where('asignaturas.user_id',$idUsuario)
            ->where('horarios.periodo_id', $idPeriodo)
            ->where('horarios.gestion', $gestion);
        })
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
            materias.nombreMat,
            aulas.aulaAbrev,
            aulas.aula,
            actividades.actividad,
            periodos.periodoAbrev,
            concat(titulos.tituloAbrev,' ',users.apPaterno) as docAbrev");
        switch ($request->idColor) {
            case 1:
                $horariosColor = $horarios->addSelect('materias.color')->selectRaw('"white" as textColor')->get();
                break;
            case 2:
                $horariosColor = $horarios->selectRaw('"#F0F2F5" as backgroundColor,"black" as textColor,"black" as borderColor')->get();
                break;            
            default:
                # code...
                break;
        }
        return response()->json($horariosColor);
    }
    public function horariosAula(Request $request){
        $horarios = Asignatura::join('grupos','grupos.id','asignaturas.grupo_id')
        ->join('materias','materias.id','grupos.materia_id')
        ->join('users','users.id','asignaturas.user_id')
        ->join('horarios','horarios.asignatura_id','asignaturas.id')
        ->join('aulas','aulas.id','horarios.aula_id')
        ->join('actividades','actividades.id','asignaturas.actividade_id')
        ->join('titulos','titulos.id','users.titulo_id')
        ->join('periodos','periodos.id','horarios.periodo_id')
        ->where('horarios.aula_id', $request->idAula)
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
            materias.nombreMat,
            aulas.aulaAbrev,
            aulas.aula,
            actividades.actividad,
            periodos.periodoAbrev,
            concat(titulos.tituloAbrev,' ',users.apPaterno) as docAbrev");
            if (!empty($request->idActividad)) {
                $horarios = $horarios->where('asignaturas.actividade_id', $request->idActividad);
            }
            switch ($request->idColor) {
                case 1:
                    $horarios = $horarios->addSelect('materias.color')->selectRaw('"white" as textColor');
                    break;
                case 2:
                    $horarios = $horarios->selectRaw('"#F0F2F5" as backgroundColor,"black" as textColor,"black" as borderColor');
                    break;            
                default:
                    # code...
                    break;
            }
            return response()->json($horarios->get()->toArray());
    }
    public function horariosSemestre(Request $request){
        $horarios = Programa::join('materias','materias.id','programas.materia_id')
        ->join('grupos','grupos.materia_id','materias.id')
        ->join('asignaturas','asignaturas.grupo_id','grupos.id')
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
        ->where('asignaturas.estado_id', 2)
        ->where('materias.estado_id', 2)
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
            materias.nombreMat,
            aulas.aulaAbrev,
            aulas.aula,
            actividades.actividad,
            periodos.periodoAbrev,
            concat(titulos.tituloAbrev,' ',users.apPaterno) as docAbrev");
        if (!empty($request->idActividad)) {
            $horarios = $horarios->where('asignaturas.actividade_id', $request->idActividad);
        }
        switch ($request->idColor) {
            case 1:
                $horarios = $horarios->addSelect('materias.color')->selectRaw('"white" as textColor');
                break;
            case 2:
                $horarios = $horarios->selectRaw('"#F0F2F5" as backgroundColor,"black" as textColor,"black" as borderColor');
                break;            
            default:
                # code...
                break;
        }
        return response()->json($horarios->get()->toArray());
    }
    public function eventosAula(Request $request){
        $eventos = Asignatura::join('grupos','grupos.id','asignaturas.grupo_id')
        ->join('materias','materias.id','grupos.materia_id')
        ->join('eventos','eventos.asignatura_id','asignaturas.id')
        ->where('eventos.aula_id', $request->idAula)
        ->where('eventos.periodo_id', $request->idPeriodo)
        ->where('eventos.gestion', $request->gestion)
        ->where('asignaturas.estado_id', 2)
        ->where('materias.estado_id', 2)
        ->selectRaw("materias.sigla as title,
            concat(eventos.fecha,'T',eventos.horaInicio) as start,
            concat(eventos.fecha,'T',eventos.horaFinal) as end,
            eventos.id as idAulaOcup")
        ->get();
        return response()->json($eventos);
    }
    public function eventosSemestre(Request $request)
    {
        $resultado = Asignatura::find($request->idAsignatura)
        ->grupos->materias->programas;
        $idSemestre = array();
        foreach ($resultado as $value) {
            $idSemestre[] = $value->semestre_id;
        }
        $eventos = Programa::join('materias','materias.id','programas.materia_id')
        ->join('grupos','grupos.materia_id','materias.id')
        ->join('asignaturas','asignaturas.grupo_id','grupos.id')
        ->join('eventos','eventos.asignatura_id','asignaturas.id')
        ->whereIn('programas.semestre_id', $idSemestre)
        ->where('asignaturas.id','<>',$request->idAsignatura)
        ->where('eventos.periodo_id', $request->idPeriodo)
        ->where('eventos.gestion', $request->gestion)   
        ->where('asignaturas.estado_id', 2)
        ->where('materias.estado_id', 2)
        ->selectRaw("materias.sigla as title,
            concat(eventos.fecha,'T',eventos.horaInicio) as start,
            concat(eventos.fecha,'T',eventos.horaFinal) as end,
            eventos.id as idSemestreOcup")
        ->get()->toArray();
        return response()->json($eventos);
    }
    /* Funciones para crear lista de gestiones */
    public function mostrarGestiones(){
        $resultado = array();
        $contador = 0;
        $anio = date('Y')-2;
        while ($anio <= date('Y')+10) {
            $resultado[$contador] = $anio;
            $anio = $anio+1;
            $contador++;
        }
        return $resultado;
    }  
}
