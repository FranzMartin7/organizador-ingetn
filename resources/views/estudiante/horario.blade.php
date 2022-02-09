@extends('adminlte::page')

@section('title', 'Organizador ETN')

@section('content_header')

@stop
@section('content')
<!-- Panel de eventos del docente en modo vista -->
<div class="d-flex justify-content-between my-1">
    <div class="lead font-weight-bold mt-1">VER HORARIOS</div>
    <button type="button" id="btnExportar" class="btn btn-danger btn-sm mt-1">Imprimir&nbsp;&nbsp;<span class="fas fa-file-pdf"></span></button> 
</div>
<form id="formHorario">
    @csrf
    <input type="hidden" name="idGrupoStr" id="idGrupoStr">
    <div class="row"> 
        <div class="col-12 col-sm-3">
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
        <div class="col-12 col-sm-5">
            <div class="input-group mb-1">
                <div class="input-group-prepend">
                    <label for="idGrupo" class="input-group-text bg-primario font-weight-normal" id="addonIdGrupo">Materias</label>
                </div>
                <select name='idGrupo' id='idGrupo' class="selectpicker form-control show-tick" aria-label="Small" aria-describedby="addonIdGrupo" data-max-options="15" title="Elegir materias" multiple data-selected-text-format="count>3" data-header="Eligir materias" data-live-search="true" required>
                @foreach($semestres as $valorSemestre)
                    <optgroup label="{{ $valorSemestre->semestre }}">
                    @foreach($grupos as $valor)
                        @if ($valor->semestre_id==$valorSemestre->id)
                            {{ $i=0 }}                            
                            <option value="{{ $valor->id }}" title="{{ $valor->sigla.' Grupo '.$valor->grupo }}" data-subtext=" {{ 'Grupo '.$valor->grupo }}" showSubtext="true">{{ $valor->nombreMat.' ('.$valor->sigla.')' }}</option>
                        @endif
                    @endforeach
                    </optgroup>
                @endforeach                    
                </select>
                <div class="input-group-append">
                    <button type="button" id="btnLimpiar" class="btn btn-primary btn-block"><span class="fas fa-eraser"></span></button>
                </div> 
            </div>
        </div>
        <div class="col-12 col-sm-4">
            <div class="input-group mb-1">
                <div class="input-group-prepend">
                    <label for="idColor" class="input-group-text bg-primario font-weight-normal" id="addonIdColor">Color horarios</label>
                </div>
                <select name='idColor' id='idColor' class="selectpicker form-control show-tick">
                    <option value="1" title="Colores">Colores</option>
                    <option value="2" title="Gris" >Escala de grises</option>
                </select> 
            </div> 
        </div>
    </div>
</form>
<div class="row mt-1">
    <div class="col-12">
        <div id="calendarioVista"></div>
    </div>
</div>
<div id="horarioImp"></div>
<!-- Modal para detalles de los horarios-->
<div class="modal fade" id="verHorario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" id="encabezadoHorarioVista">
                <div class="modal-title">
                    <div id="mostrarMateria" class="lead"></div>
                    <div class="font-weight-normal" id="mostrarGrupo"></div>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-between">
                    <div class="text-capitalize" id="mostrarDia"></div>
                    <div id="mostrarAula"></div>
                </div>
                <div class="d-flex justify-content-center font-weight-bold lead text-uppercase" id="mostrarActividad"></div>
                <div class="d-flex justify-content-center font-weight-normal lead" id="mostrarHoras"></div>
                <div class="d-flex justify-content-end font-weight-bold text-small" id="mostrarGestion"></div>
            </div>
            <div class="modal-footer" id="pieHorarioVista">
                <button type="button" id="btnCerrar" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
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
        var idPeriodo = $('#idPeriodo');
        var idGrupoStr = $('#idGrupoStr');
        var gestion = $('#gestion');
        var idGrupo = $('#idGrupo');
        var idColor = $('#idColor');
        var gestiones = $('#idPeriodo,#gestion');
        var generadores = $('#idGrupo,#idColor');
        var btnLimpiar = $('#btnLimpiar');
        var btnExportar = $('#btnExportar');
        idPeriodo.val(convPeriodo(moment().format("MM")));
        gestion.val(moment().format("YYYY"));
        idPeriodo.selectpicker('refresh');
        gestion.selectpicker('refresh');
        asignaturasPorEstudiante(idGrupo,idPeriodo.val(),gestion.val())
        idGrupoStr.val(idGrupo.val().toString());
        /* Valores Iniciales del modal de vista de eventos */
        var encabezadoHorarioVista = $('#encabezadoHorarioVista');
        var pieHorarioVista = $('#pieHorarioVista');
        var mostrarMateria = $('#mostrarMateria');
        var mostrarGrupo = $('#mostrarGrupo');
        var mostrarDia = $('#mostrarDia');
        var mostrarAula = $('#mostrarAula');
        var mostrarGestion = $('#mostrarGestion');
        var mostrarActividad = $('#mostrarActividad');
        var mostrarHoras = $('#mostrarHoras');
        var btnCerrar = $('#btnCerrar')
        var verHorario = $('#verHorario');
        /* Estructurador de calendario */
        var calendarioVista = document.getElementById('calendarioVista');
        var calendar = new FullCalendar.Calendar(calendarioVista, {
            /* schedulerLicenseKey: '<YOUR-LICENSE-KEY-GOES-HERE>', */
            /* initialDate:"2021-12-24", */
            slotMinTime: "07:00:00",
            initialView: 'timeGridWeek',
            firstDay: 1,
            slotLabelFormat: 'H:mm',
            slotLabelInterval: "00:30",
            allDaySlot: false,
            locale: 'es',
            slotEventOverlap: true,
            nowIndicator: true,
            handleWindowResize: true,
            eventOverlap: false,
            expandRows:true,
            hiddenDays: [ 0 ],
            height:'auto',
            stickyHeaderDates:true,
            /* contentHeight: 700, */
            stickyFooterScrollbar: true,
            dayMinWidth:120,
            themeSystem: 'standard',
            longPressDelay:2500,
            views: {
                timeGridWeek: {
                    dayHeaderContent: function(arg) {
                        return moment(arg.date).format('dddd');
                    }
                }
            },  
            headerToolbar:false,
            eventContent:function(arg){
                let horaGrupo = document.createElement('div');
                let sigla = document.createElement('div');
                let docente = document.createElement('div');
                let actividad = document.createElement('div');
                let descripcion = document.createElement('div');
                horaGrupo.innerHTML = "<div class='d-flex justify-content-between intlin-1'><span>"+moment(arg.event.start).format('H:mm')+" - "+moment(arg.event.end).format('H:mm')+"</span><span>"+arg.event.extendedProps.grupo+"</span></div>";
                docente.innerHTML = "<div class='text-center font-italic intlin-2'>"+arg.event.extendedProps.docAbrev+"</div>";
                actividad.innerHTML = "<div class='text-center intlin-2'>"+arg.event.extendedProps.aulaAbrev+"</div>";
                if(arg.event.extendedProps.enlace || arg.event.extendedProps.descripcion){
                    sigla.innerHTML = "<div class='text-center lead intlin-2'>"+arg.event.title+" "+"<span class='badge badge-success'>i</span></div>"; 
                }else{
                    sigla.innerHTML = "<div class='text-center lead intlin-2'>"+arg.event.title+"</div>"; 
                }
                return { domNodes: [ horaGrupo,sigla,docente,actividad ] }
            },
            eventSources:[
                {
                    url: "{{ url('/horarios') }}",
                    method:'POST',
                    extraParams: function() {
                        var datos;
                        datos = {
                            idPeriodo:idPeriodo.val(),
                            gestion: gestion.val(),
                            idColor: idColor.val(),
                            idGrupo: idGrupo.val().toString(),
                            '_token': $("meta[name='csrf-token']").attr("content")
                        };
                        return datos;
                    }
                }
            ],
            eventClick: function(info) {
                datos = {
                    colorMateria: info.event.backgroundColor,
                    nombreMateria: info.event.extendedProps.nombreMat, 
                    textColor: info.event.textColor, 
                    grupo: info.event.extendedProps.grupo,
                    nombreDocente: info.event.extendedProps.docAbrev,
                    idAsignatura: info.event.extendedProps.idAsignatura,
                    dia: moment(info.event.extendedProps.dia).format("dddd"),
                    horaInicio: moment(info.event.start).format("H:mm"),
                    horaFinal: moment(info.event.end).format("H:mm"),
                    actividad: info.event.extendedProps.actividad,
                    aula:info.event.extendedProps.aula,
                    periodo:info.event.extendedProps.periodoAbrev,
                    gestion:info.event.extendedProps.gestion
                }
                vistaHorarios(datos); 
            }
        });
        calendar.render();
        /* Adecuar algunas propiedades del calendario */
        $('th').addClass('text-capitalize');
        $('th').addClass('fondo-plomo');
        $('.fc-license-message').addClass('d-none');
        var encabezado = $('div.fc-header-toolbar');
        encabezado.addClass('my-0 py-2');
        $('ul.navbar-nav').on('click',function(e){
            e.preventDefault();
            calendar.refetchEvents();
        });
        /* Formulario de vista de eventos */
        function vistaHorarios(datos){
            encabezadoHorarioVista.prop("style","background-color:"+datos.colorMateria+"; color:"+datos.textColor+";");
            pieHorarioVista.prop("style","background-color:"+datos.colorMateria+";");
            mostrarMateria.html(datos.nombreMateria);
            mostrarGrupo.html("Grupo "+datos.grupo + " - ");
            mostrarGrupo.append('<span class="font-italic">' + datos.nombreDocente + '</span>')
            mostrarDia.html(datos.dia);
            mostrarAula.html(datos.aula);
            mostrarGestion.html(datos.periodo+'/'+datos.gestion);
            mostrarActividad.html(datos.actividad);
            mostrarHoras.html(datos.horaInicio + " - " + datos.horaFinal);
            verHorario.modal();
        }
        generadores.on('change',function(e){
            e.preventDefault();
            idGrupoStr.val(idGrupo.val().toString());
            calendar.refetchEvents();
        });
        gestiones.on('change',function(e){
            e.preventDefault();
            idGrupoStr.val(idGrupo.val().toString());
            asignaturasPorEstudiante(idGrupo,idPeriodo.val(),gestion.val())
            /* calendar.refetchEvents(); */
        });
        btnLimpiar.on('click',function(e){
            e.preventDefault();
            idGrupo.selectpicker('deselectAll');
            idGrupo.selectpicker('refresh');
            calendar.refetchEvents();
        });
        btnExportar.on('click',function(e){
            e.preventDefault();
            $("iframe").remove();
            $("<iframe class='printpage'>")/* .hide() */
            .attr("src", "{{ url('/horarioEstPDF') }}"+"?idGrupo="+idGrupo.val().toString()+"&idPeriodo="+idPeriodo.val()+"&gestion="+gestion.val()+"&idColor="+idColor.val())
            .appendTo("#horarioImp");  
        });

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
        function asignaturasPorEstudiante(selector,idPeriodo,gestion){
            $.ajax({
                type:'POST',
                url:" {{ url('/asignatura/datosAsignatura') }}",
                data: {
                    dato: "asigEstudiante",
                    idPeriodo: idPeriodo,
                    gestion: gestion,                
                    '_token': $("meta[name='csrf-token']").attr("content")
                },
                success: function(resultado){
                    var respuesta = []
                    $(resultado).each(function(indice, valor){
                        respuesta.push(valor.id)
                    })
                    selector.selectpicker('val',respuesta);
                    selector.selectpicker('refresh');
                    calendar.refetchEvents();
                },
                error: function(){
                    $.alert("Hay un error al obtener las materias del estudiante");
                }
            });
        }


    })
</script> 
@stop