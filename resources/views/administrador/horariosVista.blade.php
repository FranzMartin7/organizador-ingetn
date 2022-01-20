@extends('adminlte::page')

@section('title', 'Organizador ETN')

@section('content_header')

@stop
@section('content')
<div class="row my-1">
    <div class="col-12 col-sm-3">
        <div class="lead font-weight-bold">VER HORARIOS</div> 
    </div>
    <div class="col-12 col-sm-6">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text bg-primario font-weight-normal">Gestión</span>
            </div>
            <select name='idPeriodo' id='idPeriodo' class="form-control selectpicker" required>
                @foreach($periodos as $valor)
                    <option value="{{ $valor->id }}" title="{{ $valor->periodoAbrev }}" data-periodoabrev="{{ $valor->periodoAbrev }}">{{ $valor->periodo }}</option>
                @endforeach 
            </select> 
            <select name='gestion' id='gestion' class="form-control selectpicker" required>
                @foreach($gestiones as $valor)
                    <option value="{{ $valor }}">{{ $valor }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-12 col-sm-3">
        <div class="btn-group d-flex justify-content-center" role="group">
            <button type="button" id="btnAnterior" class="btn btn-primario"><i class="fas fa-step-backward"></i></button>
            <button type="button" id="btnSiguiente" class="btn btn-primario"><i class="fas fa-step-forward"></i></button>
            <button type="button" id="btnPlay" class="btn btn-primario"><i class="fas fa-play"></i></button>
            <button type="button" id="btnPause" class="btn btn-primario"><i class="fas fa-pause"></i></button>
        </div>
    </div>
</div>
<!-- Calendario de horarios -->
<div id="panelHorarios" class="card">
    <input type="hidden" name="idSemestre" id="idSemestre" value="1">
    <input type="hidden" name="idMencion" id="idMencion" value="1">
    <div id="carouselHorarios" class="carousel slide carousel-fade" data-ride="carousel">
        <div class="carousel-inner" >
            <div class="carousel-item active">
                <div class="card-header bg-primary">
                    <div class="row">
                        <div class="col-12 col-md-3 lead text-left expandir"></div>
                        <div class="col-12 col-md-6 h3 text-center font-weight-bold my-0 py-0">PRIMER SEMESTRE</div>
                        <div class="col-12 col-md-3 h5 text-center"></div>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="card-header bg-primary">
                    <div class="row">
                        <div class="col-12 col-md-3 lead text-left expandir"></div>
                        <div class="col-12 col-md-6 h3 text-center font-weight-bold my-0 py-0">SEGUNDO SEMESTRE</div>
                        <div class="col-12 col-md-3 h5 text-center"></div>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="card-header bg-primary">
                    <div class="row">
                        <div class="col-12 col-md-3 lead text-left expandir"></div>
                        <div class="col-12 col-md-6 h3 text-center font-weight-bold my-0 py-0">TERCER SEMESTRE</div>
                        <div class="col-12 col-md-3 h5 text-center"></div>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="card-header bg-primary">
                    <div class="row">
                        <div class="col-12 col-md-3 lead text-left expandir"></div>
                        <div class="col-12 col-md-6 h3 text-center font-weight-bold my-0 py-0">CUARTO SEMESTRE</div>
                        <div class="col-12 col-md-3 h5 text-center"></div>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="card-header bg-primary">
                    <div class="row">
                        <div class="col-12 col-md-3 lead text-left expandir"></div>
                        <div class="col-12 col-md-6 h3 text-center font-weight-bold my-0 py-0">QUINTO SEMESTRE</div>
                        <div class="col-12 col-md-3 h5 text-center"></div>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="card-header bg-primary">
                    <div class="row">
                        <div class="col-12 col-md-3 lead text-left expandir"></div>
                        <div class="col-12 col-md-6 h3 text-center font-weight-bold my-0 py-0">SEXTO SEMESTRE</div>
                        <div class="col-12 col-md-3 h5 text-center"></div>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="card-header bg-primary">
                    <div class="row">
                        <div class="col-12 col-md-3 lead text-left expandir"></div>
                        <div class="col-12 col-md-6 h3 text-center font-weight-bold my-0 py-0">SÉPTIMO SEMESTRE</div>
                        <div class="col-12 col-md-3 text-center"><span class="card bg-danger lead p-0 m-0">Control</span></div>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="card-header bg-primary">
                    <div class="row">
                        <div class="col-12 col-md-3 lead text-left expandir"></div>
                        <div class="col-12 col-md-6 h3 text-center font-weight-bold my-0 py-0">SÉPTIMO SEMESTRE</div>
                        <div class="col-12 col-md-3 text-center"><span class="card bg-naranja lead p-0 m-0">Sistemas de computación</span></div>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="card-header bg-primary">
                    <div class="row">
                        <div class="col-12 col-md-3 lead text-left expandir"></div>
                        <div class="col-12 col-md-6 h3 text-center font-weight-bold my-0 py-0">SÉPTIMO SEMESTRE</div>
                        <div class="col-12 col-md-3 text-center"><span class="card bg-success lead p-0 m-0">Telecomunicaciones</span></div>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="card-header bg-primary">
                    <div class="row">
                        <div class="col-12 col-md-3 lead text-left expandir"></div>
                        <div class="col-12 col-md-6 h3 text-center font-weight-bold my-0 py-0">OCTAVO SEMESTRE</div>
                        <div class="col-12 col-md-3 text-center"><span class="card bg-danger lead p-0 m-0">Control</span></div>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="card-header bg-primary">
                    <div class="row">
                        <div class="col-12 col-md-3 lead text-left expandir"></div>
                        <div class="col-12 col-md-6 h3 text-center font-weight-bold my-0 py-0">OCTAVO SEMESTRE</div>
                        <div class="col-12 col-md-3 text-center"><span class="card bg-naranja lead p-0 m-0">Sistemas de computación</span></div>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="card-header bg-primary">
                    <div class="row">
                        <div class="col-12 col-md-3 lead text-left expandir"></div>
                        <div class="col-12 col-md-6 h3 text-center font-weight-bold my-0 py-0">OCTAVO SEMESTRE</div>
                        <div class="col-12 col-md-3 text-center"><span class="card bg-success lead p-0 m-0">Telecomunicaciones</span></div>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="card-header bg-primary">
                    <div class="row">
                        <div class="col-12 col-md-3 lead text-left expandir"></div>
                        <div class="col-12 col-md-6 h3 text-center font-weight-bold my-0 py-0">NOVENO SEMESTRE</div>
                        <div class="col-12 col-md-3 text-center"><span class="card bg-danger lead p-0 m-0">Control</span></div>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="card-header bg-primary">
                    <div class="row">
                        <div class="col-12 col-md-3 lead text-left expandir"></div>
                        <div class="col-12 col-md-6 h3 text-center font-weight-bold my-0 py-0">NOVENO SEMESTRE</div>
                        <div class="col-12 col-md-3 text-center"><span class="card bg-naranja lead p-0 m-0">Sistemas de computación</span></div>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="card-header bg-primary">
                    <div class="row">
                        <div class="col-12 col-md-3 lead text-left expandir"></div>
                        <div class="col-12 col-md-6 h3 text-center font-weight-bold my-0 py-0">NOVENO SEMESTRE</div>
                        <div class="col-12 col-md-3 text-center"><span class="card bg-success lead p-0 m-0">Telecomunicaciones</span></div>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="card-header bg-primary">
                    <div class="row">
                        <div class="col-12 col-md-3 lead text-left expandir"></div>
                        <div class="col-12 col-md-6 h3 text-center font-weight-bold my-0 py-0">DÉCIMO SEMESTRE</div>
                        <div class="col-12 col-md-3 text-center"><span class="card bg-danger lead p-0 m-0">Control</span></div>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="card-header bg-primary">
                    <div class="row">
                        <div class="col-12 col-md-3 lead text-left expandir"></div>
                        <div class="col-12 col-md-6 h3 text-center font-weight-bold my-0 py-0">DÉCIMO SEMESTRE</div>
                        <div class="col-12 col-md-3 text-center"><span class="card bg-naranja lead p-0 m-0">Sistemas de computación</span></div>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="card-header bg-primary">
                    <div class="row">
                        <div class="col-12 col-md-3 lead text-left expandir"></div>
                        <div class="col-12 col-md-6 h3 text-center font-weight-bold my-0 py-0">DÉCIMO SEMESTRE</div>
                        <div class="col-12 col-md-3 text-center"><span class="card bg-success lead p-0 m-0">Telecomunicaciones</span></div>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="card-header bg-secundario">
                    <div class="row">
                        <div class="col-12 col-md-3 lead text-left expandir"></div>
                        <div class="col-12 col-md-6 h3 text-center font-weight-bold my-0 py-0">AULA 304</div>
                        <div class="col-12 col-md-3 text-center"></div>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="card-header bg-secundario">
                    <div class="row">
                        <div class="col-12 col-md-3 lead text-left expandir"></div>
                        <div class="col-12 col-md-6 h3 text-center font-weight-bold my-0 py-0">AULA 305</div>
                        <div class="col-12 col-md-3 text-center"></div>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="card-header bg-secundario">
                    <div class="row">
                        <div class="col-12 col-md-3 lead text-left expandir"></div>
                        <div class="col-12 col-md-6 h3 text-center font-weight-bold my-0 py-0">AULA 306</div>
                        <div class="col-12 col-md-3 text-center"></div>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="card-header bg-secundario">
                    <div class="row">
                        <div class="col-12 col-md-3 lead text-left expandir"></div>
                        <div class="col-12 col-md-6 h3 text-center font-weight-bold my-0 py-0">AULA 307</div>
                        <div class="col-12 col-md-3 text-center"></div>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="card-header bg-secundario">
                    <div class="row">
                        <div class="col-12 col-md-3 lead text-left expandir"></div>
                        <div class="col-12 col-md-6 h3 text-center font-weight-bold my-0 py-0">AULA 308</div>
                        <div class="col-12 col-md-3 text-center"></div>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="card-header bg-secundario">
                    <div class="row">
                        <div class="col-12 col-md-3 lead text-left expandir"></div>
                        <div class="col-12 col-md-6 h3 text-center font-weight-bold my-0 py-0">AULA DOCENTE</div>
                        <div class="col-12 col-md-3 text-center"></div>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="card-header bg-secundario">
                    <div class="row">
                        <div class="col-12 col-md-3 lead text-left expandir"></div>
                        <div class="col-12 col-md-6 h3 text-center font-weight-bold my-0 py-0">AULA MAESTRÍA</div>
                        <div class="col-12 col-md-3 text-center"></div>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="card-header bg-secundario">
                    <div class="row">
                        <div class="col-12 col-md-3 lead text-left expandir"></div>
                        <div class="col-12 col-md-6 h3 text-center font-weight-bold my-0 py-0">LABORATORIO ELECTRÓNICA</div>
                        <div class="col-12 col-md-3 text-center"></div>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="card-header bg-secundario">
                    <div class="row">
                        <div class="col-12 col-md-3 lead text-left expandir"></div>
                        <div class="col-12 col-md-6 h3 text-center font-weight-bold my-0 py-0">LABORATORIO CONTROL</div>
                        <div class="col-12 col-md-3 text-center"></div>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="card-header bg-secundario">
                    <div class="row">
                        <div class="col-12 col-md-3 lead text-left expandir"></div>
                        <div class="col-12 col-md-6 h3 text-center font-weight-bold my-0 py-0">LABORATORIO TELECOMUNICACIONES</div>
                        <div class="col-12 col-md-3 text-center"></div>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="card-header bg-secundario">
                    <div class="row">
                        <div class="col-12 col-md-3 lead text-left expandir"></div>
                        <div class="col-12 col-md-6 h3 text-center font-weight-bold my-0 py-0">LABORATORIO SISTEMAS</div>
                        <div class="col-12 col-md-3 text-center"></div>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="card-header bg-secundario">
                    <div class="row">
                        <div class="col-12 col-md-3 lead text-left expandir"></div>
                        <div class="col-12 col-md-6 h3 text-center font-weight-bold my-0 py-0">SALA DE COMPUTACIÓN</div>
                        <div class="col-12 col-md-3 text-center"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="calendarioVista" ></div>
</div>
<!-- Modal para detalles de los horarios-->
<div class="modal fade" id="verHorario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" id="encabezadoHorarioVista">
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
        var btnAnterior = $('#btnAnterior');
        var btnSiguiente = $('#btnSiguiente');
        var btnPause = $('#btnPause');
        var btnPlay = $('#btnPlay');
        var carouselHorarios = $('#carouselHorarios');
        var panelHorarios = $('#panelHorarios');
        var btnExpandir = $('.expandir')
        var idPeriodo = $('#idPeriodo');
        var gestion = $('#gestion');
        var idSemestre = $('#idSemestre');
        var idMencion = $('#idMencion');
        var generadores = $('#idPeriodo,#gestion');
        var mes = moment().format('MM');
        idPeriodo.val(convPeriodo(mes));
        gestion.val(moment().format("YYYY"));
        gestion.selectpicker('refresh');
        idPeriodo.selectpicker('refresh');
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
        /* Estructurar el calendario  */
        var calendarioVista = document.getElementById('calendarioVista');
        var calendar = new FullCalendar.Calendar(calendarioVista, {
            slotMinTime: "07:30:00",
/*             slotMaxTime: "20:30:00", */
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
            /* height:'auto', */
            stickyHeaderDates:true,
            stickyFooterScrollbar: true,
            dayMinWidth:120,
            contentHeight:'auto',
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
                sigla.innerHTML = "<div class='text-center lead intlin-2'>"+arg.event.title+"</div>"; 
                return { domNodes: [ horaGrupo,sigla,docente,actividad ] }
            },
            eventSources:[
                {
                    url: "{{ url('/horariosSemestre') }}",
                    method:"POST",
                    extraParams: function() {
                        var datos;
                        datos = {
                            idPeriodo: idPeriodo.val(),
                            gestion: gestion.val(),
                            idSemestre: 1,
                            idMencion: 1,
                            idActividad: '',
                            idColor: 1,
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
                    dia: moment(info.event.extendedProps.dia).format("dddd"),
                    horaInicio: moment(info.event.start).format("H:mm"),
                    horaFinal: moment(info.event.end).format("H:mm"),
                    actividad: info.event.extendedProps.actividad,
                    aula:info.event.extendedProps.aula,
                    periodo:info.event.extendedProps.periodoAbrev,
                    gestion:info.event.extendedProps.gestion

                }
                carouselHorarios.carousel(
                    'pause'
                );
                vistaHorarios(datos); 
            }
        });
        calendar.render();
        /* Adecuar algunas propiedades del calendario */
        $('th').addClass('text-capitalize');
        $('th').addClass('fondo-plomo');
        $('.fc-license-message').addClass('d-none');
        var periodoabrev = $('option:selected', idPeriodo).data("periodoabrev");
        btnExpandir.html(periodoabrev+'/'+gestion.val());
        /* Evento para generar los eventos */
        generadores.on('change',function(e){
            e.preventDefault();
            calendar.refetchEvents();
            var periodoabrev = $('option:selected',idPeriodo).data("periodoabrev");
            btnExpandir.html(periodoabrev+'/'+gestion.val());
        });
        /* Evento para expandir a pantalla completa la presentación de horarios */
        btnExpandir.on('click',function(e){
            e.preventDefault();
            calendar.refetchEvents();
            calendar.updateSize()
            panelHorarios.toggleClass('pantallaCompleta');
        });
        /* Evento para retroceder la diapositiva */
        btnAnterior.on('click',function(e){
            e.preventDefault();
            carouselHorarios.carousel(
                'prev'
            );
        });
        /* Evento para avanzar la diapositiva */
        btnSiguiente.on('click',function(e){
            e.preventDefault();
            carouselHorarios.carousel(
                'next'
            );
        });
        /* Evento para pausar la diapositiva */
        btnPause.on('click',function(e){
            e.preventDefault();
            carouselHorarios.carousel(
                'pause'
            );
        });
        /* Evento para reproducir la diapositiva */
        btnPlay.on('click',function(e){
            e.preventDefault();
            carouselHorarios.carousel(
                'cycle'
            );
        });
        btnCerrar.on('click',function(){
            carouselHorarios.carousel(
                'cycle'
            );
        });
        /* Establecimiento de propiedades del carusell */
        carouselHorarios.carousel(
            {
                interval: 15000,
                keyboard: true,
                touch: true
            }
        );
        /* Evento para cambiar los horarios de calendario */
        carouselHorarios.on('slide.bs.carousel', function(event){
            $('th').addClass('text-capitalize');
            $('th').addClass('fondo-plomo');
            calendar.removeAllEvents();
            switch (event.to) {
                case 0:
                    verHorariosSem(idPeriodo.val(),gestion.val(),1,1)
                    break;
                case 1:
                    verHorariosSem(idPeriodo.val(),gestion.val(),2,1)
                    break;
                case 2:
                    verHorariosSem(idPeriodo.val(),gestion.val(),3,1)
                    break;
                case 3:
                    verHorariosSem(idPeriodo.val(),gestion.val(),4,1)
                    break;
                case 4:
                    verHorariosSem(idPeriodo.val(),gestion.val(),5,1)
                    break;
                case 5:
                    verHorariosSem(idPeriodo.val(),gestion.val(),6,1)
                    break;
                case 6:
                    verHorariosSem(idPeriodo.val(),gestion.val(),7,1)
                    break;
                case 7:
                    verHorariosSem(idPeriodo.val(),gestion.val(),7,2)
                    break;
                case 8:
                    verHorariosSem(idPeriodo.val(),gestion.val(),7,3)
                    break;        
                case 9:
                    verHorariosSem(idPeriodo.val(),gestion.val(),8,1)
                    break;
                case 10:
                    verHorariosSem(idPeriodo.val(),gestion.val(),8,2)
                    break;
                case 11:
                    verHorariosSem(idPeriodo.val(),gestion.val(),8,3)
                    break;
                case 12:
                    verHorariosSem(idPeriodo.val(),gestion.val(),9,1)
                    break;
                case 13:
                    verHorariosSem(idPeriodo.val(),gestion.val(),9,2)
                    break;
                case 14:
                    verHorariosSem(idPeriodo.val(),gestion.val(),9,3)
                    break;
                case 15:
                    verHorariosSem(idPeriodo.val(),gestion.val(),10,1)
                    break;
                case 16:
                    verHorariosSem(idPeriodo.val(),gestion.val(),10,2)
                    break;
                case 17:
                    verHorariosSem(idPeriodo.val(),gestion.val(),10,3)
                    break;
                case 18:
                    verHorariosAula(idPeriodo.val(),gestion.val(),2)
                    break;
                case 19:
                    verHorariosAula(idPeriodo.val(),gestion.val(),3)
                    break;
                case 20:
                    verHorariosAula(idPeriodo.val(),gestion.val(),4)
                    break;
                case 21:
                    verHorariosAula(idPeriodo.val(),gestion.val(),5)
                    break;
                case 22:
                    verHorariosAula(idPeriodo.val(),gestion.val(),6)
                    break;
                case 23:
                    verHorariosAula(idPeriodo.val(),gestion.val(),7)
                    break;
                case 24:
                    verHorariosAula(idPeriodo.val(),gestion.val(),8)
                    break;
                case 25:
                    verHorariosAula(idPeriodo.val(),gestion.val(),9)
                    break;
                case 26:
                    verHorariosAula(idPeriodo.val(),gestion.val(),10)
                    break;
                case 27:
                    verHorariosAula(idPeriodo.val(),gestion.val(),11)
                    break;
                case 28:
                    verHorariosAula(idPeriodo.val(),gestion.val(),12)
                    break;
                case 29:
                    verHorariosAula(idPeriodo.val(),gestion.val(),13)
                    break;
                default:
                    break;
            }
        });
        function verHorariosSem(idPeriodo,gestion,idSemestre,idMencion){
            calendar.addEventSource( 
                {
                    url: "{{ url('/horariosSemestre') }}",
                    method:'POST',
                    extraParams: function() {
                        var datos;
                        datos = {
                            idPeriodo: idPeriodo,
                            gestion: gestion,
                            idSemestre: idSemestre,
                            idMencion: idMencion,
                            idActividad: '',
                            idColor: 1,
                            '_token': $("[name='_token']").val()
                        };
                        return datos;
                    }
                }              
            )
        }
        function verHorariosAula(idPeriodo,gestion,idAula){
            calendar.addEventSource( 
                {
                    url: "{{ url('/horariosAula') }}",
                    method:'POST',
                    extraParams: function() {
                        var datos;
                        datos = {
                            idPeriodo: idPeriodo,
                            gestion: gestion,
                            idAula: idAula,
                            idActividad: '',
                            idColor: 1,
                            '_token': $("[name='_token']").val()
                        };
                        return datos;
                    }
                }              
            )
        }
        /* Formulario de vista de eventos */
        function vistaHorarios(datos){
            encabezadoHorarioVista.prop("style","background-color:"+datos.colorMateria+";");
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