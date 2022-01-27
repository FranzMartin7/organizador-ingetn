@extends('adminlte::page')

@section('title', 'Organizador ETN')

@section('plugins.bootstrap-table',true)

@section('content_header')

@stop
@section('content')
<!-- Panel de tabla de materias -->
<div class="d-flex justify-content-start">
    <div class="lead font-weight-bold">ADMINISTRACIÓN GRUPOS</div>    
</div>
<div class="table-responsive">
    <table id="tablaGrupos"></table>
</div>
<!-- Modal para detalles de los materias -->
<div class="modal fade" id="modificarMaterias" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                <input type="hidden" name="txtIdGrupo" id="txtIdGrupo">
                <input type="hidden" name="txtSigla" id="txtSigla">
                <div class="form-row">
                    <div class="col-12 col-sm-6">
                        <div class="form-row mb-2">
                            <label for="txtIdMateria" class="col-sm-4 col-form-label">Materia:</label>
                            <div class='col-sm-8'>
                                <select name='txtIdMateria' id='txtIdMateria' class="selectpicker form-control show-tick" data-live-search="true" required>
                                    <option value="">Elegir materia</option>
                                    @foreach($semestres as $valorSemestre)
                                        <optgroup label="{{ $valorSemestre->semestre }}">
                                        @foreach($materias as $valor)
                                            @if ($valor->semestre_id==$valorSemestre->id)
                                                <option value="{{ $valor->id }}" title="{{ $valor->sigla }}">{{ $valor->nombreMat.' ('.$valor->sigla.')' }}</option>
                                            @endif
                                        @endforeach
                                        </optgroup>
                                    @endforeach 
                                </select> 
                            </div> 
                        </div>         
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="form-row mb-2">
                            <label for="txtGrupo" class="col-sm-4 col-form-label">Grupo:</label>
                            <div class='col-sm-8'>
                                <select name='txtGrupo' id='txtGrupo' class="selectpicker form-control show-tick" data-live-search="true" required>
                                    <option value="">Elegir grupo</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D">D</option>
                                    <option value="E">E</option>
                                    <option value="F">F</option>
                                    <option value="G">G</option>
                                    <option value="H">H</option>
                                    <option value="I">I</option>
                                    <option value="J">J</option>
                                    <option value="K">K</option>
                                    <option value="L">L</option>
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
        var tituloForm = $('#tituloForm');
        var tablaGrupos = $('#tablaGrupos');
        var datosGrupo; 
        var txtIdGrupo=$('#txtIdGrupo');
        var txtSigla=$('#txtSigla');
        var txtIdMateria=$('#txtIdMateria');
        var txtGrupo = $('#txtGrupo');
        var btnAgregar = $('#btnAgregar');
        var btnGuardar = $('#btnGuardar');
        var modificarMaterias = $('#modificarMaterias');
        /* Estructurando la tabla de materias */
        tablaGrupos.bootstrapTable({
            url:"{{ url('/grupo/show') }}",
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
            buttonsOrder:['nuevoGrupo' , 'refresh', 'autoRefresh', 'fullscreen', 'columns'],
            buttons:{           
                nuevoGrupo: {
                    text: 'Nuevo grupo',
                    icon: 'fa-plus',
                    attributes:{title: 'Nuevo GRUPO'},
                    event: function () { 
                        var datos;
                        datos = {
                            idGrupo: '',
                            idMateria: '',
                            sigla: '',
                            grupo: '',
                            title:'Nuevo GRUPO'
                        };
                        btnAgregar.show();
                        btnGuardar.hide();
                        formularioGrupo(datos);
                    }
                }
            },
            columns: [{
                field: 'id',
                title: 'ID Grupo',
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
                visible: true
            },{
                field: 'grupo',
                title: 'Grupo',
                sortable: true,
                visible: true
            },{
                field:'opciones',
                title:'Opciones',
                align:'center',
                valing: 'middle',
                clickToSelect:false,
                events: {
                    'click .editarMateria': function (e, value, row, index) {
                        var datos;
                        datos = {
                            idGrupo: row.id,
                            idMateria: row.materia_id,
                            grupo: row.grupo,
                            sigla: row.sigla,
                            title:'Editar GRUPO'
                        };
                        btnAgregar.hide();
                        btnGuardar.show();
                        formularioGrupo(datos);
                    },
                    'click .eliminarGrupo': function (e, value, row, index) {
                        datos = {
                            id: row.id,
                            '_token': $("meta[name='csrf-token']").attr("content"),
                            '_method': 'DELETE'
                        };
                        eliminarGrupo(datos);
                    }
                },
                formatter: function(value,row,index){
                    var btnOpciones = '<div class="btn-group" data-toggle="buttons"><a href="#" class="editarMateria btn btn-sm" title="Editar grupo"><i class="fas fa-edit text-primary"></i></a><a href="#" class="eliminarGrupo btn btn-sm" title="Eliminar grupo"><i class="fas fa-trash text-danger"></i></a></div>';                
                    return btnOpciones;
                }
            }]
        });

        /* Funcion para recolectar datos del formulario de materias */
        function recolectarGrupo(method){
            datosGrupo = {
                id: txtIdGrupo.val(),
                materia: txtIdMateria.val(),
                grupo: txtGrupo.val(),
                sigla: txtSigla.val(),
                '_token': $("meta[name='csrf-token']").attr("content"),
                '_method': method
            };
            return datosGrupo;
        };
        /* Funcion para abrir el formulario de materias */
        function formularioGrupo(datos){
            $('#errorValidacion').html('');
            tituloForm.html(datos.title)
            txtIdGrupo.val(datos.idGrupo);
            txtIdMateria.val(datos.idMateria);
            txtGrupo.val(datos.grupo);
            txtSigla.val(datos.sigla);
            txtIdMateria.selectpicker('refresh');
            txtGrupo.selectpicker('refresh');
            modificarMaterias.modal('show');
        }
        /* Evento para agregar nueva materia */
        btnAgregar.on('click',function(e){
            e.preventDefault();
            datosGrupo = recolectarGrupo('POST');      
            $.confirm({
                icon: 'fas fa-plus-circle',
                title: 'Crear materia',
                content: '¿Confirma asignar el grupo ' + datosGrupo.grupo + ' a la materia  seleccionada?',
                escapeKey: true,
                backgroundDismiss: true,
                type: 'green',
                buttons: {
                    confirmar:{
                        text:'Confirmar',
                        btnClass: 'btn-success',
                        action: function(){
                            enviarGrupo("",datosGrupo);
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
            datosGrupo = recolectarGrupo('PATCH');  
            $.confirm({
                icon: 'fas fa-edit',
                title: 'Editar materia',
                content: '¿Confirma editar datos de la materia ' + datosGrupo.sigla + '?',
                escapeKey: true,
                backgroundDismiss: true,
                type: 'blue',
                buttons: {
                    confirmar:{
                        text:'Confirmar',
                        btnClass: 'btn-info',
                        action: function(){
                            enviarGrupo("/",datosGrupo);
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
        function eliminarGrupo(datos){
            $.confirm({
                icon: 'fas fa-exclamation-triangle',
                title: '¿Eliminar materia?',
                content: 'Recuerde que una vez eliminado el grupo de la materia no se puede recuperar sus datos.',
                type: 'red',
                buttons: {
                    confirmar: {
                        text:'Confirmar',
                        btnClass: 'btn-danger',
                        action: function () {
                            enviarGrupo("/",datos);
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
        function enviarGrupo(accion,datos){
            $.ajax({
                type:'POST',
                url:"{{ url('/grupo') }}"+accion+datos.id,
                data: datos,
                success: function(msg){
                    if(msg){
                        modificarMaterias.modal('hide');
                        $.alert('Cambios guardados con éxito!');
                        tablaGrupos.bootstrapTable('refresh');            
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