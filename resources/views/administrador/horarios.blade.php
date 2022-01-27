@extends('adminlte::page')

@section('title', 'Organizador ETN')

@section('content_header')

@stop
@section('content')
<!-- Panel de eventos del docente en modo vista -->
<div class="row mt-1">
    <div class="col-12 col-sm-8">
        <div class="lead font-weight-bold">EDITAR HORARIOS</div> 
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
                    <option value="{{ $valor->id }}" title="{{ $valor->aulaAbrev }}">{{ $valor->aula }}</option>
                @endforeach 
            </select> 
        </div>
    </div>
</div>
<div class="row mt-1 collapse" id="filtros">
    <div class="col-12 col-sm-6">
        <div class="input-group">
            <div class="input-group-prepend">
                <label for="idGrupo" class="input-group-text bg-primario font-weight-normal" id="addonidGrupo">Asignatura</label>
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
            <select name='idActividad' id='idActividad' class="selectpicker form-control show-tick" aria-label="Small" aria-describedby="addonIdActividad"  data-style="btn-verdeClaro" required>
                <option value="">Todos</option>
                @foreach($actividades as $valor)
                    <option value="{{ $valor->id }}">{{ $valor->actividad }}</option>
                @endforeach 
            </select> 
        </div>
    </div>
</div>
<div class="row mt-1">
    <div class="col-12">
        <div id="calendarioVista"></div>
    </div>
</div>
<!-- Modal para modificar, agregar o eliminar horarios-->
<div class="modal fade" id="modificarHorarios" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" id="encabezadoHorario">
                <div class="modal-title text-white">
                <div id="materia" class="lead"></div>
                <div class="font-weight-normal" id="grupo"></div>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-danger" role="alert">
                    <ul id="errorValidacion" class="list-group-item-danger mb-1 mt-0">
                    </ul>
                </div>
                <input type="hidden" id="txtIdHorario">
                <input type="hidden" id="txtGenerado">
                <input type="hidden" id="txtIdActividad">
                <div class="form-row">
                    <div class="col-12 col-sm-6">
                        <div class="form-row mb-2">
                            <label for="txtIdPeriodo" class="col-sm-4 col-form-label">Periodo:</label>
                            <div class='col-sm-8'>
                                <select name='txtIdPeriodo' id='txtIdPeriodo' class="selectpicker form-control" required>
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
                                <select name='txtGestion' id='txtGestion' class="selectpicker form-control" required>
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
                    <div class="col-12 col-sm-5">
                        <div class="form-row mb-2">
                            <label for="txtDia" class="col-sm-3 col-form-label">Dia:</label>
                            <div class="col-sm-9">
                                <select name='txtDia' id='txtDia' class="selectpicker form-control" required>
                                    <option value="1">Lunes</option>
                                    <option value="2">Martes</option>
                                    <option value="3">Miercoles</option>
                                    <option value="4">Jueves</option>
                                    <option value="5">Viernes</option>
                                    <option value="6">Sábado</option>
                                    <option value="7">Domingo</option>
                                </select>
                            </div>            
                        </div>
                    </div>
                    <div class="col-12 col-sm-7">
                        <div class="form-row mb-2">
                            <label for="txtIdAula" class="col-sm-3 col-form-label">Aula:</label>
                            <div class='col-sm-9'>
                                <select name='txtIdAula' id='txtIdAula' class="selectpicker form-control" required>
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
            </div>
            <div class="modal-footer" id="pieHorario">
                <button type='button' class="btn btn-info btn-sm" id='btnGenerar'>Generar eventos</button>
                <button type='button' class="btn btn-success btn-sm" id='btnAgregar'>Agregar</button>
                <button type="button" class="btn btn-primary btn-sm" id='btnEditar'>Guardar cambios</button>
                <button type="button" class="btn btn-danger btn-sm" id='btnEliminar'>Eliminar</button>
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancelar</button>
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
        $('.clockpicker').clockpicker();
        var idPeriodo = $('#idPeriodo');
        var gestion = $('#gestion');
        var idSemestre = $('#idSemestre');
        var idMencion = $('#idMencion');
        var idGrupo = $('#idGrupo');
        var idActividad = $('#idActividad');
        var idAula = $('#idAula');
        var filtros = $('#idGrupo,#idActividad,#idAula');
        var generadores = $('#idSemestre,#idMencion,#idPeriodo,#gestion');
        var mes = moment().format('MM')
        idPeriodo.val(convPeriodo(mes));
        gestion.val(moment().format("YYYY"));
        idPeriodo.selectpicker('refresh')
        gestion.selectpicker('refresh')
    /* Variables para el modal de edicion de horarios */
        var encabezadoHorario = $('#encabezadoHorario');
        var pieHorario = $('#pieHorario');
        var materia = $('#materia');
        var grupo = $('#grupo');
        var btnAgregar = $('#btnAgregar');
        var btnEditar = $('#btnEditar');
        var btnEliminar = $('#btnEliminar');
        var btnGenerar = $('#btnGenerar');
        var txtIdHorario = $('#txtIdHorario');
        var txtIdAsignatura = $('#txtIdAsignatura');
        var txtDia = $('#txtDia');
        var txtHoraInicio = $('#txtHoraInicio');
        var txtHoraFinal = $('#txtHoraFinal');
        var txtIdAula = $('#txtIdAula');
        var txtGenerado = $('#txtGenerado');
        var txtIdActividad = $('#txtIdActividad');
        var txtIdPeriodo = $('#txtIdPeriodo');
        var txtGestion = $('#txtGestion');
        var modificarHorarios = $('#modificarHorarios');
        gruposSemestre(idSemestre.val(),idMencion.val(),idGrupo)
        asignaturasSemestre(idSemestre.val(),idMencion.val(),txtIdAsignatura);
        /* Estructurador de calendario */
        var calendarioVista = document.getElementById('calendarioVista');
        var calendar = new FullCalendar.Calendar(calendarioVista, {
            slotMinTime: "07:00:00",
            initialView: 'timeGridWeek',
            firstDay: 1,
            slotLabelFormat: 'H:mm',
            slotLabelInterval: "00:30",
            allDaySlot: false,
            locale: 'es',
            slotEventOverlap: true,
            nowIndicator: true,
            handleWindowResize: false,
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
                },
            },  
            headerToolbar:false,
            eventContent:function(arg){
                if (arg.event.extendedProps.idHorario) {
                    let horaGrupo = document.createElement('div');
                    let sigla = document.createElement('div');
                    let docente = document.createElement('div');
                    let actividad = document.createElement('div');
                    let descripcion = document.createElement('div');
                    horaGrupo.innerHTML = "<div class='d-flex justify-content-between intlin-1'><span>"+moment(arg.event.start).format('H:mm')+" - "+moment(arg.event.end).format('H:mm')+"</span><span>"+arg.event.extendedProps.grupo+"</span></div>";
                    docente.innerHTML = "<div class='text-center font-italic intlin-2'>"+arg.event.extendedProps.docAbrev+"</div>";
                    actividad.innerHTML = "<div class='text-center intlin-2'>"+arg.event.extendedProps.aulaAbrev+"</div>";
                    sigla.innerHTML = "<div class='text-center lead intlin-2'>"+arg.event.title+"</div>"; 
                    return { domNodes: [ horaGrupo,sigla,docente,actividad ] }       
                } else {
                    return false;
                }

            },
            eventSources:[
                {
                    url: "{{ url('/horario/show') }}",
                    extraParams: function() {
                        var datos;
                        datos = {
                            idPeriodo: idPeriodo.val(),
                            gestion: gestion.val(),
                            idSemestre: idSemestre.val(),
                            idMencion: idMencion.val(),
                            idGrupo: idGrupo.val(),
                            idAula: '',
                            idActividad: idActividad.val(),
                            modoEdicion: true,
                            '_token': $("meta[name='csrf-token']").attr("content")
                        };
                        return datos;
                    },
                    textColor: 'white'
                },
                {
                    url: "{{ url('/horAula') }}",
                    method:'POST',
                    extraParams: function() {
                        var datos;
                        datos = {
                            idAula: idAula.val(),
                            idPeriodo: idPeriodo.val(),
                            gestion: gestion.val(),
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
                    nombreMateria: 'Nuevo HORARIO', 
                    grupo: '',
                    nombreDocente: '',
                    idAsignatura: '',
                    idHorario: '',
                    dia: moment(info.date).format("E"),
                    horaInicio: moment(info.date).format("HH:mm"),
                    horaFinal: moment(info.date).add(90,'m').format("HH:mm"),
                    idAula:idAula.val(),
                    generado: 0,
                    idPeriodo: idPeriodo.val(),
                    gestion: gestion.val(),
                    idActividad: '',
                    filtrado: 'true',
                    modo: 'nuevo'
                }
                formularioHorario(datos);
            },
            eventClick: function(info) {
                datos = {
                    colorMateria: info.event.backgroundColor,
                    nombreMateria: info.event.extendedProps.nombreMat, 
                    grupo: info.event.extendedProps.grupo,
                    nombreDocente: info.event.extendedProps.docAbrev,
                    idAsignatura: info.event.extendedProps.idAsignatura,
                    idHorario: info.event.extendedProps.idHorario,
                    dia: info.event.extendedProps.dia,
                    horaInicio: moment(info.event.start).format("HH:mm"),
                    horaFinal: moment(info.event.end).format("HH:mm"),
                    idAula:info.event.extendedProps.idAula,
                    generado: info.event.extendedProps.generado,
                    idPeriodo: info.event.extendedProps.idPeriodo,
                    gestion: info.event.extendedProps.gestion,
                    idActividad: info.event.extendedProps.idActividad,
                    filtrado: info.event.extendedProps.filtrado,
                    modo: 'edicion'
                }
                formularioHorario(datos);
            },
            eventDrop: function(info){
                datos = {
                    colorMateria: info.event.backgroundColor,
                    nombreMateria: info.event.extendedProps.nombreMat, 
                    grupo: info.event.extendedProps.grupo,
                    nombreDocente: info.event.extendedProps.docAbrev,
                    idAsignatura: info.event.extendedProps.idAsignatura,
                    idHorario: info.event.extendedProps.idHorario,
                    dia: moment(info.event.start).format("E"),
                    horaInicio: moment(info.event.start).format("HH:mm"),
                    horaFinal: moment(info.event.end).format("HH:mm"),
                    generado: info.event.extendedProps.generado,
                    idPeriodo: info.event.extendedProps.idPeriodo,
                    gestion: info.event.extendedProps.gestion,
                    idActividad: info.event.extendedProps.idActividad,
                    filtrado: info.event.extendedProps.filtrado,
                    modo: 'grafico'
                }
                if (idAula.val()=="") {
                    datos.idAula = info.event.extendedProps.idAula;
                }else{
                    datos.idAula = idAula.val();
                }
                formularioHorario(datos);
                datosHorario = recolectarHorario('PATCH');
                enviarHorario("/",datosHorario);              
            },
            eventResize: function(info){
                datos = {
                    colorMateria: info.event.backgroundColor,
                    nombreMateria: info.event.extendedProps.nombreMat, 
                    grupo: info.event.extendedProps.grupo,
                    nombreDocente: info.event.extendedProps.docAbrev,
                    idAsignatura: info.event.extendedProps.idAsignatura,
                    idHorario: info.event.extendedProps.idHorario,
                    dia: moment(info.event.start).format("E"),
                    horaInicio: moment(info.event.start).format("HH:mm"),
                    horaFinal: moment(info.event.end).format("HH:mm"),
                    generado: info.event.extendedProps.generado,
                    idPeriodo: info.event.extendedProps.idPeriodo,
                    gestion: info.event.extendedProps.gestion,
                    idActividad: info.event.extendedProps.idActividad,
                    filtrado: info.event.extendedProps.filtrado,
                    modo: 'grafico'
                }
                if (idAula.val()=="") {
                    datos.idAula = info.event.extendedProps.idAula;
                }else{
                    datos.idAula = idAula.val();
                }
                formularioHorario(datos);
                datosHorario = recolectarHorario('PATCH');
                enviarHorario("/",datosHorario);             
            }
        });
        calendar.render();
        /* Adecuar algunas propiedades del calendario */
        $('th').addClass('text-capitalize');
        $('th').addClass('fondo-plomo');
        $('.fc-license-message').addClass('d-none');
        /* Formulario donde se puede gestionar los datos del horario */
        function formularioHorario(datos){
            $('#errorValidacion').html('');   
            encabezadoHorario.prop("style","background-color:"+datos.colorMateria+";");
            pieHorario.prop("style","background-color:"+datos.colorMateria+";");
            materia.html(datos.nombreMateria);
            txtIdHorario.val(datos.idHorario);
            txtIdAsignatura.val(datos.idAsignatura);
            txtDia.val(datos.dia);
            txtHoraInicio.val(datos.horaInicio);
            txtHoraFinal.val(datos.horaFinal);
            txtIdAula.val(datos.idAula);
            txtGenerado.val(datos.generado);
            txtIdActividad.val(datos.idActividad);
            txtIdPeriodo.val(datos.idPeriodo);
            txtGestion.val(datos.gestion);
            txtIdPeriodo.selectpicker('refresh');
            txtGestion.selectpicker('refresh');
            txtIdAsignatura.selectpicker('refresh');
            txtDia.selectpicker('refresh');
            txtIdAula.selectpicker('refresh');        
            if(datos.generado=='1'){
                btnGenerar.hide();      
            }else{
                btnGenerar.show();
            }
            switch (datos.modo) {
                case 'edicion':
                    
                    grupo.html("Grupo " +datos.grupo + " - ");
                    grupo.append('<span class="font-italic">' + datos.nombreDocente + '</span>');
                    btnAgregar.hide();
                    btnEditar.show();
                    btnEliminar.show();
                    if (datos.filtrado) {
                        modificarHorarios.modal(); 
                    }        
                    break;
                case 'nuevo':
                    grupo.html("");
                    btnAgregar.show();
                    btnGenerar.hide(); 
                    btnEditar.hide();
                    btnEliminar.hide(); 
                    modificarHorarios.modal();   
                    break;
            } 
        };
        /* Funcion para recolectar los datos del formulario modal para añadir, editar o eliminar evento */
        function recolectarHorario(method){
            datosHorario = {
                id: txtIdHorario.val(),
                asignatura: txtIdAsignatura.val(),
                dia: txtDia.val(),
                hora_inicio: txtHoraInicio.val(),
                hora_final: txtHoraFinal.val(),
                aula: txtIdAula.val(),
                actividade_id: txtIdActividad.val(),
                generado: txtGenerado.val(),
                periodo: txtIdPeriodo.val(),
                gestion: txtGestion.val(),
                '_token': $("meta[name='csrf-token']").attr("content"),
                '_method': method
            };
            return(datosHorario)
        }; 
        /* Eventos para agregar un nuevo evento */
        btnAgregar.on('click',function(e){
            e.preventDefault();
            datosHorario = recolectarHorario('POST');
            $.confirm({
                icon: 'fas fa-plus-circle',
                title: 'Crear horario',
                content: '¿Confirma crear éste nuevo horario en la asignatura?',
                backgroundDismiss: true,
                type: 'green',
                buttons: {
                    confirmar:{
                        text:'Confirmar',
                        btnClass: 'btn-success',
                        action: function(){
                            enviarHorario("",datosHorario);
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
            datosHorario = recolectarHorario('PATCH');
            $.confirm({
                icon: 'fas fa-edit',
                title: 'Editar horario',
                content: '¿Confirma editar los datos de éste horario?',
                backgroundDismiss: true,
                type: 'blue',
                buttons: {
                    confirmar:{
                        text:'Confirmar',
                        btnClass: 'btn-info',
                        action: function(){
                        enviarHorario("/",datosHorario);
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
            datosHorario = recolectarHorario('DELETE');
            $.confirm({
                icon: 'fas fa-exclamation-triangle',
                title: '¿Eliminar horario?',
                content: 'Recuerde que una vez eliminado éste horario de la asignatura no se pueden recuperar sus datos.',
                type: 'red',
                buttons: {
                    confirmar: {
                        text:'Confirmar',
                        btnClass: 'btn-danger',
                        action: function () {
                        enviarHorario("/",datosHorario);
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
    /* Eventos para agregar un nuevo dato */
        btnGenerar.on('click',function(e){
            e.preventDefault();
            datosHorario = recolectarHorario('POST');
            datosHorario['actividade_id'] = txtIdActividad.val();
            datosHorario['generado'] = 1;
            $.confirm({
            icon: 'fas fa-plus-circle',
            title: '¿Generar eventos recurrentes?',
            content: '¿Confirma generar eventos recurrentes de este horario para la gestión especificada?',
            escapeKey: true,
            backgroundDismiss: true,
            type: 'green',
            buttons: {
                confirmar:{
                    text:'Confirmar',
                    btnClass: 'btn-info',
                    action: function(){
                        $.ajax({
                            type:'POST',
                            url:"{{ url('/genEventos') }}",
                            data: datosHorario,
                            success: function(msg){
                                if(msg){
                                    datosHorario = recolectarHorario('PATCH');
                                    datosHorario['generado'] = 1;
                                    enviarHorario("/",datosHorario);
                                }
                            },
                            error: function(){
                            $.alert('Hay un ERROR al generar los eventos');
                            }
                        });
                        
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
        function enviarHorario(accion,datos){
            $.ajax({
                type:'POST',
                url:"{{ url('/horario') }}"+accion+datos.id,
                data: datos,
                success: function(msg){
                    if(msg){
                        modificarHorarios.modal('hide');
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
        $('ul.navbar-nav').on('click',function(e){
            e.preventDefault();
            calendar.refetchEvents();
        });
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
                    $.alert("Hay un error al obtener la lista de materias del semestre seleccionado");
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
                    $.alert("Hay un error al obtener la lista de materias por grupos");
                }
            });
        }
            /* Evento al cambiar de semestre */
        generadores.on('change', function (e) {
            e.preventDefault();
            gruposSemestre(idSemestre.val(),idMencion.val(),idGrupo)
            asignaturasSemestre(idSemestre.val(),idMencion.val(),txtIdAsignatura);
            calendar.refetchEvents();
        })
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
</script> 
@stop