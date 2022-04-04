@extends('adminlte::page')

@section('title', 'Organizador ETN')

@section('content_header')
@stop
@section('right-sidebar')
    <div class="container-fluid">
        <div class="row mt-1">
            <div class="col-6 px-0">
                <a href="" class="btn btn-light rounded btn-lg btn-block">
                    <i class="fas fa-users"></i>
                    <div class="small">Sistema</div>
                    <div class="small">Red social</div>
                </a>
            </div>
            <div class="col-6 px-0">
                <a href="http://localhost/sist_comunicados/index.php" class="btn btn-light rounded btn-lg btn-block">
                    <i class="fas fa-clipboard text-danger"></i>
                    <div class="small">Sistema de</div>
                    <div class="small">Comunicados</div>
                </a>
            </div>
        </div>
        <div class="row mt-1">
            <div class="col-6 px-0">
                <a href="" class="btn btn-light rounded btn-lg btn-block">
                    <i class="fas fa-book"></i>
                    <div class="small">Sistema de</div>
                    <div class="small">Biblioteca</div>
                </a>
            </div>
            <div class="col-6 px-0">
                <a href="http://localhost/sist_comunicados/index.php" class="btn btn-light rounded btn-lg btn-block">
                    <i class="fas fa-comment-alt"></i>
                    <div class="small">Sistema de</div>
                    <div class="small">Mensajería</div>
                </a>
            </div>
        </div>
    </div>
@endsection 
@section('content')
<!-- Panel de eventos del docente en modo vista -->
<div class="row mt-1">
    <div class="col-12 col-sm-8">
        <div class="lead font-weight-bold">VER EVENTOS</div> 
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
<div class="row mt-1">
    <div class="col-12 col-sm-6">
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
    <div class="col-12 col-sm-6">
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
</div>
<div class="row mt-1 collapse" id="filtros">
    <div class="col-12 col-md-4 col-lg-5">
        <div class="input-group">
            <div class="input-group-prepend">
                <label for="idGrupo" class="input-group-text bg-primario font-weight-normal" id="addonidGrupo">Materia</label>
            </div>
            <select name='idGrupo' id='idGrupo' class="selectpicker form-control show-tick" aria-label="Small" aria-describedby="addonidGrupo" data-style="btn-verdeClaro">
            <option value="">Todos</option>
            </select> 
        </div>
    </div>
    <div class="col-12 col-md-4 col-lg-3">
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
    <div class="col-12 col-md-4 col-lg-4">
        <div class="input-group">
            <div class="input-group-prepend">
                <label for="idAula" class="input-group-text bg-primario font-weight-normal" id="addonIdAula">Aula</label>
            </div>
            <select name='idAula' id='idAula' class="selectpicker form-control show-tick" aria-label="Small" aria-describedby="addonIdAula"  data-style="btn-verdeClaro">
                <option value="">Todos</option>
                @foreach($aulas as $valor)
                    <option value="{{ $valor->id }}" title="{{ $valor->aulaAbrev }}">{{ $valor->aula }}</option>
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
            <div class="modal-header" id="encabezadoEventoVista">
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
            <div class="modal-footer" id="pieEventoVista">
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
        /* Valores iniciales de los selectores */
        var idSemestre = $('#idSemestre');
        var idMencion = $('#idMencion');
        var idPeriodo = $('#idPeriodo');
        var gestion = $('#gestion');
        var idGrupo = $('#idGrupo');
        var idActividad = $('#idActividad');
        var idAula = $('#idAula');
        var filtros = $('#idGrupo,#idActividad,#idAula');
        var generadores = $('#idSemestre,#idMencion,#idPeriodo,#gestion');
        var clockpicker = $('.clockpicker');
        var mes = moment().format('MM');
        clockpicker.clockpicker();
        idPeriodo.val(convPeriodo(mes));
        gestion.val(moment().format("YYYY"));
        gruposSemestre(idSemestre.val(),idMencion.val(),idGrupo);
        idPeriodo.selectpicker('refresh')
        gestion.selectpicker('refresh')
        idGrupo.selectpicker('refresh')
        /* Valores Iniciales del modal de vista de eventos */
        var encabezadoEventoVista = $('#encabezadoEventoVista');
        var pieEventoVista = $('#pieEventoVista');
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
        /* Valores iniciales para el calendario */
        var calendarioVista = document.getElementById('calendarioVista');
        /* Estructurador de calendario */
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
                            idAula: idAula.val(),
                            idGrupo: idGrupo.val(),
                            modoEdicion: false,
                            '_token': $("meta[name='csrf-token']").attr("content")
                        };
                        return datos;
                    },
                    textColor: 'white'
                }            
            ],
            eventClick: function(info) {
                if (info.event.extendedProps.filtrado=='true') {    
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
        /* Formulario de vista de eventos */
        function vistaEvento(datos){
            encabezadoEventoVista.prop("style","background-color:"+datos.colorMateria+";");
            pieEventoVista.prop("style","background-color:"+datos.colorMateria+";");
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
        /* Evento para generar eventos */
        generadores.on('change', function (e) {
            e.preventDefault();
            gruposSemestre(idSemestre.val(),idMencion.val(),idGrupo);
            calendar.refetchEvents();
        })
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