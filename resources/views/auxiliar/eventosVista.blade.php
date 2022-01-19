@extends('adminlte::page')

@section('title', 'Organizador ETN')

@section('content_header')
@stop
@section('content')
<!-- Panel de eventos del docente en modo vista -->
<div class="row">
    <div class="col-12 col-sm-8 mt-1">
        <div class="lead font-weight-bold">MIS EVENTOS</div>
    </div>
    <div class="col-12 col-sm-4 mt-1">
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
<div class="row mt-1">
    <div class="col-12 col-sm-4">
        <div class="input-group mb-1">
        <div class="input-group-prepend">
            <label for="idAsignatura" class="input-group-text bg-primario font-weight-normal" id="addonMateria">Docencias</label>
        </div>
        <select name='idAsignatura' id='idAsignatura' class="selectpicker form-control show-tick" aria-label="Small" aria-describedby="addonIdAsignatura" data-style="btn-verdeClaro">
            <option value="">Todos</option>
            @foreach($asignaturas as $valor)
                <option value="{{ $valor->id }}" title="{{$valor->grupos->materias->sigla.' '.'Grupo '.$valor->grupos->grupo.' ('.$valor->actividades->actividad.')' }}" data-subtext="{{ 'Grupo '.$valor->grupos->grupo}}" showSubtext="true">{{ $valor->grupos->materias->nombreMat.' ('.$valor->grupos->materias->sigla.')'.' - '.$valor->actividades->actividad }}</option>
            @endforeach 
            </select> 
        </div>
    </div>
    <div class="col-12 col-sm-4">
        <div class="input-group mb-1">
            <div class="input-group-prepend">
                <label for="idGrupo" class="input-group-text bg-primario font-weight-normal">Materias</label>
            </div>
            <select name='idGrupo' id='idGrupo' class="selectpicker form-control show-tick" aria-label="Small" aria-describedby="addonidGrupo"  data-style="btn-verdeClaro">
                <option title="todos" value="">Todos</option>
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
</div>
<div class="row">
    <div class="col-12">
        <div id="calendarioVista"></div>
    </div>
</div> 
<!-- Modal para detalles de los eventos-->
<div class="modal fade" id="verEvento" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" id="encabezadoEvento">
                <div class="modal-title text-white">
                <div id="mostrarMateria" class="lead"></div>
                <div class="font-weight-normal" id="mostrarGrupo"></div>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-between">
                    <div class="text-capitalize" id="mostrarFecha"></div>
                    <div id="mostrarAula"></div>
                </div>
                <div class="d-flex justify-content-center font-weight-bold lead text-uppercase" id="mostrarActividad"></div>
                <div class="d-flex justify-content-center font-weight-normal lead" id="mostrarHoras"></div>
                <div class="card rounded bg-light">
                    <div class="card-body">
                        <div class="card-text text-justify" id="mostrarDescripcion"></div>
                        <a href="#" class="text-center text-primary" id="mostrarEnlace"></a>
                    </div>

                </div>
                <div class="d-flex justify-content-end font-weight-bold text-small" id="mostrarGestion"></div>
            </div>
            <div class="modal-footer" id="pieEvento">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
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
        var clockpicker = $('.clockpicker');
        var idGrupo = $('#idGrupo');
        var idAsignatura = $('#idAsignatura');
        var idActividad = $('#idActividad');
        var idPeriodo = $('#idPeriodo');
        var gestion = $('#gestion');
        var filtros = $('#idAsignatura,#idActividad,#idGrupo');
        var gestiones = $('#idPeriodo,#gestion');
        clockpicker.clockpicker();
        idPeriodo.val(convPeriodo(moment().format("MM"))),
        gestion.val(moment().format("YYYY"))
        idPeriodo.selectpicker('refresh');
        gestion.selectpicker('refresh');
        /* Variables para el modal de vista de eventos */
        var encabezadoEvento = $('#encabezadoEvento');
        var pieEvento = $('#pieEvento');
        var mostrarMateria = $('#mostrarMateria');
        var mostrarGrupo = $('#mostrarGrupo');
        var mostrarFecha = $('#mostrarFecha');
        var mostrarAula = $('#mostrarAula');
        var mostrarActividad = $('#mostrarActividad');
        var mostrarHoras = $('#mostrarHoras');
        var mostrarDescripcion = $('#mostrarDescripcion');
        var mostrarEnlace = $('#mostrarEnlace');
        var mostrarGestion = $('#mostrarGestion');
        var verEvento = $('#verEvento');
        registrosGestion(idGrupo,idPeriodo.val(),gestion.val())
        var calendarioVista = document.getElementById('calendarioVista');
        /* Estructurador de calendario */
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
            height:'auto',
            stickyHeaderDates:true,
            /* contentHeight: 700, */
            stickyFooterScrollbar: true,
            dayMinWidth:120,
            themeSystem: 'standard',
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
                            modoEdicion: false
                        };
                        return datos;
                    },
                    textColor: 'white'
                },
                {
                    url: "{{ url('/evEstudiante') }}",
                    method:'POST',
                    extraParams: function() {
                        var datos;
                        datos = {
                            idPeriodo: idPeriodo.val(),
                            gestion: gestion.val(),
                            idGrupo: idGrupo.val(),
                            idAsignatura: '',
                            idActividad: idActividad.val(),
                            idAula: '',
                            modoEdicion: false,
                            '_token': $("meta[name='csrf-token']").attr("content")
                        };
                        return datos;
                    },
                    textColor: 'white'
                }            
            ],
            eventClick: function(info) {
                datos = {
                    colorMateria: info.event.backgroundColor,
                    nombreMateria: info.event.extendedProps.nombreMat, 
                    grupo: info.event.extendedProps.grupo,
                    nombreDocente: info.event.extendedProps.docAbrev,
                    idAsignatura: info.event.extendedProps.idAsignatura,
                    fecha: moment(info.event.start).format("dddd D/MMM/YYYY"),
                    horaInicio: moment(info.event.start).format("H:mm"),
                    horaFinal: moment(info.event.end).format("H:mm"),
                    actividad: info.event.extendedProps.actividad,
                    aula:info.event.extendedProps.aula,
                    descripcion:info.event.extendedProps.descripcion,
                    enlace: info.event.extendedProps.enlace,
                    periodo:info.event.extendedProps.periodoAbrev,
                    gestion:info.event.extendedProps.gestion
                }
                if (info.event.extendedProps.filtrado=='true') {
                    vistaEvento(datos);
                }
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
        /* Funcion para ver detalles del evento en el modal */
        function vistaEvento(datos){
            encabezadoEvento.prop("style","background-color:"+datos.colorMateria+";");
            pieEvento.prop("style","background-color:"+datos.colorMateria+";");
            mostrarMateria.html(datos.nombreMateria);
            mostrarGrupo.html("Grupo "+datos.grupo + " - ");
            mostrarGrupo.append('<span class="font-italic">' + datos.nombreDocente + '</span>')
            mostrarFecha.html(datos.fecha);
            mostrarAula.html(datos.aula);
            mostrarActividad.html(datos.actividad);
            mostrarGestion.html(datos.periodo+'/'+datos.gestion);
            mostrarHoras.html(datos.horaInicio + " - " + datos.horaFinal);
            mostrarDescripcion.html(datos.descripcion);
            mostrarEnlace.html(datos.enlace);
            mostrarEnlace.prop("href",datos.enlace);
            mostrarEnlace.prop("target","_blank");
            verEvento.modal();
        }
        /* Filtros de vista del calendario */
        filtros.on('change',function(e){
            e.preventDefault();
            calendar.refetchEvents();
        });
        gestiones.on('change',function(e){
            e.preventDefault();       
            registrosGestion(idGrupo,idPeriodo.val(),gestion.val())
            calendar.refetchEvents();
        });
        /* Funcion para actualizar la lista de materias registradas */
        function registrosGestion(selector,idPeriodo,gestion){
            var datos = {
                dato: 'materiasInscritas',
                idPeriodo: idPeriodo,
                gestion: gestion,
                '_token': $("meta[name='csrf-token']").attr("content")
            }
            $.ajax({
                type:'POST',
                url:'/registro/datosRegistro',
                data: datos,
                success: function(respuesta){
                    selector.find('option').remove();
                    selector.append('<option value="" title="Todos">Todos</option>')
                    $(respuesta).each(function(indice, valor){
                        selector.append('<option value="' + valor.id + '" title="'+valor.sigla+ ' Grupo ' + valor.grupo+'" data-subtext="Grupo '+valor.grupo+'" showSubtext="true">'+valor.nombreMat+' ('+valor.sigla+')</option>');
                    })
                    selector.selectpicker('refresh')
                },
                error: function(){
                alert("Hay un error al obtener la lista de materias del semestre seleccionado...");
                }
            });
        }
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
        /* notificacionesDia(); */
/*         window.onload = function () {
            if (localStorage.getItem("hasCodeRunBefore") === null) {
                notificacionesDia()
                localStorage.setItem("hasCodeRunBefore", true);
            }
        } */
        function notificacionesDia(){
            var datos = {
                fecha: moment().format('YYYY-MM-DD'),
                hora: moment().format('HH:mm:ss'),
                '_token': $("meta[name='csrf-token']").attr("content")
            }
            $.ajax({
                type:'post',
                url:'/evDia',
                data: datos,
                success: function(respuesta){
                    $(respuesta).each(function(indice, valor){
                        Push.create(valor.nombreMat+' '+valor.title+' - Grupo '+valor.grupo, {
                            body: valor.actividad+' ('+moment(valor.horaInicio,'HH:mm:ss').format('H:mm')+'-'+moment(valor.horaFinal,'HH:mm:ss').format('H:mm')+')',
                            icon: '{{ asset("logos/agenda-recordatorio.png") }}',
                            requireInteraction: true,
                            /* tag:valor.idEvento, */
                            vibrate: [200, 100],
                            /* timeout: 8000, */
                            onClick: function () {
                                window.focus();
                                this.close();
                            }
                        });
                    })
                }
            });
            $.ajax({
            type:'post',
            url:'/evAlarmaEst',
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
        $.ajax({
            type:'post',
            url:'/evAlarmaEst',
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