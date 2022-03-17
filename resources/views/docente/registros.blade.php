@extends('adminlte::page')

@section('title', 'Organizador ETN')

@section('plugins.bootstrap-table',true)

@section('content_header')

@stop
@section('content')
<!-- Panel de tabla de registros -->
<div class="row">
    <div class="col-12 col-sm-5 mt-1">
        <div class="lead font-weight-bold">REGISTROS ESTUDIANTES</div> 
    </div>
    <div class="col-12 col-sm-4 mt-1">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text bg-primario font-weight-normal" id="addonIdGrupo">Docencia</span>
            </div>
            <select name='idGrupo' id='idGrupo' class="selectpicker form-control show-tick" data-live-search="true" required>
                
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
        </div> 
    </div>
    <div class="col-12 col-sm-3 mt-1">

        <input type="hidden" name="idUsuario" id="idUsuario" value="{{ $idUsuario }}">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text bg-primario font-weight-normal" id="addonGestion">Gestión</span>
            </div>
            <select name='idPeriodo' id='idPeriodo' class="selectpicker form-control show-tick" aria-describedby="addonGestion" required>
                @foreach($periodos as $valor)
                    <option value="{{ $valor->id }}" title="{{ $valor->periodoAbrev }}">{{ $valor->periodo }}</option>
                @endforeach 
            </select> 
            <select name='gestion' id='gestion' class="selectpicker form-control show-tick" aria-describedby="addonGestion" required>
                @foreach($gestiones as $valor)
                    <option value="{{ $valor }}">{{ $valor }}</option>
                @endforeach
            </select>
        </div>
    </div>       
</div>
<div class="table-responsive">
    <table id="tablaRegistros"></table>
</div>
<!-- Modal para detalles de los registros -->
<div class="modal fade" id="modificarRegistros" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <div class="modal-title text-white">
                    <div class="lead" id="tituloForm"></div>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="#">
                <div class="modal-body">
                    <div class="text-danger" role="alert">
                        <ul id="errorValidacion" class="list-group-item-danger mb-1 mt-0">
                        </ul>
                    </div>
                    <input type="hidden" id="txtIdRegistro" name="txtIdRegistro">
                    <div class="form-row mb-2">
                        <label for="txtIdUsuario" class="col-sm-2 col-form-label">Estudiante:</label>
                        <div class='col-sm-10'>
                        <select name='txtIdUsuario' id='txtIdUsuario' class="selectpicker form-control show-tick" data-live-search="true" required>
                            <option value="">Elegir estudiante</option>
                            @foreach($estudiantes as $valor)                       
                                <option value="{{ $valor->id }}" title="{{ $valor->apPaterno.' '.$valor->name }}">{{ $valor->apPaterno.' '.$valor->apMaterno.' '.$valor->name }}</option>
                            @endforeach
                        </select> 
                        </div>
                    </div>
                    <div class="form-row">
                        <label for="txtIdGrupo" class="col-sm-3 col-form-label">Materia:</label>
                        <div class='col-sm-9'>
                            <select name='txtIdGrupo' id='txtIdGrupo' class="selectpicker form-control show-tick" data-live-search="true" required>
                                <option value="">Elegir materia</option>
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
                        </div> 
                    </div>
                    <div class="form-row">
                        <div class="col-12 col-sm-7">
                            <div class="form-row mb-2">
                                <label for="txtIdPeriodo" class="col-sm-4 col-form-label">Periodo:</label>
                                <div class='col-sm-8'>
                                <select name='txtIdPeriodo' id='txtIdPeriodo' class="selectpicker form-control show-tick" required>
                                    <option value="">Elegir periodo</option>
                                        @foreach($periodos as $valor)
                                            <option value="{{ $valor->id }}" title="{{ $valor->periodoAbrev }}">{{ $valor->periodo }}</option>
                                        @endforeach
                                </select> 
                                </div> 
                            </div>         
                        </div>
                        <div class="col-12 col-sm-5">
                            <div class="form-row mb-2">
                                <label for="txtGestion" class="col-sm-4 col-form-label">Gestion:</label>
                                <div class='col-sm-8'>
                                <select name='txtGestion' id='txtGestion' class="selectpicker form-control show-tick" required>
                                    @foreach($gestiones as $valor)
                                        <option value="{{ $valor }}">{{ $valor }}</option>
                                    @endforeach 
                                </select>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-primary">
                <button type='button' class="btn btn-success btn-sm" id='btnAgregarRegistro'> Agregar</button>
                <button type="button" class="btn btn-info btn-sm" id='btnGuardarRegistro'>Guardar cambios</button>
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
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
        /* Selectores que se modificaran para gestionar registros */
        var idGrupo = $('#idGrupo'); 
        var tituloForm = $('#tituloForm');
        var idUsuario = $('#idUsuario');
        var idPeriodo = $('#idPeriodo');
        var gestion = $('#gestion');
        var generadores = $('#idPeriodo,#gestion,#idGrupo');
        var btnRegistros = $('#btnRegistros');
        var panelEventoHorario = $('#panelEventoHorario');
        var tablaRegistros = $('#tablaRegistros');
        var datosRegistro;
        var txtIdRegistro = $('#txtIdRegistro');
        var txtIdUsuario = $('#txtIdUsuario');
        var txtIdGrupo = $('#txtIdGrupo');    
        var txtIdPeriodo = $('#txtIdPeriodo');
        var txtGestion = $('#txtGestion');
        var btnAgregarRegistro = $('#btnAgregarRegistro');
        var btnGuardarRegistro = $('#btnGuardarRegistro');
        var btnExportar = $('#btnExportar');
        var modificarRegistros = $('#modificarRegistros');
        idPeriodo.val(convPeriodo(moment().format('MM')));
        gestion.val(moment().format('YYYY'));
        idPeriodo.selectpicker('refresh');
        gestion.selectpicker('refresh');
        /* Estructurador de la tabla de registros */
        tablaRegistros.bootstrapTable({
            url:"{{ url('/registro/datosRegistro') }}",
            method:"post",
            queryParams:function (params) {
                var datos = {
                    dato:'regDocente',
                    idPeriodo: idPeriodo.val(),
                    gestion: gestion.val(),
                    idGrupo: idGrupo.val(),
                    '_token': $("meta[name='csrf-token']").attr("content")
                };
                return datos;
            },
            /* height:575, */
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
            classes:'table table-bordered table-hover table-striped ',
            theadClasses: 'bg-primario font-weight-normal',
            buttonsOrder:[/* 'nuevoRegistro' , */'exportarRegistro', 'refresh', 'autoRefresh', 'fullscreen', 'columns'],
            buttons:{           
/*                 nuevoRegistro: {
                    text: 'Nuevo registro',
                    icon: 'fa-plus',
                    attributes:{title: 'Nuevo registro'},
                    event: function () { 
                        var datos;
                        datos = {
                            idRegistro: '',
                            idUsuario: '',
                            idPeriodo: idPeriodo.val(),
                            gestion: gestion.val(),
                            idGrupo: '',
                            title: 'Nuevo REGISTRO'
                        };
                        btnAgregarRegistro.show();
                        btnGuardarRegistro.hide();
                        formularioRegistro(datos);
                    }
                }, */
                exportarRegistro: {
                    text: 'Exportar registros',
                    icon: 'fa-file-excel',
                    attributes:{title: 'Exportar'},
                    event: function () { 

                       $(location).attr('href',"{{ route('administrador.registrosExcel') }}"+"?idGrupo="+idGrupo.val()+"&sigla="+$('#idGrupo :selected').attr('title')+"&periodo="+$('#idPeriodo :selected').attr('title')+"&idPeriodo="+idPeriodo.val()+"&gestion="+gestion.val()+'&'+'_token='+$("meta[name='csrf-token']").attr("content"));
                    }
                }
            },
            columns: [{
                field: 'id',
                title: 'Id',
                sortable: true,
                visible: false
            }, {
                field: 'estCompleto',
                title: 'Estudiante',
                sortable: true,
                visible: true
            },{
                field: 'nombreMat',
                title: 'Materia',
                sortable: true,
                visible: false
            }, {
                field: 'sigla',
                title: 'Sigla',
                sortable: true
            }, {
                field: 'grupo',
                title: 'Grupo',
                sortable: true
            }, {
                field: 'semestre',
                title: 'Semestre',
                sortable: true,
                visible: true
            },  {
                field: 'semestralAnual',
                title: 'Gestion',
                sortable: true
            }, {
                field: 'updated_at',
                title: 'Fecha de registro',
                sortable: true,
                visible: false,
                formatter: function(value,row,index){
                    var fechaRegistro = moment(row.value).format('ddd D/MMM/YYYY - HH:mm');                
                    return fechaRegistro;
                }
            },/*  {
                field:'opciones',
                title:'Opciones',
                align:'center',
                valing: 'middle',
                clickToSelect: false,
                events: {
                    'click .editarRegistro': function (e, value, row, index) {
                        var datos;
                        datos = {
                            idRegistro: row.id,
                            idUsuario: row.idUsuario,
                            idPeriodo: row.periodo_id,
                            gestion: row.gestion,
                            idGrupo: row.idGrupo,
                            title: 'Editar REGISTRO'
                        };
                        btnAgregarRegistro.hide();
                        btnGuardarRegistro.show();
                        formularioRegistro(datos);
                    },
                    'click .eliminarRegistro': function (e, value, row, index) {
                        datos = {
                            id: row.id,
                            estudiante: row.estCompleto,
                            sigla: row.sigla,
                            grupo: row.grupo,
                            '_token': $("meta[name='csrf-token']").attr("content"),
                            '_method': 'DELETE'
                        };
                        eliminarRegistro(datos);
                    }
                },
                formatter: function(value,row,index){
                    var btnOpciones = '<div class="btn-group" data-toggle="buttons"><a href="#" class="editarRegistro btn btn-sm" title="Editar registro"><i class="fas fa-edit text-primary"></i></a><a href="#" class="eliminarRegistro btn btn-sm" title="Eliminar registro"><i class="fas fa-trash text-danger"></i></a></div>';                
                    return btnOpciones;
                }
            } */]
        });
        /* Evento de actualizar tabla segun la gestion academica */
        generadores.on('change',function () {
            tablaRegistros.bootstrapTable('refreshOptions', {
                url:"{{ url('/registro/datosRegistro') }}",
                method:"post",
                queryParams:function (params) {
                    var datos = {
                        dato: 'regDocente',
                        idPeriodo: idPeriodo.val(),
                        gestion: gestion.val(),
                        idGrupo: idGrupo.val(),
                        '_token': $("meta[name='csrf-token']").attr("content")
                        
                    };
                    return datos;
                }
            })
        })
        /* Funcion para recolectar datos del formulario de registros */
        function recolectarRegistro(method){
            datosRegistro = {
                id: txtIdRegistro.val(),
                nombre: txtIdUsuario.val(),
                periodo: txtIdPeriodo.val(),
                gestion: txtGestion.val(),
                materia: txtIdGrupo.val(),
                '_token': $("meta[name='csrf-token']").attr("content"),
                '_method': method
            };
            return datosRegistro;
        };
        /* Funcion para abrir el formulario de materias */
        function formularioRegistro(datos){
            $('#errorValidacion').html('');
            tituloForm.html(datos.title);
            txtIdRegistro.val(datos.idRegistro);
            txtIdUsuario.val(datos.idUsuario); 
            txtIdPeriodo.val(datos.idPeriodo);
            txtIdPeriodo.selectpicker('refresh');
            txtGestion.val(datos.gestion);
            txtGestion.selectpicker('refresh');
            txtIdGrupo.val(datos.idGrupo);
            txtIdGrupo.selectpicker('refresh');
            modificarRegistros.modal('show');
            
        }
/*         btnExportar.on('click',function(e){
            e.preventDefault();
            $.ajax({
                type:'POST',
                url:"{{ url('/exportarRegistros') }}",
                data:{
                    idGrupo: idGrupo.val(),
                    '_token': $("meta[name='csrf-token']").attr("content"),
                } ,
                success: function(msg){
                    if(msg){
                        $.alert('Exportación completada!');            
                    }
                },
                error: function(error){
                }
            });      

        }); */
        /* Evento para agregar nuevo registro */
        btnAgregarRegistro.on('click',function(e){
            e.preventDefault();
            datosRegistro = recolectarRegistro('POST');        
            $.confirm({
                icon: 'fas fa-plus-circle',
                title: 'Crear registro',
                content: '¿Confirma crear el registro de '+$('#txtIdUsuario :selected').text()+' en la materia  '+$('#txtIdGrupo :selected').attr('title')+'?',
                escapeKey: true,
                backgroundDismiss: true,
                type: 'green',
                buttons: {
                    confirmar:{
                        text:'Confirmar',
                        btnClass: 'btn-success',
                        action: function(){
                            enviarRegistro("",datosRegistro);
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
        /* Evento para editar registro */
        btnGuardarRegistro.on('click',function(e){
            e.preventDefault();
            datosRegistro = recolectarRegistro('PATCH'); 
            $.confirm({
                icon: 'fas fa-edit',
                title: 'Editar registro',
                content: '¿Confirma guardar los cambios del registro de '+$('#txtIdUsuario :selected').text()+' en la materia  '+$('#txtIdGrupo :selected').attr('title')+'?',
                escapeKey: true,
                backgroundDismiss: true,
                type: 'blue',
                buttons: {
                    confirmar:{
                        text:'Confirmar',
                        btnClass: 'btn-info',
                        action: function(){
                            enviarRegistro("/",datosRegistro);
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
        /* Funcion para eliminar materia */
        function eliminarRegistro(datos){
            $.confirm({
                icon: 'fas fa-exclamation-triangle',
                title: '¿Eliminar registro?',
                content: 'Recuerde que una vez eliminado el registro de '+datos.estudiante+' en la materia  '+datos.sigla+' Grupo '+datos.grupo+' no se puede recuperar sus datos.',
                type: 'red',
                buttons: {
                    confirmar: {
                        text:'Confirmar',
                        btnClass: 'btn-danger',
                        action: function () {
                            enviarRegistro("/",datos);
                        }
                    },
                    cancelar: {
                        text:'Cancelar',
                        btnClass: 'btn-secondary',
                        action: function(){}
                    }
                }
            });
        }  
        /* Funcion para enviar los datos obtenidos del formulario */
        function enviarRegistro(accion,datos){
            $.ajax({
                type:'POST',
                url:"{{ url('/registro') }}"+accion+datos.id,
                data: datos,
                success: function(msg){
                    if(msg){
                        modificarRegistros.modal('hide');
                        switch (datos['_method']) {
                            case 'POST':
                                $.alert({
                                    title:false,
                                    content: 'Se creó el registro de '+$('#txtIdUsuario :selected').attr('title')+' en la materia  '+$('#txtIdGrupo :selected').attr('title'),
                                    buttons: {
                                        cancelar: {
                                            titleClass:'',
                                            text:'Aceptar',
                                            btnClass: 'btn-success',
                                            action: function(){}
                                        }
                                    }
                                });
                                break;
                            case 'PATCH':
                                $.alert({
                                    title:false,
                                    content: 'Se guardó los cambios del registro de '+$('#txtIdUsuario :selected').attr('title')+' en la materia  '+$('#txtIdGrupo :selected').attr('title'),
                                    buttons: {
                                        cancelar: {
                                            titleClass:'',
                                            text:'Aceptar',
                                            btnClass: 'btn-info',
                                            action: function(){}
                                        }
                                    }
                                });
                                break;
                            case 'DELETE':
                                $.alert({
                                    title:false,
                                    content: 'Se eliminó el registro de '+datos.estudiante+' en la materia  '+datos.sigla+' Grupo '+datos.grupo,
                                    buttons: {
                                        cancelar: {
                                            titleClass:'',
                                            text:'Aceptar',
                                            btnClass: 'btn-danger',
                                            action: function(){}
                                        }
                                    }
                                });
                                break;
                            default:
                                break;
                        }
                        tablaRegistros.bootstrapTable('refresh');              
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
                    /* $.alert('No se pudo guardar los datos del registro!'); */
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
    });
</script> 
@stop