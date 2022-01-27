@extends('adminlte::page')

@section('title', 'Organizador ETN')

@section('plugins.bootstrap-table',true)

@section('content_header')

@stop
@section('content')
<!-- Panel de tabla de programas -->
<div class="row mt-2">
    <div class="col-8">
        <div class="lead font-weight-bold">ADMINISTRACIÓN MENCIONES</div> 
        </div>
    <div class="col-4">
        <div class="input-group">
            <div class="input-group-prepend">
                <label class="input-group-text bg-primario font-weight-normal" for="idMencion">Mención</label>
            </div>
            <select class="selectpicker form-control show-tick" id="idMencion" name="idMencion" aria-label="Small" aria-describedby="addonidMencion" required>
                @foreach($menciones as $valor)
                    <option value="{{ $valor->id }}" mencion="{{ $valor->mencion }}" >{{ $valor->mencion }}</option>
                @endforeach
            </select>
        </div>
    </div>       
</div>
<div class="table-responsive">
    <table id="tablaProgramas"></table>
</div>
<!-- Modal para detalles de los menciones -->
<div class="modal fade" id="modificarProgramas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
        <input type="hidden" name="txtIdPrograma" id="txtIdPrograma">
        <div class="modal-body">
            <div class="text-danger" role="alert">
                <ul id="errorValidacion" class="list-group-item-danger mb-1 mt-0">
                </ul>
            </div>
            <div class="form-row mb-2">
                <label for="txtIdMateria" class="col-sm-2 col-form-label">Materia:</label>
                <div class='col-sm-10'>
                    <select name='txtIdMateria' id='txtIdMateria' class="selectpicker form-control show-tick" data-live-search="true" required></select> 
                </div>
            </div>
            <div class="form-row">
                <div class="col-12 col-sm-6">
                    <div class="form-row mb-2">
                        <label for="txtIdMencion" class="col-sm-4 col-form-label">Mencion:</label>
                        <div class='col-sm-8'>
                            <select name='txtIdMencion' id='txtIdMencion' class="selectpicker form-control show-tick" required>
                            @foreach($menciones as $valor)
                                <option value="{{ $valor->id }}">{{ $valor->mencion }}</option>
                            @endforeach
                            </select> 
                        </div> 
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="form-row mb-2">
                        <label for="txtIdSemestre" class="col-sm-4 col-form-label">Semestre:</label>
                        <div class='col-sm-8'>
                            <select name='txtIdSemestre' id='txtIdSemestre' class="selectpicker form-control show-tick" required>
                                <option value="">Elegir semestre</option>
                                @foreach($semestres as $valor)
                                    <option value="{{ $valor->id }}">{{ $valor->semestre }}</option>
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
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancelar</button>
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
        var tituloForm = $('#tituloForm');
        var tablaProgramas = $('#tablaProgramas');
        var idMencion = $('#idMencion');
        var datosPrograma;
        var txtIdPrograma = $('#txtIdPrograma');
        var txtIdMateria = $('#txtIdMateria');
        var txtIdMencion = $('#txtIdMencion');    
        var txtIdSemestre=$('#txtIdSemestre');
        var btnAgregar = $('#btnAgregar');
        var btnGuardar = $('#btnGuardar');
        var modificarProgramas = $('#modificarProgramas');
        /* Estructurador de la tabla de programas */
        tablaProgramas.bootstrapTable({
            url:"{{ url('/programa') }}"+"/"+idMencion.val(),
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
            buttonsOrder:['nuevoPrograma' , 'refresh', 'autoRefresh', 'fullscreen', 'columns'],
            buttons:{           
                nuevoPrograma: {
                    text: 'Nueva designación',
                    icon: 'fa-plus',
                    attributes:{title: 'Nueva asignación'},
                    event: function () { 
                        var datos;
                        datos = {
                            idPrograma: '',
                            idMencion: idMencion.val(),
                            idMateria: '',
                            idSemestre: '',
                            listaMaterias: 'noMencion',
                            title:'Nueva ASIGNACIÓN'
                        };
                        btnAgregar.show();
                        btnGuardar.hide();
                        formularioPrograma(datos);
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
                field: 'semestre',
                title: 'Semestre',
                sortable: true
            }, {
                field: 'area',
                title: 'Area',
                sortable: true
            }, {
                field:'opciones',
                title:'Opciones',
                align:'center',
                valing: 'middle',
                clickToSelect:false,
                events: {
                    'click .editarPrograma': function (e, value, row, index) {
                        var datos;
                        datos = {
                            idPrograma: row.id,
                            idMencion: row.mencione_id,
                            idMateria: row.materia_id,
                            idSemestre: row.semestre_id,
                            listaMaterias: 'siMencion',
                            title:'Editar ASIGNACIÓN'
                        };
                        btnAgregar.hide();
                        btnGuardar.show();
                        formularioPrograma(datos);
                    },
                    'click .eliminarPrograma': function (e, value, row, index) {
                        datos = {
                            id: row.id,
                            mencion: row.mencion,
                            '_token': $("meta[name='csrf-token']").attr("content"),
                            '_method': 'DELETE'
                        };
                        eliminarPrograma(datos);
                    }
                },
                formatter: function(value,row,index){
                    var btnOpciones = '<div class="btn-group" data-toggle="buttons"><a href="#" class="editarPrograma btn btn-sm" title="Editar asignación"><i class="fas fa-edit text-primary"></i></a><a href="#" class="eliminarPrograma btn btn-sm" title="Eliminar asignación"><i class="fas fa-trash text-danger"></i></a></div>';                
                    return btnOpciones;
                }
            }]
        });
        /* Evento para actualizar la tabla cambiando el valor de la mencion */
        idMencion.on('change',function () {
            tablaProgramas.bootstrapTable('refreshOptions', {
                url:"{{ url('/programa') }}"+"/"+idMencion.val(),
            })
        })
        /* Funcion para recolectar datos del formulario de programas */
        function recolectarPrograma(method){
            datosPrograma = {
                id: txtIdPrograma.val(),
                mencione_id: txtIdMencion.val(),
                materia: txtIdMateria.val(),
                semestre: txtIdSemestre.val(),
                '_token': $("meta[name='csrf-token']").attr("content"),
                '_method': method
            };
            return datosPrograma
        };
        /* Funcion para abrir el formulario de programas */
        function formularioPrograma(datos){
            tituloForm.html(datos.title);
            $('#errorValidacion').html('');
            $.ajax({
                type:'POST',
                url:"{{ url('/materia/datosMateria') }}",
                data: {
                    dato: datos.listaMaterias,
                    idMencion: datos.idMencion,
                    '_token': $("meta[name='csrf-token']").attr("content")
                },
                success: function(resultado){
                    /* Estructurando lista de materias en un selector */
                    txtIdMateria.find('option').remove();
                    txtIdMateria.append('<option class="text-wrap" value="" title="Elegir materia">Elegir materia</option>');
                    $(resultado).each(function(indice, valor){
                        txtIdMateria.append('<option class="text-wrap" value="' + valor.id + '" title="' + valor.nombreMat + ' ' + valor.sigla + '">' + valor.nombreMat + ' (' + valor.sigla + ')</option>');
                    })
                    txtIdPrograma.val(datos.idPrograma)
                    txtIdMateria.val(datos.idMateria);
                    txtIdMencion.val(datos.idMencion);
                    txtIdSemestre.val(datos.idSemestre);
                    txtIdMateria.selectpicker('refresh');
                    txtIdSemestre.selectpicker('refresh');
                    txtIdMencion.attr("disabled",true);
                    txtIdMencion.selectpicker('refresh');
                    modificarProgramas.modal('show');               
                },
                error: function(){
                    $.alert("Hay un error al obtener la lista de materias de la mención");
                }
            });

        }
        /* Evento para asignar mencion a nueva materia */
        btnAgregar.on('click',function(e){
            e.preventDefault();
            datosPrograma = recolectarPrograma('POST');        
            $.confirm({
                icon: 'fas fa-plus-circle',
                title: 'Asignar materia a mención',
                content: '¿Confirma asignar ésta materia a la mención seleccionada?',
                escapeKey: true,
                backgroundDismiss: true,
                type: 'green',
                buttons: {
                    confirmar:{
                        text:'Confirmar',
                        btnClass: 'btn-success',
                        action: function(){
                            enviarPrograma("",datosPrograma);
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
        /* Evento para editar materia de una mencion */
        btnGuardar.on('click',function(e){
            e.preventDefault();
            datosPrograma = recolectarPrograma('PATCH');  
            $.confirm({
                icon: 'fas fa-edit',
                title: 'Editar materia de mención',
                content: '¿Confirma editar datos de ésta materia de la mención seleccionada?',
                escapeKey: true,
                backgroundDismiss: true,
                type: 'blue',
                buttons: {
                    confirmar:{
                        text:'Confirmar',
                        btnClass: 'btn-info',
                        action: function(){
                            enviarPrograma("/",datosPrograma);
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
        /* Funcion para eliminar materia de una programa */
        function eliminarPrograma(datos){
            $.confirm({
                icon: 'fas fa-exclamation-triangle',
                title: '¿Eliminar materia de mención?',
                content: 'Recuerde que una vez eliminado ésta materia de la mención seleccionada no se puede recuperar sus datos.',
                type: 'red',
                buttons: {
                    confirmar: {
                        text:'Confirmar',
                        btnClass: 'btn-danger',
                        action: function () {
                            enviarPrograma("/",datos);
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
        function enviarPrograma(accion,datos){
            $.ajax({
                type:'POST',
                url:"{{ url('/programa') }}"+accion+datos.id,
                data: datos,
                success: function(msg){
                    if(msg){
                        modificarProgramas.modal('hide');
                        $.alert('Cambios guardados con éxito!');
                        tablaProgramas.bootstrapTable('refresh');
                        $('#errorValidacion').html('');              
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
                    /* $.alert('No se pudo guardar los datos de la materia de mención!'); */
                }
            });
        }
    });
</script> 
@stop