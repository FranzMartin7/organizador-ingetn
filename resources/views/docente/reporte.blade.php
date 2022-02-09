@extends('adminlte::page')

@section('title', 'Organizador ETN')

@section('plugins.bootstrap-table',true)

@section('content_header')
@stop

@section('content')
<!-- Panel de tabla de programas -->
<div class="d-flex justify-content-between my-1">
    <div class="lead font-weight-bold">REPORTE DE EVENTOS</div> 
    <button class="btn btn-danger btn-sm" type="submit" form="formReporteDoc">Exportar&nbsp;&nbsp;<i class="fas fa-file-pdf"></i></button>     
</div>
<form id="formReporteDoc" action="{{ url('/reporteDocPDF') }}" method="post">
    @csrf
    <input type="hidden" name="mesLiteral" id="mesLiteral">
    <input type="hidden" name="periodo" id="periodo">
    <div class="form-row mb-1">
        <div class="col-12 col-sm-4 col-md-6">
            <div class="input-group">
                <div class="input-group-prepend">
                    <label class="input-group-text bg-primario font-weight-normal" for="idAsignatura">Docencias</label>
                </div>
                <select class="selectpicker form-control show-tick" id="idAsignatura" name="idAsignatura" name="idAsignatura" aria-label="Small" aria-describedby="addonIdAsignatura" required>
                    @foreach($asignaturas as $valor)
                        <option value="{{ $valor->id }}" title="{{$valor->grupos->materias->sigla.' '.'Grupo '.$valor->grupos->grupo.' ('.$valor->actividades->actividad.')' }}" data-subtext="{{ 'Grupo '.$valor->grupos->grupo}}" showSubtext="true">{{ $valor->grupos->materias->nombreMat.' ('.$valor->grupos->materias->sigla.')'.' - '.$valor->actividades->actividad }}</option>
                    @endforeach 
                </select>
            </div>
        </div> 
        <div class="col-12 col-sm-4 col-md-3"">
            <div class="input-group">
                <div class="input-group-prepend">
                    <label class="input-group-text bg-primario font-weight-normal" for="mes">Mes</label>
                </div>
                <select class="selectpicker form-control show-tick" id="mes" name="mes" aria-label="Small" aria-describedby="addonMes" required>
                    <option value="1" mes="Enero">Enero</option>
                    <option value="2" mes="Febrero">Febrero</option>
                    <option value="3" mes="Marzo">Marzo</option>
                    <option value="4" mes="Abril">Abril</option>
                    <option value="5" mes="Mayo">Mayo</option>
                    <option value="6" mes="Junio">Junio</option>
                    <option value="7" mes="Julio">Julio</option>
                    <option value="8" mes="Agosto">Agosto</option>
                    <option value="9" mes="Septiembre">Septiembre</option>
                    <option value="10" mes="Octubre">Octubre</option>
                    <option value="11" mes="Noviembre">Noviembre</option>
                    <option value="12" mes="Diciembre">Diciembre</option>
                </select>
            </div>
        </div> 
        <div class="col-12 col-sm-4 col-md-3"">
            <div class="input-group">
                <div class="input-group-prepend">
                    <label class="input-group-text bg-primario font-weight-normal" for="gestion">Gestión</label>
                </div>
                <select class="selectpicker form-control show-tick" id="gestion" name="gestion" aria-label="Small" aria-describedby="addonGestion" required>
                    @foreach($gestiones as $valor)
                        <option value="{{ $valor }}">{{ $valor }}</option>
                    @endforeach
                </select>
            </div>
        </div>       
    </div>
</form>
<div class="table-responsive">
    <table id="tablaReporte"></table>
</div>
@stop

@section('css')
<link href="{{ asset('css/estilos.css') }}" rel="stylesheet">
@stop

@section('js')
<script>
    $(document).ready(function(){
        /* Selectores que se modificaran para gestionar materias */
        var tablaReporte = $('#tablaReporte');
        var idAsignatura = $('#idAsignatura');
        var mes = $('#mes');
        var periodo = $('#periodo');
        var mesLiteral = $('#mesLiteral');
        var gestion = $('#gestion');
        var filtros = $('#idAsignatura,#mes,#gestion');
        mes.val(moment().format("M"));
        mes.selectpicker('refresh');
        gestion.val(moment().format("YYYY"));
        gestion.selectpicker('refresh');
        mesLiteral.val(moment(mes.val()).format('MMMM'));
        periodo.val(convPeriodo(mes.val()))
        /* Estructurador de la tabla de reporte */
        tablaReporte.bootstrapTable({
            url:"{{ url('/evReporte') }}",
            method:'post',
            queryParams:function (params) {
                var datos = {
                    idAsignatura: idAsignatura.val(),
                    mes: mes.val(),
                    gestion: gestion.val(),
                    '_token': $("meta[name='csrf-token']").attr("content")
                    
                };
                return datos;
            },
            pagination: true,
            search: true,
            showRefresh: true,
            autoRefresh: true,
            autoRefreshInterval: 10,
            paginationHAlign:'right',
            paginationVAlign:'bottom',
            paginationParts:['pageSize', 'pageList'],
            searchAlign:'left',
            toolbarAlign:'left',
            showColumns: true,
            showSearchButton: false,
            showFullscreen: true,
            showButtonText: false,
            searchAccentNeutralise: true,
            buttonsClass:'primario',
            classes:'table table-bordered table-hover table-striped',
            theadClasses: 'bg-primario font-weight-normal',
            buttonsOrder:['refresh', 'autoRefresh', 'fullscreen', 'columns'],  
            columns: [{
                field: 'id',
                title: 'Id',
                sortable: true,
                visible: false
            }, {
                field: 'fecha',
                title: 'Fecha',
                sortable: true,
                formatter: function(value,row,index,field){
                    var fechaRegistro = moment(value).format('dddd D/MMM/YYYY');                
                    return fechaRegistro;
                }
            }, {
                field: 'actividad',
                title: 'Actividad',
                sortable: true,
                visible: true
            }, {
                field: 'descripcion',
                title: 'Tema avanzado',
                sortable: true,
            },  {
                field: 'enlace',
                title: 'Enlace',
                sortable: true,
                visible: false
            }, {
                field: 'aula',
                title: 'Aula',
                sortable: true,
                visible: true
            },{
                field: 'horaInicio',
                title: 'Inicio',
                sortable: true,
                formatter: function(value,row,index,field){
                    var horaInicio = moment(value,'HH:mm').format('HH:mm');                
                    return horaInicio;
                }
            }, {
                field: 'horaFinal',
                title: 'Final',
                sortable: true,
                formatter: function(value,row,index,field){
                    var horaFinal = moment(value,'HH:mm').format('HH:mm');                
                    return horaFinal;
                }
            }]
        });
        /* Evento para actualizar la tabla cambiando el valor de la mencion */
        filtros.on('change',function () {
            tablaReporte.bootstrapTable('refreshOptions', {
                url:"{{ url('/evReporte') }}",
                method:'post',
                queryParams:function (params) {
                    var datos = {
                        idAsignatura: idAsignatura.val(),
                        mes: mes.val(),
                        gestion: gestion.val(),
                        '_token': $("meta[name='csrf-token']").attr("content")
                    };
                    return datos;
                }
            })
            mesLiteral.val(moment(mes.val()).format('MMMM'));
            periodo.val(convPeriodo(mes.val()))
        })
        /* Funcion para convertir periodo */
        function convPeriodo(mes) {
            var idPeriodo;
            if (mes>=2 && mes<=6) {
                idPeriodo = 'I';
            }
            if (mes>=8 && mes<=12) {
                idPeriodo = 'II';
            }
            if (mes==1) {
                idPeriodo = 'Ver';
            }
            if (mes==7) {
                idPeriodo = 'Inv';
            }
            return idPeriodo;
        }
    });
</script> 
@stop