@extends('adminlte::page')

@section('title', 'Organizador ETN')

@section('content_header')
@stop
@section('content')
<!-- Panel de eventos del docente en modo edicion -->
<div class="row mt-1">
    <div class="col-12 col-sm-8 col-sm-9">
        <div class="lead font-weight-bold">EDITAR EVENTOS</div> 
        </div>
    <div class="col-12 col-sm-4 col-md-3">
        <div class="input-group mb-1">
            <div class="input-group-prepend">
                <span class="input-group-text bg-primario font-weight-normal">Gestión</span>
            </div>
            <select name='idPeriodo' id='idPeriodo' class="selectpicker form-control show-tick" required>
                @foreach($periodos as $valor)
                    <option value="{{ $valor->id }}" title="{{ $valor->periodoAbrev }}">{{ $valor->periodoAbrev }}</option>
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
<div class="row my-2">
    <div class="col-12 col-md-4">
        <div class="input-group">
            <div class="input-group-prepend">
                <label for="idAsignatura" class="input-group-text bg-primario font-weight-normal" id="addonMateria">Docencias:</label>
            </div>
            <select name='idAsignatura' id='idAsignatura' class="selectpicker form-control show-tick" aria-label="Small" aria-describedby="addonMateria"  data-style="btn-verdeClaro">
                @foreach($asignaturas as $valor)
                    <option value="{{ $valor->id }}" title="{{$valor->grupos->materias->sigla.' '.'Grupo '.$valor->grupos->grupo.' ('.$valor->actividades->actividad.')' }}" data-subtext="{{ 'Grupo '.$valor->grupos->grupo}}" showSubtext="true">{{ $valor->grupos->materias->nombreMat.' ('.$valor->grupos->materias->sigla.')'.' - '.$valor->actividades->actividad }}</option>
                @endforeach 
            </select> 
        </div>
    </div>
    <div class="col-12 col-sm-4">
        <div class="input-group mb-1">
            <div class="input-group-prepend">
                <label for="idActividad" class="input-group-text bg-primario font-weight-normal" id="addonActividad">Actividades</label>
            </div>
            <select name='idActividad' id='idActividad' class="selectpicker form-control show-tick" aria-label="Small" aria-describedby="addonIdActividad" data-style="btn-verdeClaro">
                <option value="">Todos</option>
                @foreach($actividades as $valor)
                    <option value="{{ $valor->id }}">{{ $valor->actividad }}</option>
                @endforeach  
            </select> 
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="input-group mb-1">
            <div class="input-group-prepend">
                <label for="idAula" class="input-group-text bg-primario font-weight-normal" id="addonActividad">Ver aulas</label>
            </div>
            <select name='idAula' id='idAula' class="selectpicker form-control show-tick" aria-label="Small" aria-describedby="addonActividad" data-style="btn-rojoClaro">
                <option value="">Ninguno</option>
                @foreach($aulas as $valor)
                    <option value="{{ $valor->id }}">{{ $valor->aula }}</option>
                @endforeach  
            </select> 
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div id="calendarioVista"></div>
    </div>
</div>
<!-- Modal para modificar, agregar o eliminar eventos-->
<div class="modal fade" id="modificarEventos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" id="encabezadoEvento">
                <div class="modal-title text-white">
                    <div id="modificarMateria" class="lead"></div>
                    <div class="font-weight-normal" id="modificarGrupo"></div>
                </div>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form action="">
            <div class="modal-body">
                <div class="text-danger" role="alert">
                    <ul id="errorValidacion" class="list-group-item-danger mb-1 mt-0">
                    </ul>
                </div>
                <input type="hidden" id="txtIdAcontecimiento">
                <input type="hidden" id="txtIdEvento">
                <input type="hidden" id="txtIdAsignatura">
                <div class="card text-center lead" role="alert" id="tipoAcont"></div>
                <div class="form-row">
                    <div class="col-12 col-sm-6">
                        <div class="form-row mb-2">
                            <label for="txtIdPeriodo" class="col-sm-4 col-form-label">Periodo:</label>
                            <div class='col-sm-8'>
                                <select name='txtIdPeriodo' id='txtIdPeriodo' class="selectpicker form-control show-tick" required>
                                <option value="">Elegir periodo</option>
                                    @foreach($periodos as $valor)
                                        <option value="{{ $valor->id }}" title="{{ $valor->periodo }}">{{ $valor->periodo }}</option>
                                    @endforeach 
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="form-row mb-2">
                            <label for="txtGestion" class="col-sm-4 col-form-label">Gestión:</label>
                            <div class='col-sm-8'>
                                <select name='txtGestion' id='txtGestion' class="selectpicker form-control show-tick" required>
                                <option value="">Elegir gestión</option>
                                    @foreach($gestiones as $valor)
                                        <option value="{{ $valor }}">{{ $valor }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-12 col-sm-6">
                        <div id='editarFecha' class="form-row">
                            <label for="txtFecha" class="col-sm-3 col-form-label">Fecha:</label>
                            <div class="col-sm-9">
                                <input type="date" id="txtFecha" class="form-control" placeholder="Fecha evento" autocomplete="off" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="form-row mb-2">
                            <label for="txtIdAula" class="col-sm-3 col-form-label">Aula:</label>
                            <div class='col-sm-9'>
                                <select name='txtIdAula' id='txtIdAula' class="selectpicker form-control show-tick" required>
                                    <option value="">Elegir aula</option>
                                    @foreach($aulas as $valor)
                                        <option value="{{ $valor->id }}">{{ $valor->aula }}</option>
                                    @endforeach
                                </select> 
                            </div> 
                        </div>            
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-12 col-sm-6">
                        <div class="form-row mb-2">
                            <label for="txtHoraInicio" class="col-sm-5 col-form-label">Hora inicio:</label>
                            <div class='col-sm-7 input-group clockpicker' data-autoclose='true'>
                                <input type="text" id="txtHoraInicio" class="form-control" placeholder="Hora inicio" autocomplete="off" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="form-row mb-2">
                            <label for="txtHoraFinal" class="col-sm-5 col-form-label">Hora final:</label>
                            <div class='col-sm-7 input-group clockpicker' data-autoclose='true'>
                                <input type="text" id="txtHoraFinal" class="form-control" placeholder="Hora final" autocomplete="off" required>
                            </div> 
                        </div> 
                    </div>

                </div>
                <div class="form-row mb-2">
                    <label for="txtIdActividad" class="col-sm-3 col-form-label">Actividad:</label>
                    <div class='col-sm-9'>
                        <select name='txtIdActividad' id='txtIdActividad' class="selectpicker form-control show-tick" required>
                            <option value="">Elegir actividad</option>
                            @foreach($actividades as $valor)
                                <option value="{{ $valor->id }}">{{ $valor->actividad }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-row mb-2">
                    <label for="txtDescripcion" class="col-sm-3 col-form-label">Tema desarrollado:</label>
                    <div class='col-sm-9'>
                        <textarea type="text" id="txtDescripcion" rows="3" class="form-control" placeholder="Escribe el tema desarrollado" required></textarea>
                    </div>                 
                </div>
                <div class="form-row mb-2">
                    <label for="txtEnlace" class="col-sm-3 col-form-label">Enlace:</label>
                    <div class='col-sm-9'>
                        <textarea type="text" id="txtEnlace" rows="3" class="form-control" placeholder="Escribe el enlace" required></textarea>
                    </div>                 
                </div>
            </div>
            <div class="modal-footer" id="pieEvento">
                <button type='button' class="btn btn-success btn-sm" id='btnAgregar'>Agregar</button>
                <button type="button" class="btn btn-primary btn-sm" id='btnEditar'>Guardar cambios</button>
                <button type="button" class="btn btn-danger btn-sm" id='btnEliminar'>Eliminar</button>
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancelar</button>
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
        var idAsignatura = $('#idAsignatura');
        var idAula = $('#idAula');
        var idPeriodo = $('#idPeriodo');
        var gestion = $('#gestion');
        var idActividad = $('#idActividad');
        var filtros = $('#idAsignatura,#idAula,#idPeriodo,#gestion');
        var clockpicker = $('.clockpicker');
        /* Variables para el modal de vista de eventos */
        var encabezadoEvento = $('#encabezadoEvento');
        var pieEvento = $('#pieEvento');
        var modificarMateria = $('#modificarMateria');
        var modificarGrupo = $('#modificarGrupo');
        var btnAgregar = $('#btnAgregar');
        var btnEditar = $('#btnEditar');
        var btnEliminar = $('#btnEliminar');
        var txtIdEvento = $('#txtIdEvento');
        var txtIdAcontecimiento = $('#txtIdAcontecimiento');
        var tipoAcont = $('#tipoAcont');
        var txtIdAsignatura = $('#txtIdAsignatura');
        var txtIdActividad = $('#txtIdActividad');
        var txtDescripcion = $('#txtDescripcion');
        var txtEnlace = $('#txtEnlace');
        var txtFecha = $('#txtFecha');
        var txtHoraInicio = $('#txtHoraInicio');
        var txtHoraFinal = $('#txtHoraFinal');
        var txtIdAula = $('#txtIdAula');
        var txtIdPeriodo = $('#txtIdPeriodo');
        var txtGestion = $('#txtGestion');
        var modificarEventos = $('#modificarEventos');
        clockpicker.clockpicker();
        idPeriodo.val(convPeriodo(moment().format("MM"))),
        gestion.val(moment().format("YYYY"))
        idPeriodo.selectpicker('refresh');
        gestion.selectpicker('refresh');
        /* Estructurador de calendario */
        var calendarioVista = document.getElementById('calendarioVista');
        var calendar = new FullCalendar.Calendar(calendarioVista, {
            /* schedulerLicenseKey: '<YOUR-LICENSE-KEY-GOES-HERE>', */
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
            height:'auto',
            stickyHeaderDates:true,
            /* contentHeight: 700, */
            stickyFooterScrollbar: true,
            dayMinWidth:120,
            themeSystem: 'standard',
            longPressDelay:2500,
            views: {
                dayGridMonth: {
                    dayHeaderContent: function(arg) {
                    return moment(arg.date).format('dddd');
                    }
                },
                timeGridWeek: {
                    dayHeaderContent: function(arg) {
                    return moment(arg.date).format('dddd D');
                    }
                },
                timeGridDay: {
                    dayHeaderContent: function(arg) {
                    return moment(arg.date).format('dddd D');;
                    },
                    titleFormat:'MMMM D / YYYY'
                }
            },  
            headerToolbar:{ 
                left:'prev,next,today',
                center: 'title',
                right:'dayGridMonth,timeGridWeek,timeGridDay'
            },
            eventContent:function(arg){
                if (arg.event.extendedProps.idEvento) {
                    let horaGrupo = document.createElement('div');
                    let sigla = document.createElement('div');
                    let docente = document.createElement('div');
                    let actividad = document.createElement('div');
                    let descripcion = document.createElement('div');
                    switch (arg.view.type) {
                        case 'dayGridMonth':      
                            break;
                        case 'timeGridWeek':
                            horaGrupo.innerHTML = "<div class='d-flex justify-content-between intlin-1'><span>"+moment(arg.event.start).format('H:mm')+" - "+moment(arg.event.end).format('H:mm')+"</span><span>"+arg.event.extendedProps.grupo+"</span></div>";
                            docente.innerHTML = "<div class='text-center font-italic intlin-2'>"+arg.event.extendedProps.docAbrev+"</div>";
                            actividad.innerHTML = "<div class='text-center intlin-2'>"+arg.event.extendedProps.aulaAbrev+"</div>";
                            if(arg.event.extendedProps.enlace || arg.event.extendedProps.descripcion){
                                sigla.innerHTML = "<div class='text-center lead intlin-2'>"+arg.event.title+" "+"<span class='badge badge-success'>i</span></div>"; 
                            }else{
                                sigla.innerHTML = "<div class='text-center lead intlin-2'>"+arg.event.title+"</div>"; 
                            }
                            return { domNodes: [ horaGrupo,sigla,docente,actividad ] }
                            break;
                        case 'timeGridDay':
                            horaGrupo.innerHTML = "<div class='d-flex justify-content-between intlin-1'><span>"+moment(arg.event.start).format('HH:mm')+"-"+moment(arg.event.end).format('HH:mm')+"</span><span class='font-italic'>"+arg.event.extendedProps.docAbrev+"</span></div>";
                            sigla.innerHTML = "<div class='text-center intlin-2'>"+arg.event.extendedProps.nombreMat+" ("+arg.event.title+") - Grupo "+arg.event.extendedProps.grupo+"</div>";
                            if(arg.event.extendedProps.enlace || arg.event.extendedProps.descripcion){
                                actividad.innerHTML = "<div class='text-center'><span class='text-uppercase lead intlin-2'>"+arg.event.extendedProps.actividad+" "+"</span><a class='badge badge-success '>ver detalles</a></div>";
                                descripcion.innerHTML = "<div class='text-center'><span  class='text-justify d-inline-block text-truncate intlin-2' style='max-width: 150px;'>"+arg.event.extendedProps.descripcion+"</span><span class='d-inline-block text-truncate intlin-2 text-primary' style='max-width: 150px;'>"+arg.event.extendedProps.enlace+"</span></div>";
                            }else{
                                actividad.innerHTML = "<div class='text-center lead intlin-2'><span class='text-uppercase'>"+arg.event.extendedProps.actividad+" - </span><span>"+arg.event.extendedProps.aulaAbrev+"</span></div>";
                            }
                            return { domNodes: [ horaGrupo,sigla,actividad,descripcion ] }
                            break;                   
                        default:
                            break;
                    }
                } else {
                    return false;
                }
            },
            eventSources:[
                {
                    url: "{{ url('/evDocente') }}",
                    method:'POST',
                    extraParams: function() {
                        var datos;
                        datos = {
                            idPeriodo: idPeriodo.val(),
                            gestion: gestion.val(),
                            idGrupo: '',
                            idAsignatura: idAsignatura.val(),
                            idActividad: idActividad.val(),
                            idAula: '',
                            '_token': $("meta[name='csrf-token']").attr("content"),
                            modoEdicion: true
                        };
                        console.log(datos);
                        return datos;
                    },
                    textColor: 'white'
                },
                {
                    url: "{{ url('/evAula') }}",
                    method:'POST',
                    extraParams: function() {
                        var datos;
                        datos = {
                            idPeriodo: idPeriodo.val(),
                            gestion: gestion.val(),
                            idAula: idAula.val(),
                            idAsignatura: idAsignatura.val(),
                            '_token': $("meta[name='csrf-token']").attr("content")
                        };
                        return datos;
                    },
                    color: 'red',
                    display: 'background'
                },
                {
                    url: "{{ url('/evSemestre') }}",
                    method:'POST',
                    extraParams: function() {
                        var datos;
                        datos = {
                            idAsignatura: idAsignatura.val(),
                            idPeriodo: idPeriodo.val(),
                            gestion: gestion.val(),
                            '_token': $("meta[name='csrf-token']").attr("content")
                        };
                        return datos;
                    },
                    color: 'cyan',
                    display: 'background'
                },
                {
                    url: "{{ url('/evAuxiliar') }}",
                    method:'POST',
                    extraParams: function() {
                        var datos;
                        datos = {
                            idAsignatura: idAsignatura.val(),
                            idPeriodo: idPeriodo.val(),
                            gestion: gestion.val(),
                            '_token': $("meta[name='csrf-token']").attr("content")
                        };
                        return datos;
                    },
                    color: 'orange',
                    textColor: 'black'
                }             
            ],
            dateClick: function(info) {
                datos = {
                    colorMateria: '#343A40',
                    nombreMateria: 'NUEVO EVENTO', 
                    grupo: '',
                    nombreDocente: '',
                    idAsignatura: idAsignatura.val(),
                    idEvento: '',
                    idAcontecimiento: 2,
                    fecha: moment(info.date).format("YYYY-MM-DD"),
                    horaInicio:  moment(info.date).format("HH:mm"),
                    horaFinal: moment(info.date).add(90,'m').format("HH:mm"),
                    idActividad: '',
                    idAula: idAula.val(),
                    descripcion:'',
                    enlace: '',
                    idPeriodo:idPeriodo.val(),
                    gestion: gestion.val(),
                    filtrado: 'true', 
                    modo: 'nuevo'
                }
                formularioEvento(datos);
            },
            eventClick: function(info) {
                datos = {
                    colorMateria: info.event.backgroundColor,
                    nombreMateria: info.event.extendedProps.nombreMat, 
                    grupo: info.event.extendedProps.grupo,
                    nombreDocente: info.event.extendedProps.docAbrev,
                    idAsignatura: info.event.extendedProps.idAsignatura,
                    idEvento: info.event.extendedProps.idEvento,
                    idAcontecimiento: info.event.extendedProps.idAcontecimiento,
                    fecha: moment(info.event.start).format("YYYY-MM-DD"),
                    horaInicio: moment(info.event.start).format("HH:mm"),
                    horaFinal: moment(info.event.end).format("HH:mm"),
                    idActividad: info.event.extendedProps.idActividad,
                    idAula:info.event.extendedProps.idAula,
                    descripcion:info.event.extendedProps.descripcion,
                    enlace: info.event.extendedProps.enlace,
                    idPeriodo: info.event.extendedProps.idPeriodo,
                    gestion: info.event.extendedProps.gestion,
                    filtrado: info.event.extendedProps.filtrado,
                    sigla: info.event.title,
                    modo: 'edicion'
                }
                formularioEvento(datos);
            },
            eventDrop: function(info){
                datos = {
                    colorMateria: info.event.backgroundColor,
                    nombreMateria: info.event.extendedProps.nombreMat, 
                    grupo: info.event.extendedProps.grupo,
                    nombreDocente: info.event.extendedProps.docAbrev,
                    idAsignatura: info.event.extendedProps.idAsignatura,
                    idEvento: info.event.extendedProps.idEvento,
                    idAcontecimiento: info.event.extendedProps.idAcontecimiento,
                    fecha: moment(info.event.start).format("YYYY-MM-DD"),
                    horaInicio: moment(info.event.start).format("HH:mm"),
                    horaFinal: moment(info.event.end).format("HH:mm"),
                    idActividad: info.event.extendedProps.idActividad,
                    descripcion:info.event.extendedProps.descripcion,
                    enlace: info.event.extendedProps.enlace,
                    idPeriodo: info.event.extendedProps.idPeriodo,
                    gestion: info.event.extendedProps.gestion,
                    filtrado: info.event.extendedProps.filtrado,
                    modo: 'grafico'
                }
                if (idAula.val()=="") {
                    datos.idAula = info.event.extendedProps.idAula;
                }else{
                    datos.idAula = idAula.val();
                }
                formularioEvento(datos);
                datosEvento = recolectarEvento('PATCH');
                enviarEvento("/",datosEvento);               
            },
            eventResize: function(info){
                datos = {
                    colorMateria: info.event.backgroundColor,
                    nombreMateria: info.event.extendedProps.nombreMat, 
                    grupo: info.event.extendedProps.grupo,
                    nombreDocente: info.event.extendedProps.docAbrev,
                    idAsignatura: info.event.extendedProps.idAsignatura,
                    idEvento: info.event.extendedProps.idEvento,
                    idAcontecimiento: info.event.extendedProps.idAcontecimiento,
                    fecha: moment(info.event.start).format("YYYY-MM-DD"),
                    horaInicio: moment(info.event.start).format("HH:mm"),
                    horaFinal: moment(info.event.end).format("HH:mm"),
                    idActividad: info.event.extendedProps.idActividad,
                    descripcion:info.event.extendedProps.descripcion,
                    enlace: info.event.extendedProps.enlace,
                    idPeriodo: info.event.extendedProps.idPeriodo,
                    gestion: info.event.extendedProps.gestion,
                    filtrado: info.event.extendedProps.filtrado,
                    modo: 'grafico'
                }
                if (idAula.val()=="") {
                    datos.idAula = info.event.extendedProps.idAula;
                }else{
                    datos.idAula = idAula.val();
                }
                formularioEvento(datos);
                datosEvento = recolectarEvento('PATCH');
                enviarEvento("/",datosEvento);               
            }
        });
        calendar.render();
        /* Adecuar algunas propiedades del calendario */
        $('th').addClass('text-capitalize');
        $('th').addClass('fondo-plomo');
        $('.fc-license-message').addClass('d-none');
        $('.fc-toolbar-title').addClass('text-capitalize')
        $('.fc-button').on('click',function(){
            $('th').addClass('text-capitalize');
            $('th').addClass('fondo-plomo');
        });
        /* Actualizar tamaño del calendario */
        $('div.fc-header-toolbar').addClass('my-0 py-2');
        $('ul.navbar-nav').on('click',function(e){
            e.preventDefault();
            calendar.refetchEvents();
        });
        /* Funcion para establecer los datos del evento en el modal */
        function formularioEvento(datos){
            $('#errorValidacion').html('');
            txtIdAsignatura.val(datos.idAsignatura);
            txtFecha.val(datos.fecha);
            txtHoraInicio.val(datos.horaInicio);
            txtHoraFinal.val(datos.horaFinal);
            txtIdActividad.val(datos.idActividad);
            txtIdAula.val(datos.idAula);
            txtIdAcontecimiento.val(datos.idAcontecimiento);
            txtDescripcion.val(datos.descripcion);
            txtEnlace.val(datos.enlace);
            txtIdPeriodo.val(datos.idPeriodo);
            txtGestion.val(datos.gestion);
            switch (datos.modo) {
                case 'edicion':
                    txtIdEvento.val(datos.idEvento); 
                    encabezadoEvento.prop("style","background-color:"+datos.colorMateria+";");
                    pieEvento.prop("style","background-color:"+datos.colorMateria+";");
                    modificarMateria.html(datos.nombreMateria+' ('+datos.sigla+')');
                    modificarGrupo.html("Grupo " +datos.grupo + " - ");
                    modificarGrupo.append('<span class="font-italic">' + datos.nombreDocente + '</span>')
                    btnAgregar.hide();
                    btnEditar.show();
                    if(datos.idAcontecimiento=='1'){
                        tipoAcont.html('Evento recurrente');
                        tipoAcont.removeClass('alert-success');
                        tipoAcont.addClass('alert-danger');
                        btnEliminar.hide();
                        txtFecha.attr("disabled",true);
                        txtHoraInicio.attr("disabled",true);
                        txtHoraFinal.attr("disabled",true);
                        txtIdAula.attr("disabled",true);
                        txtIdPeriodo.attr("disabled",true);
                        txtGestion.attr("disabled",true);
                    }else{
                        tipoAcont.html('Evento único');
                        tipoAcont.removeClass('alert-danger');
                        tipoAcont.addClass('alert-success');
                        btnEliminar.show();
                        txtFecha.prop("disabled",false);
                        txtHoraInicio.prop("disabled",false);
                        txtHoraFinal.prop("disabled",false);
                        txtIdAula.prop("disabled",false);
                        txtIdPeriodo.attr("disabled",false);
                        txtGestion.attr("disabled",false);
                    }
                    if (datos.filtrado=='true') {
                        modificarEventos.modal();
                    }       
                    break;
                case 'nuevo':
                    modificarGrupo.html("");
                    txtIdEvento.val('');
                    tipoAcont.html('Evento único');
                    tipoAcont.removeClass('alert-danger');
                    tipoAcont.addClass('alert-success');
                    $.ajax({
                        type:'POST',
                        url:"/asignatura/datosAsignatura",
                        data: {
                            dato: 'todos',
                            identificador: datos.idAsignatura,
                            '_token': $("meta[name='csrf-token']").attr("content")
                        },
                        success: function(respuesta){
                            encabezadoEvento.prop("style","background-color:"+respuesta.color+";");
                            pieEvento.prop("style","background-color:"+respuesta.color+";");
                            modificarMateria.html(respuesta.nombreMat+' ('+respuesta.sigla+')');
                            modificarGrupo.html("Grupo " +respuesta.grupo + " - ");
                            modificarGrupo.append('<span class="font-italic">' + respuesta.docAbrev + '</span>');         
                        },
                        error: function(){
                            $.alert("Hay un error al obtener los datos de la materia");
                        }
                    });
                    btnAgregar.show();
                    btnEditar.hide();
                    btnEliminar.hide();
                    txtFecha.prop("disabled",false);
                    txtHoraInicio.prop("disabled",false);
                    txtHoraFinal.prop("disabled",false);
                    txtIdAula.prop("disabled",false);
                    modificarEventos.modal();     
                    break;
                case 'grafico':
                    txtIdEvento.val(datos.idEvento);
                    break;
            }
            txtIdActividad.selectpicker('refresh');
            txtIdAula.selectpicker('refresh');
            txtIdPeriodo.selectpicker('refresh');
            txtGestion.selectpicker('refresh');
        }
        /* Funcion para recolectar los datos del formulario */
        function recolectarEvento(method){
            datosEvento = {
                id: txtIdEvento.val(),
                asignatura: txtIdAsignatura.val(),
                actividad: txtIdActividad.val(),
                aula: txtIdAula.val(),
                tema_desarrollado: txtDescripcion.val(),
                enlace: txtEnlace.val(),
                fecha: txtFecha.val(),
                periodo: txtIdPeriodo.val(),
                gestion: txtGestion.val(),
                acontecimiento_id: txtIdAcontecimiento.val(),
                hora_inicio: txtHoraInicio.val(),
                hora_final: txtHoraFinal.val(),
                '_token': $("meta[name='csrf-token']").attr("content"),
                '_method': method
            };
            return(datosEvento)
        };
        /* Eventos para agregar un nuevo evento */
        btnAgregar.on('click',function(e){
        e.preventDefault();
            datosEvento = recolectarEvento('POST');
            $.confirm({
                icon: 'fas fa-plus-circle',
                title: 'Crear evento',
                content: '¿Confirma crear el evento '+$('#txtIdActividad :selected').text()+' en '+$('#idAsignatura :selected').text()+'?',
                backgroundDismiss: true,
                type: 'green',
                buttons: {
                    confirmar:{
                        text:'Confirmar',
                        btnClass: 'btn-success',
                        action: function(){
                            enviarEvento("",datosEvento);
                        }
                    },
                    cancelar: {
                        text:'Cancelar',
                        btnClass: 'btn-secondary',
                        action: function(){}
                    }
                }
            });
        });
        /* Eventos para editar un evento  */
        btnEditar.on('click',function(e){
            e.preventDefault();
            datosEvento = recolectarEvento('PATCH');
            $.confirm({
                icon: 'fas fa-edit',
                title: 'Editar evento',
                content: '¿Confirma guardar cambios del evento de '+$('#txtIdActividad :selected').text()+' en '+$('#idAsignatura :selected').text()+'?',
                backgroundDismiss: true,
                type: 'blue',
                buttons: {
                    confirmar:{
                        text:'Confirmar',
                        btnClass: 'btn-info',
                        action: function(){
                        enviarEvento("/",datosEvento);
                        }
                    },
                    cancelar: {
                        text:'Cancelar',
                        btnClass: 'btn-secondary',
                        action: function(){}
                    }
                }
            });
        });
        /* Eventos para eliminar un evento  */
        btnEliminar.on('click',function(e){
            e.preventDefault();
            datosEvento = recolectarEvento('DELETE');
            $.confirm({
                icon: 'fas fa-exclamation-triangle',
                title: '¿Eliminar evento?',
                content: 'Recuerde que una vez eliminado el evento de '+$('#txtIdActividad :selected').text()+' en '+$('#idAsignatura :selected').text()+' no se pueden recuperar sus datos.',
                type: 'red',
                buttons: {
                    confirmar: {
                        text:'Confirmar',
                        btnClass: 'btn-danger',
                        action: function () {
                        enviarEvento("/",datosEvento);
                        }
                    },
                    cancelar: {
                        text:'Cancelar',
                        btnClass: 'btn-secondary',
                        action: function(){}
                    }
                }
            });
        });
        /* Funcion para enviar evento para gestionarlo */
        function enviarEvento(accion,datos){
            $.ajax({
                type:'POST',
                url:"{{ url('/evento') }}"+accion+datos.id,
                data: datos,
                success: function(msg){
                    if(msg){
                        modificarEventos.modal('hide');
                        calendar.refetchEvents()
                    }
                },
                error: function(error){
                    $('#errorValidacion').html('');
                    $(error.responseJSON.errors).each(function(indice, valor){
                        $.each( valor, function( key, value ) {
                            $.each( value, function( key1, value1 ) {
                                $('#errorValidacion').append('<li class="py-0">'+value1+'</li>');
                            });
                        });
                    })
                /* $.alert('Hay un ERROR al guardar los cambios'); */
                }
            });
        }
        filtros.on('change',function(e){
            e.preventDefault();
            calendar.refetchEvents();
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
    })
    Push.Permission.request();
    function alarmaEvento(){
        var datos = {
            fecha: moment().format('YYYY-MM-DD'),
            tiempoAntes: moment().format('HH:mm:ss'),
            tiempoDespues: moment().add(5, 'minutes').format('HH:mm:ss'),
            '_token': $("meta[name='csrf-token']").attr("content")
        }
        $.ajax({
            type:'post',
            url:'/evAlarma',
            data: datos,
            success: function(respuesta){
                $(respuesta).each(function(indice, valor){
                    Push.create(valor.nombreMat+' '+valor.title+' - Grupo '+valor.grupo, {
                        body: valor.actividad+' ('+moment(valor.horaInicio,'HH:mm:ss').format('H:mm')+'-'+moment(valor.horaFinal,'HH:mm:ss').format('H:mm')+') - '+valor.aulaAbrev,
                        icon: '{{ asset("logos/agenda-recordatorio.png") }}',
                        /* equireInteraction: true, */
                        tag:"'"+valor.idEvento+"'",
                        vibrate: [200, 100],
                        timeout: 60000,
                        silent: true,
                        onClick: function () {
                            window.focus();
                            if (valor.enlace) {
                                window.open(valor.enlace,'_blank');
                            }
                            this.close("'"+valor.idEvento+"'");
                            this.clear();
                        }
                    });
                })
            }
        });
    }
    setInterval('alarmaEvento()',60000);
</script> 
@stop