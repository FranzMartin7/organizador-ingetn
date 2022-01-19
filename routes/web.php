<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});
Route::post('/reporteDocPDF','App\Http\Controllers\ReportesController@reporteDocente')->name('docente.reportePDF');
Route::post('/reporteAuxPDF','App\Http\Controllers\ReportesController@hojaAsistencia')->name('auxiliar.reporteAuxPDF');
Route::get('/horarioEstPDF','App\Http\Controllers\ReportesController@horarioEstudiante')->name('estudiante.horarioEstPDF');
Route::post('/horariosSemestrePDF','App\Http\Controllers\ReportesController@horariosSemestre')->name('administrador.horariosSemestrePDF');
Route::post('/horariosAulaPDF','App\Http\Controllers\ReportesController@horariosAula')->name('administrador.horariosAulaPDF');

Route::post('/asignatura/datosAsignatura','App\Http\Controllers\AsignaturaController@datosAsignatura');
Route::post('/registro/datosRegistro','App\Http\Controllers\RegistroController@datosRegistro');
Route::post('/materia/datosMateria','App\Http\Controllers\MateriaController@datosMateria');
Route::post('/user/datosUser','App\Http\Controllers\UserController@datosUser');

Route::get('/inicio', function (Request $request) {
    $idUsuario = $request->user()->id;
    $idNivel = User::find($idUsuario)->nivele_id;
    switch ($idNivel) {
        case '1':
            return redirect()->route('admin.eventosVista');
            break;
        case '2':
            return redirect()->route('docente.eventosVista');
            break;
        case '3':
            return redirect()->route('auxiliar.eventosVista');
            break;
        case '4':
            return redirect()->route('estudiante.eventosVista');
            break;        
        default:
            # code...
            break;
    }
    
});
Route::resource('asignatura','App\Http\Controllers\AsignaturaController');
Route::resource('materia','App\Http\Controllers\MateriaController');
Route::resource('evento','App\Http\Controllers\EventoController');
Route::resource('horario','App\Http\Controllers\HorarioController');
Route::resource('registro','App\Http\Controllers\RegistroController');
Route::resource('grupo','App\Http\Controllers\GrupoController');
Route::resource('mencion','App\Http\Controllers\MencioneController');
Route::resource('programa','App\Http\Controllers\ProgramaController');
Route::resource('user','App\Http\Controllers\UserController');

Route::get('/inicioAdministrador/eventosVista','App\Http\Controllers\InicioController@eventosVista')->name('admin.eventosVista');
Route::get('/inicioAdministrador/adminEventos','App\Http\Controllers\InicioController@adminEventos')->name('admin.eventos');
Route::get('/inicioAdministrador/horariosVista','App\Http\Controllers\InicioController@horariosVista')->name('admin.horariosVista');
Route::get('/inicioAdministrador/adminHorarios','App\Http\Controllers\InicioController@adminHorarios')->name('admin.horarios');
Route::get('/inicioAdministrador/exporHorarios','App\Http\Controllers\InicioController@exporHorarios')->name('admin.horariosExportar');
Route::get('/inicioAdministrador/adminAsignaturas','App\Http\Controllers\InicioController@adminAsignaturas')->name('admin.asignaturas');
Route::get('/inicioAdministrador/adminGrupos','App\Http\Controllers\InicioController@adminGrupos')->name('admin.grupos');
Route::get('/inicioAdministrador/adminProgramas','App\Http\Controllers\InicioController@adminProgramas')->name('admin.programas');
Route::get('/inicioAdministrador/adminMaterias','App\Http\Controllers\InicioController@adminMaterias')->name('admin.materias');
Route::get('/inicioAdministrador/adminRegistros','App\Http\Controllers\InicioController@adminRegistros')->name('admin.registros');
Route::get('/inicioAdministrador/adminUsers','App\Http\Controllers\InicioController@adminUsers')->name('admin.users');
Route::get('/inicioDocente/eventosVista','App\Http\Controllers\InicioController@docenteVista')->name('docente.eventosVista');
Route::get('/inicioDocente/eventosEdicion','App\Http\Controllers\InicioController@docenteEdicion')->name('docente.eventosEdicion');
Route::get('/inicioDocente/reporteDocente','App\Http\Controllers\InicioController@docenteReporte')->name('docente.reporte');
Route::get('/inicioAuxiliar/eventosVista','App\Http\Controllers\InicioController@auxiliarVista')->name('auxiliar.eventosVista');
Route::get('/inicioAuxiliar/eventosEdicion','App\Http\Controllers\InicioController@auxiliarEdicion')->name('auxiliar.eventosEdicion');
Route::get('/inicioAuxiliar/reporteAuxiliar','App\Http\Controllers\InicioController@auxiliarReporte')->name('auxiliar.reporte');
Route::get('/inicioEstudiante/eventosVista','App\Http\Controllers\InicioController@estudianteVista')->name('estudiante.eventosVista');
Route::get('/inicioEstudiante/horario','App\Http\Controllers\InicioController@estudianteHorario')->name('estudiante.horario');
Route::get('/inicioEstudiante/registro','App\Http\Controllers\InicioController@estudianteRegistro')->name('estudiante.registro');

Route::post('/evDocente','App\Http\Controllers\MostrarEventos@eventosDocente');
Route::post('/evEstudiante','App\Http\Controllers\MostrarEventos@eventosEstudiante');
Route::post('/evReporte','App\Http\Controllers\MostrarEventos@eventosReporte');
Route::post('/genEventos','App\Http\Controllers\HorarioController@generarEventos');
Route::post('/horAula','App\Http\Controllers\MostrarEventos@horAula');
Route::post('/evAula','App\Http\Controllers\MostrarEventos@eventosAula');
Route::post('/evSemestre','App\Http\Controllers\MostrarEventos@eventosSemestre');
Route::post('/horarios','App\Http\Controllers\MostrarEventos@horarios');
Route::post('/horariosSemestre','App\Http\Controllers\MostrarEventos@horariosSemestre');
Route::post('/horariosAula','App\Http\Controllers\MostrarEventos@horariosAula');
Route::post('/evDia','App\Http\Controllers\MostrarEventos@eventosDia');
Route::post('/evAlarma','App\Http\Controllers\MostrarEventos@eventosAlarma');
Route::post('/evAlarmaEst','App\Http\Controllers\MostrarEventos@eventosAlarmaEst');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
