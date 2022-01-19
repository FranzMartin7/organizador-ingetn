@extends('adminlte::page')

@section('title', 'Organizador ETN')

@section('content_header')

@stop
@section('content')
<!-- Panel de eventos del docente en modo vista -->
<div class="row mt-1">
    <div class="col-12 col-sm-8">
        <div class="lead font-weight-bold">EDITAR EVENTOS</div> 
    </div>
    <div class="col-12 col-sm-4">
        <div class="input-group">
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
<div class="row mt-2">
    <div class="col-12 col-md-4">
        <div class="input-group">
            <div class="input-group-prepend">
                <label for="idSemestre" class="input-group-text bg-primario font-weight-normal" id="addonIdSemestre">Semestre</label>
            </div>
            <select name='idSemestre' id='idSemestre' class="selectpicker form-control show-tick" aria-label="Small" aria-describedby="addonIdSemestre" required>
                @foreach($semestres as $valor)
                    <option value="{{ $valor->id }}">{{ $valor->semestre }}</option>
                @endforeach 
            </select>
            <div class="input-group-append">
                <button class="btn btn-success" type="button" data-toggle="collapse" data-target="#filtros" aria-controls="filtros" aria-expanded="false" title="Ver filtros"> <i class="fas fa-filter"></i></button>
            </div> 
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="input-group">
            <div class="input-group-prepend">
                <label for="idMencion" class="input-group-text bg-primario font-weight-normal" id="addonIdMencion">Mención</label>
            </div>
            <select name='idMencion' id='idMencion' class="selectpicker form-control show-tick" aria-label="Small" aria-describedby="addonIdMencion" required>
                @foreach($menciones as $valor)
                    <option value="{{ $valor->id }}">{{ $valor->mencion }}</option>
                @endforeach 
            </select> 
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="input-group">
            <div class="input-group-prepend">
                <label for="idAula" class="input-group-text bg-primario font-weight-normal" id="addonIdAula">Ver aula</label>
            </div>
            <select name='idAula' id='idAula' class="selectpicker form-control show-tick" aria-label="Small" aria-describedby="addonIdAula"  data-style="btn-rojoClaro">
                <option value="">Ninguno</option>
                @foreach($aulas as $valor)
                    <option value="{{ $valor->id }}">{{ $valor->aula }}</option>
                @endforeach 
            </select> 
        </div>
    </div>
</div>
<div class="row mt-1 collapse" id="filtros">
    <div class="col-12 col-sm-6">
        <div class="input-group">
            <div class="input-group-prepend">
                <label for="idGrupo" class="input-group-text bg-primario font-weight-normal" id="addonidGrupo">Materia</label>
            </div>
            <select name='idGrupo' id='idGrupo' class="selectpicker form-control show-tick" aria-label="Small" aria-describedby="addonidGrupo" data-style="btn-verdeClaro">
            <option value="">Todos</option>
            </select> 
        </div>
    </div>
    <div class="col-12 col-sm-6">
        <div class="input-group">
            <div class="input-group-prepend">
                <label for="idActividad" class="input-group-text bg-primario font-weight-normal" id="addonIdActividad">Actividad</label>
            </div>
            <select name='idActividad' id='idActividad' class="selectpicker form-control show-tick" aria-label="Small" aria-describedby="addonIdActividad"  data-style="btn-verdeClaro">
                <option value="">Todos</option>
                @foreach($actividades as $valor)
                    <option value="{{ $valor->id }}">{{ $valor->actividad }}</option>
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
            <div class="modal-header" id="encabezadoEventoModificar">
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
                <div class="card text-center lead" role="alert" id="tipoAcont"></div>
                <div class="form-row">
                    <div class="col-12 col-sm-6">
                        <div class="form-row mb-2">
                            <label for="txtIdPeriodo" class="col-sm-4 col-form-label">Periodo:</label>
                            <div class='col-sm-8'>
                                <select name='txtIdPeriodo' id='txtIdPeriodo' class="form-control" required>
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
                                <select name='txtGestion' id='txtGestion' class="form-control" required>
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
                    <div class="col-12">
                        <div class="form-row mb-2">
                            <label for="txtIdAsignatura" class="col-sm-3 col-form-label">Asignatura:</label>
                            <div class='col-sm-9'>
                                <select name='txtIdAsignatura' id='txtIdAsignatura' class="selectpicker form-control" required>
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
                                <select name='txtIdAula' id='txtIdAula' class="form-control" required>
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
                        <select name='txtIdActividad' id='txtIdActividad' class="form-control" required>
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
                        <textarea type="text" id="txtDescripcion" rows="3" class="form-control" placeholder="Escribe el título del tema desarrollado" required></textarea>
                    </div>                 
                </div>
                <div class="form-row mb-2">
                    <label for="txtEnlace" class="col-sm-3 col-form-label">Enlace:</label>
                    <div class='col-sm-9'>
                        <textarea type="text" id="txtEnlace" rows="3" class="form-control" placeholder="Escribe el enlace" required></textarea>
                    </div>                 
                </div>
            </div>
            <div class="modal-footer" id="pieEventoModificar">
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
        var idSemestre = $('#idSemestre');
        var idMencion = $('#idMencion');
        var idPeriodo = $('#idPeriodo');
        var gestion = $('#gestion');
        var idGrupo = $('#idGrupo');
        var idActividad = $('#idActividad');
        var idAula = $('#idAula');
        var filtros = $('#idGrupo,#idAula,#idActividad');
        var generadores = $('#idSemestre,#idMencion,#idPeriodo,#gestion');
        var clockpicker = $('.clockpicker');
    /* Variables para el modal de vista de eventos */
        var encabezadoEventoModificar = $('#encabezadoEventoModificar');
        var pieEventoModificar = $('#pieEventoModificar');
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
        txtIdActividad.selectpicker();
        txtIdAula.selectpicker();
        txtIdPeriodo.selectpicker();
        txtGestion.selectpicker();
        clockpicker.clockpicker();
        idPeriodo.val(convPeriodo(moment().format('MM')));
        gestion.val(moment().format("YYYY"));
        idPeriodo.selectpicker('refresh')
        gestion.selectpicker('refresh')
        asignaturasSemestre(idSemestre.val(),idMencion.val(),txtIdAsignatura);
        gruposSemestre(idSemestre.val(),idMencion.val(),idGrupo);
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
                    },
                    titleFormat:'MMMM YYYY'
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
                    titleFormat:'MMMM D, YYYY'
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
                    url: "{{ url('/evento/show') }}",
                    extraParams: function() {
                        var datos;
                        datos = {
                            idSemestre: idSemestre.val(),
                            idMencion: idMencion.val(),
                            idPeriodo: idPeriodo.val(),
                            gestion: gestion.val(),
                            idAsignatura: '',
                            idActividad: idActividad.val(),
                            idAula: '',
                            idGrupo: idGrupo.val(),
                            modoEdicion: true,
                            '_token': $("meta[name='csrf-token']").attr("content")
                        };
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
                            '_token': $("meta[name='csrf-token']").attr("content")
                        };
                        return datos;
                    },
                    color: 'red',
                    display: 'background'
                }           
            ],
            dateClick: function(info) {
                datos = {
                    colorMateria: '#343A40',
                    nombreMateria: 'NUEVO EVENTO', 
                    grupo: '',
                    nombreDocente: '',
                    idAsignatura: '',
                    idEvento: '',
                    idAcontecimiento: 2,
                    fecha: moment(info.date).format("YYYY-MM-DD"),
                    horaInicio:  moment(info.date).format("HH:mm"),
                    horaFinal: '',
                    idActividad: idActividad.val(),
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
        /* Formulario de edicion de eventos */
        function formularioEvento(datos){
            $('#errorValidacion').html('');
            encabezadoEventoModificar.prop("style","background-color:"+datos.colorMateria+";");
            pieEventoModificar.prop("style","background-color:"+datos.colorMateria+";");
            modificarMateria.html(datos.nombreMateria);
            txtIdEvento.val(datos.idEvento);
            txtIdAsignatura.val(datos.idAsignatura);
            txtFecha.val(datos.fecha);
            txtHoraInicio.val(datos.horaInicio);
            txtHoraFinal.val(datos.horaFinal);
            txtIdActividad.val(datos.idActividad);
            txtIdAula.val(datos.idAula);
            txtDescripcion.val(datos.descripcion);
            txtEnlace.val(datos.enlace);
            txtIdAcontecimiento.val(datos.idAcontecimiento);
            txtIdPeriodo.val(datos.idPeriodo);
            txtGestion.val(datos.gestion);
            txtIdAula.selectpicker('refresh');
            txtIdAsignatura.selectpicker('refresh');
            txtIdActividad.selectpicker('refresh');
            txtIdAula.selectpicker('refresh');
            txtIdPeriodo.selectpicker('refresh');
            txtGestion.selectpicker('refresh');
            switch (datos.modo) {
                case 'edicion':

                    modificarGrupo.html("Grupo " +datos.grupo + " - ");
                    modificarGrupo.append('<span class="font-italic">' + datos.nombreDocente + '</span>')
                    btnAgregar.hide();
                    btnEditar.show();
                    txtFecha.prop("disabled",false);
                    txtHoraInicio.prop("disabled",false);
                    txtHoraFinal.prop("disabled",false);
                    txtIdAula.prop("disabled",false);
                    if(datos.idAcontecimiento=='1'){
                        tipoAcont.html('Evento recurrente');
                        tipoAcont.removeClass('alert-success');
                        tipoAcont.addClass('alert-danger');
                        btnEliminar.hide();
                    }else{
                        tipoAcont.html('Evento único');
                        tipoAcont.removeClass('alert-danger');
                        tipoAcont.addClass('alert-success');
                        btnEliminar.show();
                    }
                    if (datos.filtrado) {
                        modificarEventos.modal();
                    }       
                    break;
                case 'nuevo':
                    tipoAcont.html('Evento único');
                    tipoAcont.removeClass('alert-danger');
                    tipoAcont.addClass('alert-success');
                    modificarGrupo.html("");
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
                    
                    break;
            }
        }
        /* Funcion para recolectar los datos del formulario */
        function recolectarEvento(method){
            datosEvento = {
                id: txtIdEvento.val(),
                asignatura: txtIdAsignatura.val(),
                actividad: txtIdActividad.val(),
                acontecimiento_id: txtIdAcontecimiento.val(),
                aula: txtIdAula.val(),
                tema_desarrollado: txtDescripcion.val(),
                enlace: txtEnlace.val(),
                fecha: txtFecha.val(),
                hora_inicio: txtHoraInicio.val(),
                hora_final: txtHoraFinal.val(),
                periodo: txtIdPeriodo.val(),
                gestion: txtGestion.val(),
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
                content: '¿Confirma crear éste nuevo evento en la materia?',
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
                content: '¿Confirma editar los datos de éste evento?',
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
                content: 'Recuerde que una vez eliminado éste evento de la materia no se pueden recuperar sus datos.',
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
        /* Filtros de vista del calendario */
        filtros.on('change',function(e){
            e.preventDefault();
            calendar.refetchEvents();
        });
        /* Actualizar tamaño del calendeario */
        var encabezado = $('div.fc-header-toolbar');
        encabezado.addClass('my-0 py-2');
        $('ul.navbar-nav').on('click',function(e){
            e.preventDefault();
            calendar.refetchEvents();
        });

        /* Evento para generar eventos por semestre y mencion */
        generadores.on('change', function (e) {
            e.preventDefault();
            asignaturasSemestre(idSemestre.val(),idMencion.val(),txtIdAsignatura);
            gruposSemestre(idSemestre.val(),idMencion.val(),idGrupo);
            calendar.refetchEvents();
        })
        /* Funcion para actualizar lista de materias segun el semestre y la mencion */
        function asignaturasSemestre(idSemestre,idMencion,selector){
            var datos = {
                dato: 'asigSemestre',
                idSemestre: idSemestre,
                idMencion: idMencion,
                '_token': $("meta[name='csrf-token']").attr("content")
            }
            $.ajax({
                type:'POST',
                url:'/asignatura/datosAsignatura',
                data: datos,
                success: function(respuesta){
                    selector.find('option').remove();
                    selector.append('<option class="text-wrap" value="" title="Elegir asignatura...">Elegir asignatura</option>')
                    $(respuesta).each(function(indice, valor){
                        selector.append('<option class="text-wrap" value="' + valor.id + '" title="'+valor.sigla+' Grupo ' + valor.grupo+' ('+valor.actividad+ ')" data-subtext="Grupo '+valor.grupo+'" showSubtext=true>'+valor.nombreMat+' ('+valor.sigla+') - '+valor.docAbrev+' ('+valor.actividad+')</option>');
                    })
                    selector.selectpicker('refresh')
                },
                error: function(){
                    alert("Hay un error al obtener la lista de materias del semestre seleccionado...");
                }
            });
        }
        /* Funcion para actualizar lista de asignaturas */
        function gruposSemestre(idSemestre,idMencion,selector){
            var datos = {
                dato: 'gruposSemestre',
                idSemestre: idSemestre,
                idMencion: idMencion,
                '_token': $("meta[name='csrf-token']").attr("content")
            }
            $.ajax({
                type:'POST',
                url:'/asignatura/datosAsignatura',
                data: datos,
                success: function(respuesta){
                    selector.find('option').remove();
                    selector.append('<option value="" title="Todos">Todos</option>')
                    $(respuesta).each(function(indice, valor){
                        selector.append('<option class="text-wrap" value="' + valor.id + '" title="'+valor.sigla+ ' Grupo ' + valor.grupo+'" data-subtext="Grupo '+valor.grupo+'" showSubtext="true">'+valor.nombreMat+' ('+valor.sigla+')</option>');
                    })
                    selector.selectpicker('refresh');
                },
                error: function(){
                alert("Hay un error al obtener la lista de materias del semestre seleccionado...");
                }
            });
        }
        /* Funcion para convertir periodo */
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
</script> 
@stop