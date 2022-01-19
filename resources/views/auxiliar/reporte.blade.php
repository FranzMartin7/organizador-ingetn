@extends('adminlte::page')

@section('title', 'Organizador ETN')

@section('plugins.bootstrap-table',true)

@section('content_header')
@stop
@section('content')
<!-- Panel de tabla de programas -->
<div class="d-flex justify-content-between">
    <div class="lead font-weight-bold mt-1">REPORTES DEL MES</div>
    <button type="submit" form="formReporte" id="btnExportar" class="btn btn-danger btn-sm mt-1">Ficha de asistencia&nbsp;&nbsp;<span class="fas fa-file-pdf"></span></button> 
</div>
<form action="{{ url('/reporteAuxPDF') }}" method="post" id="formReporte">
    @csrf
    <input type="hidden" name="mesLiteral" id="mesLiteral">
    <input type="hidden" name="periodo" id="periodo">
    <div class="row mt-1">
        <div class="col-12 col-md-6">
            <div class="input-group">
                <div class="input-group-prepend">
                    <label class="input-group-text bg-primario font-weight-normal" for="idAsignatura" id="addonIdAsignatura">Docencia</label>
                </div>
                <select class="custom-select form-control" id="idAsignatura" name="idAsignatura" aria-label="Small" aria-describedby="addonIdAsignatura" required>
                @foreach($asignaturas as $valor)
                    <option value="{{ $valor->id }}" title="{{$valor->grupos->materias->sigla.' '.$valor->actividades->actividad.' ('.'Grupo '.$valor->grupos->grupo.')' }}" data-subtext="{{ 'Grupo '.$valor->grupos->grupo}}" showSubtext="true">{{ $valor->grupos->materias->nombreMat.' ('.$valor->grupos->materias->sigla.')'.' - '.$valor->actividades->actividad }}</option>
                @endforeach 
                </select>
            </div>
        </div> 
        <div class="col-12 col-md-3"">
            <div class="input-group">
                <div class="input-group-prepend">
                    <label class="input-group-text bg-primario font-weight-normal" for="mes" id="addonMes">Mes</label>
                </div>
                <select class="custom-select form-control" id="mes" name="mes" aria-label="Small" aria-describedby="addonMes" required>
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
        <div class="col-12 col-md-3"">
            <div class="input-group">
                <div class="input-group-prepend">
                    <label class="input-group-text bg-primario font-weight-normal" for="gestion" id="addonGestion">Gestión</label>
                </div>
                <select class="custom-select form-control" id="gestion" name="gestion" aria-label="Small" aria-describedby="addonGestion" required>
                    @foreach($gestiones as $valor)
                        <option value="{{ $valor }}">{{ $valor }}</option>
                    @endforeach
                </select>
            </div>
        </div>       
    </div>
</form>
<div class="table-responsive mt-1">
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
        var btnExportar = $('#btnExportar');
        var tablaReporte = $('#tablaReporte');
        var idAsignatura = $('#idAsignatura');
        var mesLiteral = $('#mesLiteral');
        var periodo = $('#periodo');
        var mes = $('#mes');
        var gestion = $('#gestion');
        var filtros = $('#idAsignatura,#mes,#gestion');
        mes.val(moment().format("M"));
        gestion.val(moment().format("YYYY"));
        idAsignatura.selectpicker();
        mes.selectpicker();
        gestion.selectpicker();
        mesLiteral.val(moment(mes.val(),'M').format('MMMM'));
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
            buttonsOrder:[ 'refresh', 'autoRefresh', 'fullscreen', 'columns'],
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
                title: 'Descripción',
                sortable: true,
            },  {
                field: 'enlace',
                title: 'Enlace',
                sortable: true,
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
            mesLiteral.val(moment(mes.val(),'M').format("MMMM"));
            periodo.val(convPeriodo(mes.val()));
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
        })
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
                /* Recordatorio */
                function alarmaEvento(){
                var datos = {
                    fecha: moment().format('YYYY-MM-DD'),
                    tiempoAntes: moment().subtract(5, 'minutes').format('HH:mm:ss'),
                    tiempoDespues: moment().add(5, 'minutes').format('HH:mm:ss'),
                    '_token': $("meta[name='csrf-token']").attr("content")
                }
                $.ajax({
                    type:'post',
                    url:'/evAlarma',
                    data: datos,
                    success: function(respuesta){
                        $(respuesta).each(function(indice, valor){
                            Push.create(valor.nombreMat+' ('+valor.title+') Grupo '+valor.grupo, {
                                body: valor.actividad+': '+valor.descripcion,
                                icon: '{{ asset("logos/agenda-recordatorio.png") }}',
                                /* equireInteraction: true, */
                                /* tag:valor.idEvento, */
                                vibrate: [200, 100],
                                timeout: 20000,
                                onClick: function () {
                                    window.focus();
                                    if (valor.enlace) {
                                        window.open(valor.enlace,'_blank');
                                    }
                                    this.close();
                                    this.clear();
                                }
                            });
                        })
                    },
                    error: function(){
                    alert("Hay un error al obtener la lista de materias del semestre seleccionado...");
                    }
                });
            }
            setInterval('alarmaEvento()',30000);
    });
</script> 
@stop