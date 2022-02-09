<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Horarios{{ '_'.$periodo.'_'.$gestion }}</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('fullcalendar5/lib/main.css') }}"/>
    <link rel="stylesheet" href="{{ asset('fullcalendar5/daygrid/main.css') }}"/>
    <link rel="stylesheet" href="{{ asset('fullcalendar5/timegrid/main.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}">
    <style>
        @media print {
            @page {
                size: 11in 8.5in;
                margin: 8mm 8mm 8mm 8mm;
                -webkit-print-color-adjust:exact;
                -moz-print-color-adjust:exact;
                -ms-print-color-adjust:exact;
                print-color-adjust:exact;
            }
            #contenido {
                width: 100%;
                background-color: 'white' !important;
                /* page-break-after: avoid;  */
            }
            #calendarioImp, table{
                width: 1165px !important;
                background-color: 'white' !important;
                /* page-break-after: avoid;  */
            }
            #btnImprimir{
                display: none;
            }
        }
        #contenido {
            width: 1165px !important;
        }
        table{
                width: 1165px !important;
                background-color: 'white' !important;
                /* page-break-after: avoid;  */
            }
    </style>
</head>
<body>
<div class="container-md" id="contenido">
        <form action="">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token"/>
            <input type="hidden" name="idGrupoImp" id="idGrupoImp" value="{{ $idGrupo }}">
            <input type="hidden" name="idColorImp" id="idColorImp" value="{{ $idColor }}">
            <input type="hidden" name="idPeriodoImp" id="idPeriodoImp" value="{{ $idPeriodo }}">
            <input type="hidden" name="gestionImp" id="gestionImp" value="{{ $gestion }}">
        </form>
        <div class="mb-2 text-center h3 font-weight-bold">
            HORARIO ACADÉMICO 
            <button type="button" id="btnImprimir" class="btn btn-primary btn-sm">Imprimir&nbsp;&nbsp;<span class="fas fa-print"></span></button>   
        </div>

        <div class="row mb-2">
            <div class="col-6">
                    <span class="font-weight-bold text-uppercase">ESTUDIANTE:</span>
                    &nbsp;
                    <span class="font-weight-normal">{{ $usuarios->apPaterno.' '.$usuarios->apMaterno.' '.$usuarios->name}}</span>    
            </div>
            <div class="col-6 text-right">
                <span class="font-weight-bold text-uppercase">GESTIÓN ACADÉMICA:</span>
                    &nbsp;
                <span class="font-weight-normal">{{ $periodo.' / '.$gestion }}</span>    
            </div>
        </div> 
        <div id="calendarioImp" class="pb-0"></div>
        <p class="align-top small my-0">(c) 2021 - Sistema Organizador, Ingeniería Electrónica UMSA</p>
    </div>
    <script src="{{ asset('vendor/jquery/jquery.js') }}"></script> 
    <script src="{{ asset('vendor/popper/popper.js') }}"></script> 
    <script src='https://cdn.jsdelivr.net/npm/moment@2.27.0/min/moment.min.js'></script>
    <script src="{{ asset('fullcalendar5/lib/main.js') }}"></script>
    <script src="{{ asset('fullcalendar5/daygrid/main.js') }}"></script>
    <script src="{{ asset('fullcalendar5/timegrid/main.js') }}"></script>
    <script src="{{ asset('fullcalendar5/lib/locales/es.js') }}" charset="UTF-8"></script>
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/moment@5.5.0/main.global.min.js'></script>
    <script src="{{ asset('fullcalendar5/moment/locale/es.js') }}" charset="UTF-8"></script>
    <script src="{{ asset('js/all.min.js') }}" charset="UTF-8"></script>
    <script>
        $(document).ready(function(){
            var idGrupoImp = $('#idGrupoImp');
            var idColorImp = $('#idColorImp');
            var idPeriodoImp = $('#idPeriodoImp');
            var gestionImp = $('#gestionImp');
            var btnImprimir = $('#btnImprimir');
            var calendarioImp = document.getElementById('calendarioImp');
            /* Estructurador de calendario */
            var calendar1 = new FullCalendar.Calendar(calendarioImp, {
                slotMinTime: "07:00:00",
                initialDate:moment().add(1, 'w').format('YYYY-MM-DD'),
                slotMaxTime: "21:30:00",
                initialView: 'timeGridWeek',
                firstDay: 1,
                slotLabelFormat: 'H:mm',
                slotLabelInterval: "00:30",
                allDaySlot: false,
                locale: 'es',
                slotEventOverlap: true,
                nowIndicator: false,
                handleWindowResize: true,
                /* eventOverlap: false, */
                contentHeight: 'auto',
                expandRows:true,
                hiddenDays: [ 0 ],
                views: {
                    timeGridWeek: {
                        dayHeaderContent: function(arg) {
                            return moment(arg.date).format('dddd');
                        }
                    }
                },  
                headerToolbar:false,
                eventContent:function(arg){
                    if (arg.event.extendedProps.idHorario) {
                        let horaGrupo = document.createElement('div');
                        let sigla = document.createElement('div');
                        let docente = document.createElement('div');
                        let actividad = document.createElement('div');
                        let descripcion = document.createElement('div');
                        horaGrupo.innerHTML = "<div class='d-flex justify-content-between font-weight-bold intlin-1'><span>"+moment(arg.event.start).format('H:mm')+" - "+moment(arg.event.end).format('H:mm')+"</span><span>"+arg.event.extendedProps.grupo+"</span></div>";
                        docente.innerHTML = "<div class='text-center font-weight-bold intlin-2'>"+arg.event.extendedProps.docAbrev+"</div>";
                        actividad.innerHTML = "<div class='text-center font-weight-bold intlin-2'>"+arg.event.extendedProps.aulaAbrev+"</div>";
                        sigla.innerHTML = "<div class='text-center lead font-weight-bold intlin-2'>"+arg.event.title+"</div>"; 
                        return { domNodes: [ horaGrupo,sigla,docente,actividad ] }              
                    } else {
                        return false;
                    }

                },
                eventSources:[
                    {
                        url: "{{ url('/horarios') }}",
                        method:'POST',
                        extraParams: function() {
                            var datos;
                            datos = {
                                idPeriodo:  idPeriodoImp.val(),
                                gestion: gestionImp.val(),
                                idGrupo: idGrupoImp.val(),
                                idColor: idColorImp.val(),
                                '_token': $("#token").val()
                            };
                            return datos;
                        },
                        color:'#E0E0E0'   
                    }
                ]
            });
            calendar1.render();
                /* Adecuar algunas propiedades del calendario */
            $('th').addClass('text-capitalize');
            $('th').addClass('fondo-plomo');
            $('.fc-license-message').addClass('d-none');
            /* Formulario donde se puede gestionar los datos del horario */
            btnImprimir.on('click',function (e) {
                e.preventDefault();
                javascript:window.print();
            })
            javascript:window.print();
        })
        $('title', window.parent.document).html('Horarios_'+"{{ $periodo }}"+'_'+"{{ $gestion }}")
        window.onafterprint = function () {
            $('.printpage', window.parent.document).hide();
        }
    </script> 
</body>
</html>