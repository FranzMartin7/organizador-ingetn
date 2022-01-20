<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ 'Hor_'.$aulaAbrev.'_'.$periodo.'_'.$gestion }}</title>
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
            #contenido{
                width: 100%;
                background-color: 'white' !important;
                /* page-break-after: avoid;  */
            }
            #calendarioVista, table{
                width: 1165px;
                background-color: 'white' !important;
                /* page-break-after: avoid;  */
            }
            #btnImprimir{
                display: none;
            }
        } 
        #contenido{
                width: 1165px;
                /* page-break-after: avoid;  */
            }
        th .fc-scrollgrid-sync-inner{
            background: #EEEEEE !important;
            /* border: none !important; */
            border-top: 1px solid #ddd !important;
            font-weight: bold;
        }
        th .fc-col-header-cell-cushion:first-letter {
            text-transform: uppercase;
        }
/*         .fc-timegrid-slot-label-frame{
            background: #E0E0E0 !important;
        }  */

    </style>
</head>
<body>
    <div class="container-md" id="contenido">
        <form action="">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            <input type="hidden" name="actividad" id="actividad" value="{{ $actividad }}">
            <input type="hidden" name="idAula" id="idAula" value="{{ $idAula }}">
            <input type="hidden" name="aula" id="aula" value="{{ $aula }}">
            <input type="hidden" name="idColor" id="idColor" value="{{ $idColor }}">
            <input type="hidden" name="idActividad" id="idActividad" value="{{ $idActividad }}">
            <input type="hidden" name="idPeriodo" id="idPeriodo" value="{{ $idPeriodo }}">
            <input type="hidden" name="gestion" id="gestion" value="{{ $gestion }}">
        </form>
        <div class="row mb-0">
            <div class="col-2 text-left">
                <div class="font-weight-normal lead"><span>
                    <button type="button" id="btnImprimir" class="btn btn-primary btn-sm">Imprimir <span class="fas fa-print"></span></button> 
                </span>{{ $periodo.' / '.$gestion }}</div>   
            </div>
            <div class="col-8 text-center">
                <div class="h2 font-weight-bold text-uppercase" id="tituloHorario">{{ $aula }}</div>
            </div>
            <div class="col-2 text-center">           
            </div>
        </div> 
        <div id="calendarioVista" class="pb-0"></div>
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
            var idColor = $('#idColor');
            var tituloHorario = $('#tituloHorario');
            var actividad = $('#actividad');
            var idAula = $('#idAula');
            var aula = $('#aula');
            var idActividad = $('#idActividad');
            var idPeriodo = $('#idPeriodo');
            var gestion = $('#gestion');
            var btnImprimir = $('#btnImprimir');
            if (actividad.val()=='') {
                tituloHorario.html(aula.val())
            } else {
                tituloHorario.html(aula.val()+' - '+actividad.val())
            }
            /* Estructurador de calendario */
            var calendarioVista = document.getElementById('calendarioVista');
            var calendar = new FullCalendar.Calendar(calendarioVista, {
                slotMinTime: "07:00:00",
                initialDate:moment().add(1, 'w').format('YYYY-MM-DD'),
                slotMaxTime: "22:00:00",
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
                        horaGrupo.innerHTML = "<div class='d-flex justify-content-between font-weight-bold' style='line-height: 100%;'><span>"+moment(arg.event.start).format('H:mm')+" - "+moment(arg.event.end).format('H:mm')+"</span><span>"+arg.event.extendedProps.grupo+"</span></div>";
                        docente.innerHTML = "<div class='text-center font-italic font-weight-bold' style='line-height: 110%;'>"+arg.event.extendedProps.docAbrev+"</div>";
                        actividad.innerHTML = "<div class='text-center font-weight-bold' style='line-height: 110%;'>"+arg.event.extendedProps.aulaAbrev+"</div>";
                        sigla.innerHTML = "<div class='text-center lead font-weight-bold' style='line-height: 110%;'>"+arg.event.title+"</div>"; 
                        return { domNodes: [ horaGrupo,sigla,docente,actividad ] }              
                    } else {
                        return false;
                    }

                }
            });
            calendar.render();
            $('th').addClass('text-capitalize');
    $('th').addClass('fondo-plomo');
            /* Formulario donde se puede gestionar los datos del horario */
        btnImprimir.on('click',function (e) {
            e.preventDefault();
            javascript:window.print();
        })
        calendar.addEventSource( 
            {
                url: "{{ url('/horariosAula') }}",
                method:'POST',
                extraParams: function() {
                    var datos;
                    datos = {
                        idPeriodo: idPeriodo.val(),
                        gestion: gestion.val(),
                        idAula: idAula.val(),
                        idActividad: idActividad.val(),
                        idColor: idColor.val(),
                        '_token': $("[name='_token']").val()
                    };
                    console.log(datos);
                    return datos;
                },
                textColor: 'white'
            }              
        )
    })
    </script> 
</body>
</html>