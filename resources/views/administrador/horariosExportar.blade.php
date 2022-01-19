@extends('adminlte::page')

@section('title', 'Organizador ETN')

@section('content_header')

@stop
@section('content')
<!-- Panel de eventos del docente en modo vista -->
<div class="row my-3">
    <div class="col-12 col-md-6 col-lg-8 lead font-weight-bold">EXPORTAR HORARIOS </div>
    <div class="col-12 col-md-6 col-lg-4">
        <div class="input-group mb-1">
            <div class="input-group-prepend">
                <span class="input-group-text bg-primario font-weight-normal">Gestión</span>
            </div>
            <select name='idPeriodo' id='idPeriodo' class="selectpicker form-control show-tick" required>
                @foreach($periodos as $valor)
                    <option value="{{ $valor->id }}" title="{{ $valor->periodoAbrev }}">{{ $valor->periodo }}</option>
                @endforeach 
            </select> 
            <select name='gestion' id='gestion' class="selectpicker form-control show-tick" required>
                @foreach($gestiones as $valor)
                    <option value="{{ $valor }}">{{ $valor }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 col-md-6">
        <form action="{{ url('/horariosSemestrePDF') }}" method="post" target="_blank">
            @csrf
            <input type="hidden" name="idPeriodoSem" id="idPeriodoSem">
            <input type="hidden" name="gestionSem" id="gestionSem">
            <div class="card">
                <div class="card-header bg-primario">
                    HORARIOS POR SEMESTRE
                </div>
                <div class="card-body">
                    <div class="input-group mb-1">
                        <div class="input-group-prepend">
                            <label for="idSemestre" class="input-group-text bg-primario font-weight-normal" id="addonIdSemestre">Semestre</label>
                        </div>
                        <select name='idSemestre' id='idSemestre' class="selectpicker form-control show-tick" aria-label="Small" aria-describedby="addonIdSemestre" required>
                            @foreach($semestres as $valor)
                                <option value="{{ $valor->id }}">{{ $valor->semestre }}</option>
                            @endforeach 
                        </select> 
                    </div>
                    <div class="input-group mb-1">
                        <div class="input-group-prepend">
                            <label for="idMencion" class="input-group-text bg-primario font-weight-normal" id="addonIdMencion">Mención</label>
                        </div>
                        <select name='idMencion' id='idMencion' class="selectpicker form-control show-tick" aria-label="Small" aria-describedby="addonIdMencion" required>
                            @foreach($menciones as $valor)
                                <option value="{{ $valor->id }}">{{ $valor->mencion }}</option>
                            @endforeach 
                        </select> 
                    </div>
                    <div class="input-group mb-1">
                        <div class="input-group-prepend">
                            <label for="idActividad" class="input-group-text bg-primario font-weight-normal" id="addonIdActividad">Actividad</label>
                        </div>
                        <select name='idActividad' id='idActividad' class="selectpicker form-control show-tick" aria-label="Small" aria-describedby="addonIdActividad">
                            <option value="">Todos</option>
                            @foreach($actividades as $valor)
                                <option value="{{ $valor->id }}">{{ $valor->actividad }}</option>
                            @endforeach 
                        </select> 
                    </div>
                    <div class="input-group mb-1">
                        <div class="input-group-prepend">
                            <label for="idcolor" class="input-group-text bg-primario font-weight-normal" id="addonIdColor">Color de horarios</label>
                        </div>
                        <select name='idColorSem' id='idColorSem' class="selectpicker form-control show-tick" aria-label="Small" aria-describedby="addonIdColor"  required>
                            <option value="1">Color</option>
                            <option value="2">Escala de grises</option>
                        </select>
                    </div>
                </div>
                <div class="card-footer bg-primario">
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-danger btn-sm" type="submit" id="btnExportarSem">Exportar horario&nbsp;&nbsp;<span class="fas fa-file-pdf"></span></button> 
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="col-12 col-md-6">
        <form action="{{ url('/horariosAulaPDF') }}" method="post"  target="_blank">
            @csrf
            <input type="hidden" name="idPeriodoAula" id="idPeriodoAula">
            <input type="hidden" name="gestionAula" id="gestionAula">
            <div class="card">
                <div class="card-header bg-primario">
                    HORARIOS POR AULA
                </div>
                <div class="card-body">
                    <div class="input-group mb-1">
                        <div class="input-group-prepend">
                            <label for="idAula" class="input-group-text bg-primario font-weight-normal" id="addonIdAula">Aula</label>
                        </div>
                        <select name='idAula' id='idAula' class="selectpicker form-control show-tick" aria-label="Small" aria-describedby="addonIdAula" required>
                            @foreach($aulas as $valor)
                                <option value="{{ $valor->id }}" title="{{ $valor->aulaAbrev }}">{{ $valor->aula }}</option>
                            @endforeach 
                        </select> 
                    </div>
                    <div class="input-group mb-1">
                        <div class="input-group-prepend">
                            <label for="idActividadAula" class="input-group-text bg-primario font-weight-normal" id="addonIdActividadAula">Actividad</label>
                        </div>
                        <select name='idActividadAula' id='idActividadAula' class="selectpicker form-control show-tick" aria-label="Small" aria-describedby="addonIdActividadAula">
                            <option value="">Todos</option>
                            @foreach($actividades as $valor)
                                <option value="{{ $valor->id }}">{{ $valor->actividad }}</option>
                            @endforeach 
                        </select> 
                    </div>
                    <div class="input-group mb-1">
                        <div class="input-group-prepend">
                            <label for="idcolor" class="input-group-text bg-primario font-weight-normal" id="addonIdColorAula">Color de horarios</label>
                        </div>
                        <select name='idColorAula' id='idColorAula' class="selectpicker form-control show-tick" aria-label="Small" aria-describedby="addonIdColorAula">
                            <option value="1">Color</option>
                            <option value="2">Escala de grises</option>
                        </select>
                    </div>
                </div>
                <div class="card-footer bg-primario">
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-danger btn-sm" type="submit" id="btnExportarAula">Exportar Horario&nbsp;&nbsp;<span class="fas fa-file-pdf"></span></button> 
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@stop

@section('css')
<link href="{{ asset('css/estilos.css') }}" rel="stylesheet">
@stop

@section('js')
<script>
    $(document).ready(function(){
        /* Valores iniciales */
        $('.clockpicker').clockpicker();
        var idActividadAula = $('#idActividadAula');
        var idPeriodo = $('#idPeriodo');
        var gestion = $('#gestion');
        var idPeriodoSem = $('#idPeriodoSem');
        var gestionSem = $('#gestionSem');
        var idPeriodoAula = $('#idPeriodoAula');
        var gestionAula = $('#gestionAula');
        var idSemestre = $('#idSemestre');
        var idMencion = $('#idMencion');
        var idActividad = $('#idActividad');
        var idAula = $('#idAula');
        var idColorSem = $('#idColorSem');
        var idColorAula = $('#idColorAula');
        var gestiones = $('#idPeriodo,#gestion')
        idSemestre.selectpicker();
        idMencion.selectpicker();
        idActividad.selectpicker();
        idActividadAula.selectpicker();
        idAula.selectpicker();
        idPeriodo.selectpicker();
        gestion.selectpicker();
        idColorSem.selectpicker();
        idColorAula.selectpicker();
    /* Variables para el modal de vista de eventos */
        var btnExportarSem = $('#btnExportarSem');
        var btnExportarAula = $('#btnExportarAula');   
        var mes = moment().format('M');
        idPeriodo.val(convPeriodo(mes));
        gestion.val(moment().format("YYYY"));
        idPeriodo.selectpicker('refresh')
        gestion.selectpicker('refresh')
        idPeriodoSem.val(idPeriodo.val());
        gestionSem.val(gestion.val());
        idPeriodoAula.val(idPeriodo.val());
        gestionAula.val(gestion.val());
        /* Actualizar tamaño del calendeario */
    /* Funcion para adecuar el periodo segun el mes */
        function convPeriodo(mes) {
            var idPeriodo;
            if (mes>=2 && mes<=6) {
                idPeriodo = 1;
            }
            if (mes>=8 && mes<=12) {
                idPeriodo = 2;
            }
            if (mes==1) {
                idPeriodo = 3;
            }
            if (mes==7) {
                idPeriodo = 4;
            }
            return idPeriodo;
        }
        gestiones.on('change',function(e){
            e.preventDefault();
            idPeriodoSem.val(idPeriodo.val());
            gestionSem.val(gestion.val());
            idPeriodoAula.val(idPeriodo.val());
            gestionAula.val(gestion.val());
        });
    })
</script>
@stop