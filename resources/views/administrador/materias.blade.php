@extends('adminlte::page')

@section('title', 'Organizador ETN')

@section('plugins.bootstrap-table',true)

@section('content_header')

@stop
@section('content')
<!-- Panel de tabla de materias -->
<div class="d-flex justify-content-start">
    <div class="lead font-weight-bold">ADMINISTRACIÓN MATERIAS</div>    
</div>
<div class="table-responsive">
    <table id="tablaMaterias"></table>
</div>
<!-- Modal para detalles de los materias -->
<div class="modal fade" id="modificarMaterias" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header bg-primary">
            <div class="modal-title text-white">
                <div class="lead">Datos Materia</div>
            </div>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form method="post" action="#">
            <input type="hidden" name="txtIdMateria" id="txtIdMateria">
            <div class="text-danger" role="alert">
                <ul id="errorValidacion" class="list-group-item-danger my-0">
                </ul>
            </div>
            <div class="modal-body">
                <div class="form-row mb-2">
                    <label for="txtNombre" class="col-sm-2 col-form-label">Nombre:</label>
                    <div class='col-sm-10'>
                        <input type="text" id="txtNombre" name='txtNombre' class="form-control" autocomplete="off" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-12 col-sm-6">
                        <div class="form-row mb-2">
                            <label for="txtSigla" class="col-sm-4 col-form-label">Sigla:</label>
                            <div class='col-sm-8'>
                                <input type="text" id="txtSigla" class="form-control" autocomplete="off" required>
                            </div> 
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="form-row mb-2">
                            <label for="txtColor" class="col-sm-4 col-form-label">Color:</label>
                            <div class='col-sm-8'>
                                <input type="color" id="txtColor" class="form-control" autocomplete="off" required>
                            </div> 
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-12 col-sm-6">
                        <div class="form-row mb-2">
                            <label for="txtIdArea" class="col-sm-4 col-form-label">Area:</label>
                            <div class='col-sm-8'>
                                <select name='txtIdArea' id='txtIdArea' class="selectpicker form-control show-tick" required>
                                    <option value="">Elegir área</option>
                                    @foreach($areas as $valor)
                                        <option value="{{ $valor->id }}">{{ $valor->area }}</option>
                                    @endforeach 
                                </select> 
                            </div> 
                        </div>         
                    </div>
                    <div class="col-12 col-sm-6">
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
            </div>
            <div class="modal-footer bg-primary">
            <button type='button' class="btn btn-success btn-sm" id='btnAgregar'>Agregar</button>
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
    /* Selectores que se modificaran para gestionar materias */
    var btnMaterias = $('#btnMaterias');
    var panelEventoHorario = $('#panelEventoHorario');
    var tablaMaterias = $('#tablaMaterias');
    var datosMateria;
    var txtIdMateria = $('#txtIdMateria');
    var txtNombre = $('#txtNombre');
    var txtSigla = $('#txtSigla');    
    var txtIdArea=$('#txtIdArea');
    var txtIdEstado = $('#txtIdEstado');
    var txtColor = $('#txtColor');
    var btnAgregar = $('#btnAgregar');
    var btnGuardar = $('#btnGuardar');
    var modificarMaterias = $('#modificarMaterias');
    /* Evento cuando se hace click en el boton materias */
    btnMaterias.on('click', function (e) {
        e.preventDefault();
        $(this).tab('show');
        panelEventoHorario.hide();
    })
     /* Estructurando la tabla de materias */
    tablaMaterias.bootstrapTable({
        url:"{{ url('/materia/show') }}",
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
        buttonsOrder:['nuevaMateria' , 'refresh', 'autoRefresh', 'fullscreen', 'columns'],
        buttons:{           
            nuevaMateria: {
                text: 'Nueva materia',
                icon: 'fa-plus',
                attributes:{title: 'NUEVA MATERIA'},
                event: function () { 
                    var datos;
                    datos = {
                        idMateria: '',
                        nombre: '',
                        sigla: '',
                        idArea: '',
                        idEstado: '2',
                        color: ''
                    };
                    btnAgregar.show();
                    btnGuardar.hide();
                    formularioMateria(datos);
                }
            }
        },
        columns: [{
            field: 'id',
            title: 'ID Materia',
            sortable: true,
            visible: false,
        }, {
            field: 'nombreMat',
            title: 'Materia',
            sortable: true
        }, {
            field: 'sigla',
            title: 'Sigla',
            sortable: true,
            visible: false
        }, {
            field: 'area',
            title: 'Área',
            sortable: true
        }, {
            field: 'color',
            title: 'Color',
            sortable: true,
            formatter: function(value,row,index){
                var mostrarColor = '<div class="card text-white text-center" style="background-color: '+row.color+';">'+value+'</div>';                
                return mostrarColor;
            }
        }, {
            field: 'estado',
            title: 'Estado',
            sortable: true,
            formatter: function(valor,fila,indice){
                if(valor=='Activo'){
                    var colorTexto = '<div class="text-success font-italic">'+valor+'</div>';
                }else{
                    var colorTexto = '<div class="text-muted font-italic">'+valor+'</div>';
                }                
                return colorTexto;
            }
        }, {
            field:'opciones',
            title:'Opciones',
            align:'center',
            valing: 'middle',
            clickToSelect:false,
            events: {
                'click .editarMateria': function (e, value, row, index) {
                    var datos;
                    datos = {
                        idMateria: row.id,
                        nombre: row.nombreMat,
                        sigla: row.sigla,
                        idArea: row.area_id,
                        idEstado: row.estado_id,
                        color: row.color
                    };
                    btnAgregar.hide();
                    btnGuardar.show();
                    formularioMateria(datos);
                },
                'click .eliminarMateria': function (e, value, row, index) {
                    datos = {
                        id: row.id,
                        '_token': $("meta[name='csrf-token']").attr("content"),
                        '_method': 'DELETE'
                    };
                    eliminarMateria(datos);
                }
            },
            formatter: function(value,row,index){
                var btnOpciones = '<div class="btn-group" data-toggle="buttons"><a href="#" class="editarMateria btn btn-sm"><i class="fas fa-edit text-primary"></i></a><a href="#" class="eliminarMateria btn btn-sm"><i class="fas fa-trash text-danger"></i></a></div>';                
                return btnOpciones;
            }
        }]
    });

    /* Funcion para recolectar datos del formulario de materias */
    function recolectarMateria(method){
        datosMateria = {
            id: txtIdMateria.val(),
            nombre: txtNombre.val(),
            sigla: txtSigla.val(),
            area: txtIdArea.val(),
            estado: txtIdEstado.val(),
            color: txtColor.val(),
            '_token': $("meta[name='csrf-token']").attr("content"),
            '_method': method
        };
        return datosMateria;
    };
    /* Funcion para abrir el formulario de materias */
    function formularioMateria(datos){
        $('#errorValidacion').html('');
        txtIdMateria.val(datos.idMateria);
        txtNombre.val(datos.nombre);
        txtSigla.val(datos.sigla);
        txtIdArea.val(datos.idArea);
        txtIdEstado.val(datos.idEstado);
        txtColor.val(datos.color);
        txtIdArea.selectpicker('refresh');
        txtIdEstado.selectpicker('refresh');
        modificarMaterias.modal('show');
    }
     /* Evento para agregar nueva materia */
    btnAgregar.on('click',function(e){
        e.preventDefault();
        datosMateria = recolectarMateria('POST');        
        $.confirm({
            icon: 'fas fa-plus-circle',
            title: 'Crear materia',
            content: '¿Confirma crear nueva materia ' + datosMateria.sigla + '?',
            escapeKey: true,
            backgroundDismiss: true,
            type: 'green',
            buttons: {
                confirmar:{
                    text:'Confirmar',
                    btnClass: 'btn-success',
                    action: function(){
                        enviarMateria("",datosMateria);
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
    /* Evento para editar materia */
    btnGuardar.on('click',function(e){
        e.preventDefault();
        datosMateria = recolectarMateria('PATCH');  
        $.confirm({
            icon: 'fas fa-edit',
            title: 'Editar materia',
            content: '¿Confirma editar datos de la materia ' + datosMateria.sigla + '?',
            escapeKey: true,
            backgroundDismiss: true,
            type: 'blue',
            buttons: {
                confirmar:{
                    text:'Confirmar',
                    btnClass: 'btn-info',
                    action: function(){
                        enviarMateria("/",datosMateria);
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
    function eliminarMateria(datos){
        $.confirm({
            icon: 'fas fa-exclamation-triangle',
            title: '¿Eliminar materia?',
            content: 'Recuerde que una vez eliminado la materia no se puede recuperar sus datos.',
            type: 'red',
            buttons: {
                confirmar: {
                    text:'Confirmar',
                    btnClass: 'btn-danger',
                    action: function () {
                        enviarMateria("/",datos);
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
    function enviarMateria(accion,datos){
        $.ajax({
            type:'POST',
            url:"{{ url('/materia') }}"+accion+datos.id,
            data: datos,
            success: function(msg){
                if(msg){
                    modificarMaterias.modal('hide');
                    tablaMaterias.bootstrapTable('refresh')
                    $('#errorValidacion').html('');;              
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
                /* $.alert('No se pudo guardar los datos de la materia!'); */
            }
        });
    }  
});
</script> 
@stop