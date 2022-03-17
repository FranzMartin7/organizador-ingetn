<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\View;
use Barryvdh\DomPDF\Facade as PDF;
/* use Maatwebsite\Excel\Facade\Excel; */
use App\Exports\RegistrosExport;
use Illuminate\Support\Facades\Storage;

use App\Http\Controllers\Controller;
use App\Imports\RegistrosImport;
use App\Imports\UsersImport;

use Illuminate\Http\Request;
use App\Models\Asignatura;
use App\Models\Evento;
use App\Models\Aula;
use App\Models\Actividade;
use App\Models\Materia;
use App\Models\User;
use App\Models\Registro;
use App\Models\Semestre;
use App\Models\Mencione;
use App\Models\Periodo;
use App\Models\Estado;
use App\Models\Area;
use App\Models\Nivele;
use App\Models\Titulo;
/* use PDF; */
use Excel;
use Dompdf\Dompdf;
use Dompdf\Options;
/* use Maatwebsite\Excel\Excel as Excel; */

class ReportesController extends Controller
{
    public function reporteDocente(Request $request)
    {
        $idAsignatura = $request->idAsignatura;
        $mesLiteral =  $request->mesLiteral;
        $mes = $request->mes;
        $gestion = $request->gestion;
        $periodo = $request->periodo;
        $idUsuario = $request->user()->id;
        $usuarios = User::find($idUsuario);
        $asignaturas = Asignatura::find($idAsignatura);
        $eventos = Evento::where('asignatura_id', $idAsignatura)
        ->whereRaw('month(eventos.fecha)='.$mes)->orderBy('fecha','asc')->get();
        $pdf = PDF::loadView('reportes.reporteDocPDF',['usuarios'=>$usuarios,'asignaturas'=>$asignaturas,'mesLiteral'=>$mesLiteral,'gestion'=>$gestion,'eventos'=>$eventos,'periodo'=>$periodo]);
        $pdf->setPaper('letter', 'portrait');
        return $pdf->stream('Reporte_'.$mesLiteral.$gestion.'.pdf');
    }
    public function hojaAsistencia(Request $request)
    {
        $idAsignatura = $request->idAsignatura;
        $mesLiteral =  $request->mesLiteral;
        $mes = $request->mes;
        $gestion = $request->gestion;
        $periodo = $request->periodo;
        $idUsuario = $request->user()->id;
        $usuarios = User::find($idUsuario);
        $asignaturas = Asignatura::find($idAsignatura);
        $docente = Asignatura::join('users','users.id','asignaturas.user_id')
        ->join('titulos','users.titulo_id','titulos.id')
        ->where('asignaturas.grupo_id',$asignaturas->grupo_id)
        ->where('asignaturas.docencia_id',$asignaturas->docencia_id)
        ->where('users.nivele_id',2)
        ->selectRaw("concat(titulos.tituloAbrev,' ',users.name,' ',users.apPaterno,' ',users.apMaterno) as docAbrev")->get();
        $eventos = Evento::where('asignatura_id', $idAsignatura)
        ->whereRaw('month(eventos.fecha)='.$mes)->orderBy('fecha','asc')->get();
        $pdf = PDF::loadView('reportes.reporteAuxPDF',['usuarios'=>$usuarios,'asignaturas'=>$asignaturas,'mesLiteral'=>$mesLiteral,'gestion'=>$gestion,'eventos'=>$eventos,'periodo'=>$periodo,'docente'=>$docente]);
        $pdf->setPaper('letter', 'landscape');
        return $pdf->stream('FichaAux_'.$mesLiteral.$gestion.'.pdf');
    }
    public function horarioEstudiante(Request $request)
    {
        $idGrupo = $request->idGrupo;
        $idColor = $request->idColor;
        $gestion = $request->gestion;
        $idPeriodo = $request->idPeriodo;
        $periodo = Periodo::find($request->idPeriodo)->periodoAbrev;
        $idUsuario = $request->user()->id;
        $usuarios = User::find($idUsuario);
        return View::make('reportes.horarioEstPDF',['periodo'=>$periodo,'idGrupo'=>$idGrupo,'gestion'=>$gestion,'idPeriodo'=>$idPeriodo,'usuarios'=>$usuarios,'idColor'=>$idColor]);
    }
    public function horariosSemestre(Request $request)
    {
        $idSemestre = $request->idSemestre;
        $gestion = $request->gestionSem;
        $idPeriodo = $request->idPeriodoSem;
        $idMencion = $request->idMencion;
        $idColor = $request->idColorSem;
        $idActividad = $request->idActividad;
        $periodo = Periodo::find($idPeriodo)->periodoAbrev;
        $mencion = Mencione::find($idMencion)->mencion;
        $mencionAbrev = Mencione::find($idMencion)->mencionAbrev;
        $semestre = Semestre::find($idSemestre)->semestre;
        if (empty($idActividad)) {
            $actividad = $idActividad;
        } else {
            $actividad = Actividade::find($idActividad)->actividad;
        }
        $idUsuario = $request->user()->id;
        $usuarios = User::find($idUsuario);
        return View::make('reportes.horariosSemestrePDF',['idActividad'=>$idActividad,'actividad'=>$actividad,'idColor'=>$idColor,'semestre'=>$semestre,'idMencion'=>$idMencion,'mencion'=>$mencion,'mencionAbrev'=>$mencionAbrev,'periodo'=>$periodo,'idSemestre'=>$idSemestre,'gestion'=>$gestion,'idPeriodo'=>$idPeriodo,'usuarios'=>$usuarios]);
    }
    public function horariosAula(Request $request)
    {
        $gestion = $request->gestionAula;
        $idPeriodo = $request->idPeriodoAula;
        $idAula = $request->idAula;
        $idColor = $request->idColorAula;
        $idActividad = $request->idActividadAula;
        $periodo = Periodo::find($idPeriodo)->periodoAbrev;
        $aula = Aula::find($idAula)->aula;
        $aulaAbrev = Aula::find($idAula)->aulaAbrev;
        if (empty($idActividad)) {
            $actividad = $idActividad;
        } else {
            $actividad = Actividade::find($idActividad)->actividad;
        }
        $idUsuario = $request->user()->id;
        $usuarios = User::find($idUsuario);
        return View::make('reportes.horariosAulaPDF',['idActividad'=>$idActividad,'actividad'=>$actividad,'idColor'=>$idColor,'idAula'=>$idAula,'periodo'=>$periodo,'gestion'=>$gestion,'idPeriodo'=>$idPeriodo,'usuarios'=>$usuarios,'aula'=>$aula,'aulaAbrev'=>$aulaAbrev]);
    }
    public function expRegistros(Request $request){
        $idGrupo = $request->idGrupo;
        $idPeriodo = $request->idPeriodo;
        $periodo = $request->periodo;
        $gestion = $request->gestion;
        $sigla = $request->sigla;
        return Excel::download(new RegistrosExport($idGrupo,$idPeriodo,$gestion),$sigla.' '.$periodo.'-'.$gestion.'.xlsx');
    }
    public function impRegistros(Request $request){
        $registros = $request->file('excelRegistros');
        Excel::import(new RegistrosImport,$registros);
        return back()->with('message','Importacion completada');
    }
    public function impUsuarios(Request $request){
        $registros = $request->file('excelUsuarios');
        Excel::import(new UsersImport,$registros);
        return back()->with('message','Importacion completada');
    }
    public function plantillaUsuarios(Request $request){
        $plantilla = Storage::path('public\plantillas\formato_usuarios.xlsx');
        return response()->download($plantilla);
    }
    public function plantillaRegistros(Request $request){
        $plantilla = Storage::path('public\plantillas\formato_registros.xlsx');
        return response()->download($plantilla);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
