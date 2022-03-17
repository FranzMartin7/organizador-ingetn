@extends('adminlte::page')

@section('title', 'Organizador ETN')

@section('plugins.bootstrap-table',true)

@section('content_header')

@stop
@section('content')
<!-- Panel de tabla de asignaturas -->
<div class="d-flex justify-content-start">
    <div class="lead font-weight-bold">ADMINISTRACIÓN ASIGNATURAS</div>        
</div>
<div class="table-responsive">
    <table id="tablaAsignaturas"></table>
</div>
<!-- Modal para detalles de los asignatura -->
<div class="modal fade" id="modificarAsignaturas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                <input type="hidden" id="txtIdAsignatura">
                <div class="form-row">
                    <div class="col-12">
                        <div class="form-row mb-2">
                            <label for="txtIdGrupo" class="col-sm-2 col-form-label">Materia:</label>
                            <div class='col-sm-10'>
                                <select name='txtIdGrupo' id='txtIdGrupo' class="selectpicker form-control show-tick" data-live-search="true" required>
                                    <option value="">Elegir materia</option>
                                    @foreach($semestres as $valorSemestre)
                                        <optgroup label="{{ $valorSemestre->semestre }}">
                                        @foreach($grupos as $valor)
                                            @if ($valor->semestre_id==$valorSemestre->id)                        
                                                <option value="{{ $valor->id }}" title="{{ $valor->sigla.' Grupo '.$valor->grupo }}" data-subtext=" {{ 'Grupo '.$valor->grupo }}" showSubtext="true">{{ $valor->nombreMat.' ('.$valor->sigla.')' }}</option>
                                            @endif
                                        @endforeach
                                        </optgroup>
                                    @endforeach 
                                </select> 
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-row mb-2">
                    <label for="txtIdUsuario" class="col-sm-2 col-form-label">Docente:</label>
                    <div class='col-sm-10'>
                    <select name='txtIdUsuario' id='txtIdUsuario' class="selectpicker form-control show-tick" data-live-search="true" required>
                        <option value="">Elegir docente</option>
                        @foreach($docentes as $valor)                       
                            <option value="{{ $valor->id }}" title="{{ $valor->titulos->tituloAbrev.' '.$valor->apPaterno }}">{{ $valor->titulos->tituloAbrev.' '.$valor->name.' '.$valor->apPaterno.' '.$valor->apMaterno }}</option>
                        @endforeach
                    </select>
                    </div> 
                </div>
                <div class="form-row">
                    <div class="col-12 col-sm-7">
                        <div class="form-row mb-2">
                            <label for="txtIdActividad" class="col-sm-4 col-form-label">Actividad:</label>
                            <div class='col-sm-8'>
                                <select name='txtIdActividad' id='txtIdActividad' class="selectpicker form-control show-tick" data-live-search="true" required>
                                    <option value="">Elegir actividad</option>
                                    @foreach($actividades as $valor)
                                        <option value="{{ $valor->id }}">{{ $valor->actividad }}</option>
                                    @endforeach 
                                </select> 
                            </div> 
                        </div>  
                    </div>
                    <div class="col-12 col-sm-5">
                        <div class="form-row mb-2">
                            <label for="txtIdEstado" class="col-sm-4 col-form-label">Estado:</label>
                            <div class='col-sm-8'>
                                <select name='txtIdEstado' id='txtIdEstado' class="selectpicker form-control show-tick" required>
                                    @foreach($estados as $valor)
                                        <option value="{{ $valor->id }}">{{ $valor->estado }}</option>
                                    @endforeach 
                                </select>
                            </div>  
                        </div>
                    </div>
                </div> 
                <div class="form-row">
                    <div class="col-12 col-sm-7">
                        <div class="form-row mb-2">
                            <label for="txtIdDocencia" class="col-sm-4 col-form-label">Docencia:</label>
                            <div class='col-sm-8'>
                            <select name='txtIdDocencia' id='txtIdDocencia' class="selectpicker form-control show-tick" data-live-search="true">
                                <option value="">Elegir docencia</option>
                                @foreach($docencias as $valor)                       
                                    <option value="{{ $valor->id }}">{{ $valor->docencia }}</option>
                                @endforeach
                            </select>
                            </div> 
                        </div>
                    </div>
                    <div class="col-12 col-sm-5">
                        <div class="form-row mb-2">
                            <label for="txtCarga" class="col-sm-5 col-form-label">Carga H:</label>
                            <div class='col-sm-7'>
                                <input type="number" id="txtCarga" class="form-control" autocomplete="off" required>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-primary">
            <button type='button' class="btn btn-success btn-sm" id='btnAgregar'> Agregar</button>
            <button type="button" class="btn btn-info btn-sm" id='btnGuardar'>Guardar cambios</button>
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
        var tituloForm = $('#tituloForm');
        var btnAsignaturas = $('#btnAsignaturas');
        var tablaAsignaturas = $('#tablaAsignaturas');
        var datosAsignatura;
        var txtIdAsignatura = $('#txtIdAsignatura');
        var txtIdGrupo = $('#txtIdGrupo'); 
        var txtIdDocencia = $('#txtIdDocencia'); 
        var txtIdUsuario=$('#txtIdUsuario');
        var txtIdActividad = $('#txtIdActividad');
        var txtCarga = $('#txtCarga');
        var txtIdEstado = $('#txtIdEstado');
        var btnAgregar = $('#btnAgregar');
        var btnGuardar = $('#btnGuardar');
        var modificarAsignaturas = $('#modificarAsignaturas');
        tablaAsignaturas.bootstrapTable({
            url:"{{ url('/asignatura/show') }}",
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
            classes:'table table-bordered table-hover table-striped',
            theadClasses: 'bg-primario font-weight-normal',
            buttonsOrder:['nuevaAsignatura' , 'refresh', 'autoRefresh', 'fullscreen', 'columns'],
            buttons:{           
                nuevaAsignatura: {
                    text: 'Nueva asignatura',
                    icon: 'fa-plus',
                    attributes:{title: 'Nueva asignatura'},
                    event: function () { 
                        var datos;
                        datos = {
                            idAsignatura: '',
                            idUsuario: '',
                            idGrupo: '',
                            idActividad: '',
                            idDocencia:'',
                            carga:'',
                            idEstado: '2',
                            title:'Nueva ASIGNATURA'
                        };
                        btnAgregar.show();
                        btnGuardar.hide();
                        formularioAsignatura(datos);
                    }
                }
            },
            columns: [{
                field: 'id',
                title: 'Id',
                sortable: true,
                visible: false
            }, {
                field: 'nombreMat',
                title: 'Materia',
                sortable: true
            }, {
                field: 'sigla',
                title: 'Sigla',
                sortable: true,
                visible: true
            }, {
                field: 'grupo',
                title: 'Grupo',
                sortable: true
            }, {
                field: 'docAbrev',
                title: 'Docente',
                sortable: true
            }, {
                field: 'actividad',
                title: 'Actividad',
                sortable: true,
                formatter: function(valor,fila,indice){
                    switch (valor) {
                        case 'Teoría':
                            var colorTexto = '<div class="card text-center m-0 bg-danger">'+valor+'</div>';                        
                            break;                    
                        case 'Laboratorio':
                            var colorTexto = '<div class="card text-center m-0 bg-azul">'+valor+'</div>';                        
                            break;
                        case 'Ayudantía':
                            var colorTexto = '<div class="card text-center m-0 bg-verde">'+valor+'</div>';                       
                            break;
                        default:
                            break;
                    }           
                    return colorTexto;
                }
            }, {
                field: 'carga',
                title: 'Carga horaria',
                sortable: false,
                formatter: function(valor,fila,indice){
                    var colorTexto = '<div class="text-azul font-italic">'+valor+' '+'Hrs.'+'</div>';             
                    return colorTexto;
                }
            },{
                field: 'docencia',
                title: 'Docencia',
                sortable: true,
                visible: false
            }, {
                field: 'estado',
                title: 'Estado',
                sortable: true,
                visible: false,
                formatter: function(valor,fila,indice){
                    if(valor=='Activo'){
                        var colorTexto = '<div class="text-success font-italic">'+valor+'</div>';
                    }else{
                        var colorTexto = '<div class="text-muted font-italic">'+valor+'</div>';
                    }                
                    return colorTexto;
                }
            }, {
                field:'Opciones',
                title:'Opciones',
                align:'center',
                valing: 'middle',
                clickToSelect:false,
                events: {
                    'click .editarAsignatura': function (e, value, row, index) {
                        var datos;
                        datos = {
                            idAsignatura: row.id,
                            idUsuario: row.user_id,
                            idGrupo: row.idGrupo,
                            idActividad: row.actividade_id,
                            idDocencia:row.docencia_id,
                            carga: row.carga,
                            idEstado: row.estado_id,
                            title:'Editar ASIGNATURA'
                        };
                        btnAgregar.hide();
                        btnGuardar.show();
                        formularioAsignatura(datos);
                    },
                    'click .eliminarAsignatura': function (e, value, row, index) {
                        datos = {
                            id: row.id,
                            sigla: row.sigla,
                            docente: row.docAbrev,
                            grupo: row.grupo,
                            '_token': $("meta[name='csrf-token']").attr("content"),
                            '_method': 'DELETE'
                        };
                        eliminarAsignatura(datos);
                    }
                },
                formatter: function(value,row,index){
                    var btnOpciones = '<div class="btn-group" data-toggle="buttons"><a href="#" class="editarAsignatura btn btn-sm" title="Editar asignatura"><i class="fas fa-edit text-primary"></i></a><a href="#" class="eliminarAsignatura btn btn-sm" title="Eliminar asignatura"><i class="fas fa-trash text-danger"></i></a></div>';                
                    return btnOpciones;
                }
            }]
        });
        /* Funcion para recolectar datos del formulario de asignaturas */
        function recolectarAsignatura(method){
            datosAsignatura = {
                id: txtIdAsignatura.val(),
                docente: txtIdUsuario.val(),
                materia: txtIdGrupo.val(),
                actividad: txtIdActividad.val(),
                docencia: txtIdDocencia.val(),
                carga_horaria: txtCarga.val(),
                estado: txtIdEstado.val(),
                '_token': $("meta[name='csrf-token']").attr("content"),
                '_method': method
            };
            return datosAsignatura;
        };
        /* Funcion para abrir el formulario de asignaturas */
        function formularioAsignatura(datos){
            $('#errorValidacion').html('');
            tituloForm.html(datos.title)
            txtIdAsignatura.val(datos.idAsignatura);
            txtIdUsuario.val(datos.idUsuario);
            txtIdGrupo.val(datos.idGrupo);
            txtIdActividad.val(datos.idActividad);
            txtIdDocencia.val(datos.idDocencia);
            txtCarga.val(datos.carga);
            txtIdEstado.val(datos.idEstado);
            txtIdUsuario.selectpicker('refresh');
            txtIdDocencia.selectpicker('refresh');
            txtIdGrupo.selectpicker('refresh');
            txtIdActividad.selectpicker('refresh');
            txtIdEstado.selectpicker('refresh');
            modificarAsignaturas.modal('show');
        }
        /* Evento para agregar nueva asignatura */
        btnAgregar.on('click',function(e){
            e.preventDefault();
            datosAsignatura = recolectarAsignatura('POST');        
            $.confirm({
                icon: 'fas fa-plus-circle',
                title: 'Crear asignatura',
                content: '¿Confirma crear la asignatura de '+$('#txtIdGrupo :selected').attr('title')+' del '+$('#txtIdUsuario :selected').attr('title')+'?',
                escapeKey: true,
                backgroundDismiss: true,
                type: 'green',
                buttons: {
                    confirmar:{
                        text:'Confirmar',
                        btnClass: 'btn-success',
                        action: function(){
                            enviarAsignatura("",datosAsignatura);
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
        /* Evento para editar asignatura */
        btnGuardar.on('click',function(e){
            e.preventDefault();
            datosAsignatura = recolectarAsignatura('PATCH'); 
            $.confirm({
                icon: 'fas fa-edit',
                title: 'Editar asignatura',
                content: '¿Confirma guardar los cambiar de la asignatura '+$('#txtIdGrupo :selected').attr('title')+' del '+$('#txtIdUsuario :selected').attr('title')+'?',
                escapeKey: true,
                backgroundDismiss: true,
                type: 'blue',
                buttons: {
                    confirmar:{
                        text:'Confirmar',
                        btnClass: 'btn-info',
                        action: function(){
                            enviarAsignatura("/",datosAsignatura);
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
        /* Funcion para eliminar asigantura */
        function eliminarAsignatura(datos){
            $.confirm({
                icon: 'fas fa-exclamation-triangle',
                title: '¿Eliminar asignatura?',
                content: 'Recuerde que una vez eliminado la asignatura '+datos.sigla+' Grupo '+datos.grupo+' del '+datos.docente+' no se podrá recuperar sus datos.',
                type: 'red',
                buttons: {
                    confirmar: {
                        text:'Confirmar',
                        btnClass: 'btn-danger',
                        action: function () {
                            enviarAsignatura("/",datos);
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
        function enviarAsignatura(accion,datos){
            $.ajax({
                type:'POST',
                url:"{{ url('/asignatura') }}"+accion+datos.id,
                data: datos,
                success: function(msg){
                    if(msg){
                        modificarAsignaturas.modal('hide');
                        switch (datos['_method']) {
                            case 'POST':
                                $.alert({
                                    title:false,
                                    content: 'Se creó la asignatura de '+$('#txtIdGrupo :selected').attr('title')+' del '+$('#txtIdUsuario :selected').attr('title'),
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
                                    content: "Se guardó los cambios de la asignatura de "+$('#txtIdGrupo :selected').attr('title')+" del "+$('#txtIdUsuario :selected').attr('title'),
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
                                    content: 'Se eliminó la asignatura '+datos.sigla+' Grupo '+datos.grupo+' del '+datos.docente,
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
                        tablaAsignaturas.bootstrapTable('refresh');
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
                   /*  $.alert('No se pudo guardar los datos de la asignatura!'); */
                }
            });
        }
    });
</script> 
@stop