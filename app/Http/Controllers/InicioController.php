<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asignatura;
use App\Models\Evento;
use App\Models\Aula;
use App\Models\Actividade;
use App\Models\Materia;
use App\Models\Docencia;
use App\Models\Grupo;
use App\Models\User;
use App\Models\Registro;
use App\Models\Semestre;
use App\Models\Mencione;
use App\Models\Periodo;
use App\Models\Estado;
use App\Models\Area;
use App\Models\Role;
use App\Models\Titulo;
use App\Models\Programa;

class InicioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $idUsuario = $request->user()->id;
        $asignaturas = User::find($idUsuario)->asignaturas;
        $aulas = Aula::all();
        $actividades = Actividade::all();
        return view('DocenteEdicion',compact('asignaturas','aulas','actividades'));
    }
    public function eventosVista(Request $request)
    {
        $semestres = Semestre::all();
        $menciones = Mencione::all();
        $actividades = Actividade::all();
        $aulas = Aula::all();
        $periodos = Periodo::all();
        $mostrarEventos = new MostrarEventos();
        $gestiones = $mostrarEventos->mostrarGestiones();
        return view('administrador.eventosVista',compact('semestres','menciones','aulas','actividades','periodos','gestiones'));
    }
    public function adminEventos(Request $request)
    {
        $semestres = Semestre::all();
        $menciones = Mencione::all();
        $actividades = Actividade::all();
        $aulas = Aula::all();
        $periodos = Periodo::all();
        $mostrarEventos = new MostrarEventos();
        $gestiones = $mostrarEventos->mostrarGestiones();
        return view('administrador.eventos',compact('semestres','menciones','aulas','actividades','periodos','gestiones'));
    }
    public function horariosVista(Request $request)
    {
        $semestres = Semestre::all();
        $menciones = Mencione::all();
        $actividades = Actividade::all();
        $aulas = Aula::all();
        $periodos = Periodo::all();
        $mostrarEventos = new MostrarEventos();
        $gestiones = $mostrarEventos->mostrarGestiones();
        return view('administrador.horariosVista',compact('semestres','menciones','aulas','actividades','periodos','gestiones'));
    }
    public function adminHorarios(Request $request)
    {
        $semestres = Semestre::all();
        $menciones = Mencione::all();
        $actividades = Actividade::all();
        $aulas = Aula::all();
        $periodos = Periodo::all();
        $mostrarEventos = new MostrarEventos();
        $gestiones = $mostrarEventos->mostrarGestiones();
        return view('administrador.horarios',compact('semestres','menciones','aulas','actividades','periodos','gestiones'));
    }
    public function exporHorarios(Request $request)
    {
        $semestres = Semestre::all();
        $menciones = Mencione::all();
        $actividades = Actividade::all();
        $aulas = Aula::all();
        $periodos = Periodo::all();
        $mostrarEventos = new MostrarEventos();
        $gestiones = $mostrarEventos->mostrarGestiones();
        return view('administrador.horariosExportar',compact('semestres','menciones','aulas','actividades','periodos','gestiones'));
    }
    public function adminRegistros(Request $request)
    {
        $estudiantes = User::whereIn('nivele_id', [3,4])
            ->orderBy('users.apPaterno')
            ->orderBy('users.apMaterno')
            ->orderBy('users.name')
            ->get();
        $grupos = Grupo::join('materias','materias.id','grupos.materia_id')
            ->join('programas','programas.materia_id','materias.id')
            ->join('semestres','programas.semestre_id','semestres.id')
            ->selectRaw("distinct materias.nombreMat,
                programas.semestre_id,
                semestres.semestre,
                materias.sigla,
                grupos.*")
            ->where('materias.estado_id',2) 
            ->orderBy('semestre_id')  
            ->orderBy('nombreMat')
            ->orderBy('grupo')
            ->get();
        $resultado = response()->json($grupos);
        $semestres = Semestre::all();
        $periodos = Periodo::all();
        $mostrarEventos = new MostrarEventos();
        $gestiones = $mostrarEventos->mostrarGestiones();
        return view('administrador.registros',compact('periodos','gestiones','grupos','semestres','estudiantes'));
    }
    public function adminAsignaturas(Request $request)
    {
        $grupos = Grupo::join('materias','materias.id','grupos.materia_id')
            ->join('programas','programas.materia_id','materias.id')
            ->join('semestres','programas.semestre_id','semestres.id')
            ->selectRaw("distinct materias.nombreMat,
                programas.semestre_id,
                semestres.semestre,
                materias.sigla,
                grupos.*")
            ->where('materias.estado_id',2) 
            ->orderBy('semestre_id')  
            ->orderBy('nombreMat')
            ->orderBy('grupo')
            ->get();
        $docentes = User::whereIn('nivele_id', [2,3])
            ->orderBy('nivele_id')
            ->orderBy('users.apPaterno')
            ->orderBy('users.apMaterno')
            ->orderBy('users.name')
            ->get();
        $docencias = Docencia::all();
        $resultado = response()->json($grupos);
        $semestres = Semestre::all();
        $menciones = Mencione::all();
        $actividades = Actividade::all();
        $aulas = Aula::all();
        $periodos = Periodo::all();
        $estados = Estado::all();
        return view('administrador.asignaturas',compact('semestres','menciones','aulas','actividades','periodos','estados','grupos','docentes','docencias'));
    }
    public function adminGrupos(Request $request)
    {
        $semestres = Semestre::all();
        $materias = Programa::join('materias','materias.id','programas.materia_id')
        ->join('semestres','programas.semestre_id','semestres.id')
        ->selectRaw("distinct materias.*,
            programas.semestre_id,
            semestres.semestre")
        ->where('materias.estado_id',2) 
        ->orderBy('nombreMat')
        ->get();
        return view('administrador.grupos',compact('materias','semestres'));
    }
    public function adminProgramas(Request $request)
    {
        $menciones = Mencione::all();
        $semestres = Semestre::all();
        return view('administrador.programas',compact('semestres','menciones'));
    }
    public function adminMaterias(Request $request)
    {
        $areas = Area::all();
        $estados = Estado::all();
        return view('administrador.materias',compact('areas','estados'));
    }
    public function adminUsers(Request $request)
    {
        
        $estados = Estado::all();
        $roles = Role::orderBy('name','asc')->get();
        $titulos = Titulo::all();
        return view('administrador.users',compact('estados','roles','titulos'));
    }
    public function docenteVista(Request $request)
    {
        $idUsuario = $request->user()->id;
        $asignaturas = User::find($idUsuario)->asignaturas;
        $aulas = Aula::all();
        $actividades = Actividade::all();
        $periodos = Periodo::all();
        $mostrarEventos = new MostrarEventos();
        $gestiones = $mostrarEventos->mostrarGestiones();
        return view('docente.eventosVista',compact('asignaturas','aulas','actividades','periodos','gestiones'));
    }
    public function docenteEdicion(Request $request)
    {
        $idUsuario = $request->user()->id;
        $asignaturas = User::find($idUsuario)->asignaturas;
        $aulas = Aula::all();
        $actividades = Actividade::all();
        $periodos = Periodo::all();
        $mostrarEventos = new MostrarEventos();
        $gestiones = $mostrarEventos->mostrarGestiones();
        return view('docente.eventos',compact('asignaturas','aulas','actividades','periodos','gestiones'));
    }
    public function docenteReporte(Request $request)
    {
        $idUsuario = $request->user()->id;
        $asignaturas = User::find($idUsuario)->asignaturas;
        $mostrarEventos = new MostrarEventos();
        $gestiones = $mostrarEventos->mostrarGestiones();
        return view('docente.reporte',compact('asignaturas','mostrarEventos','gestiones'));
    }
    public function auxiliarVista(Request $request)
    {
        $idUsuario = $request->user()->id;
        $asignaturas = User::find($idUsuario)->asignaturas;
        $aulas = Aula::all();
        $actividades = Actividade::all();
        $materias =  User::find($idUsuario)->registros;
        $periodos = Periodo::all();
        $mostrarEventos = new MostrarEventos();
        $gestiones = $mostrarEventos->mostrarGestiones();
        return view('auxiliar.eventosVista',compact('asignaturas','aulas','actividades','materias','periodos','gestiones'));
    }
    public function auxiliarEdicion(Request $request)
    {
        $idUsuario = $request->user()->id;
        $asignaturas = User::find($idUsuario)->asignaturas;
        $aulas = Aula::all();
        $actividades = Actividade::all();
        $periodos = Periodo::all();
        $mostrarEventos = new MostrarEventos();
        $gestiones = $mostrarEventos->mostrarGestiones();
        return view('auxiliar.eventos',compact('asignaturas','aulas','actividades','periodos','gestiones'));
    }
    public function auxiliarReporte(Request $request)
    {
        $idUsuario = $request->user()->id;
        $asignaturas = User::find($idUsuario)->asignaturas;
        $mostrarEventos = new MostrarEventos();
        $gestiones = $mostrarEventos->mostrarGestiones();
        return view('auxiliar.reporte',compact('asignaturas','mostrarEventos','gestiones'));
    }
    public function estudianteVista(Request $request)
    {
        $idUsuario = $request->user()->id;
        $asignaturas = User::find($idUsuario)->asignaturas;
        $aulas = Aula::all();
        $actividades = Actividade::all();
        $materias =  User::find($idUsuario)->registros;
        $periodos = Periodo::all();
        $mostrarEventos = new MostrarEventos();
        $gestiones = $mostrarEventos->mostrarGestiones();
        return view('estudiante.eventosVista',compact('asignaturas','aulas','actividades','materias','periodos','gestiones'));
    }
    public function estudianteHorario(Request $request)
    {
        $semestres = Semestre::all();
        $menciones = Mencione::all();
        $actividades = Actividade::all();
        $aulas = Aula::all();
        $periodos = Periodo::all();
        $semestres = Semestre::all();
        $grupos = Grupo::join('materias','materias.id','grupos.materia_id')
            ->join('programas','programas.materia_id','materias.id')
            ->join('semestres','programas.semestre_id','semestres.id')
            ->selectRaw("distinct materias.nombreMat,
                programas.semestre_id,
                semestres.semestre,
                materias.sigla,
                grupos.*")
            ->where('materias.estado_id',2) 
            ->orderBy('semestre_id')  
            ->orderBy('nombreMat')
            ->orderBy('grupo')
            ->get();
        $resultado = response()->json($grupos);
        $mostrarEventos = new MostrarEventos();
        $gestiones = $mostrarEventos->mostrarGestiones();
        return view('estudiante.horario',compact('semestres','menciones','aulas','actividades','periodos','gestiones','grupos','semestres'));
    }
    public function estudianteRegistro(Request $request)
    {
        $idUsuario = $request->user()->id;
        $semestres = Semestre::all();
        $menciones = Mencione::all();
        $actividades = Actividade::all();
        $aulas = Aula::all();
        $periodos = Periodo::all();
        $semestres = Semestre::all();
        $grupos = Grupo::join('materias','materias.id','grupos.materia_id')
            ->join('programas','programas.materia_id','materias.id')
            ->join('semestres','programas.semestre_id','semestres.id')
            ->selectRaw("distinct materias.nombreMat,
                programas.semestre_id,
                semestres.semestre,
                materias.sigla,
                grupos.*")
            ->where('materias.estado_id',2) 
            ->orderBy('semestre_id')  
            ->orderBy('nombreMat')
            ->orderBy('grupo')
            ->get();
        $resultado = response()->json($grupos);
        $mostrarEventos = new MostrarEventos();
        $gestiones = $mostrarEventos->mostrarGestiones();
        return view('estudiante.registro',compact('semestres','menciones','aulas','actividades','periodos','gestiones','grupos','semestres','idUsuario'));
    }
}
