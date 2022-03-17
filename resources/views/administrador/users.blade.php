@extends('adminlte::page')

@section('title', 'Organizador ETN')

@section('plugins.bootstrap-table',true)

@section('content_header')
<!-- Panel de tabla de usuarios -->
<div class="d-flex justify-content-start">
    <div class="lead font-weight-bold">ADMINISTRACIÓN USUARIOS</div>      
</div>
<div class="table-responsive"> 
    <table class='table table-striped table-bordered' id='tablaUsuarios'></table>
</div>
@stop
@section('content')
<!-- Modal para detalles de los usuarios -->
<div class="modal fade" id="modificarUsuarios" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <div class="modal-title text-white">
                <div class="lead" id="tituloForm">Datos Usuario</div>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="#" autocomplete="off">
                    <div class="text-danger" role="alert">
                        <ul id="errorValidacion" class="list-group-item-danger">
                        </ul>
                    </div>
                    <input type="hidden" id="txtIdUsuario" name="txtIdUsuario">
                    <div class="form-row">
                        <div class="col-12 col-md-6">
                            <div class="form-row mb-2">
                                <label for="txtApPaterno" class="col-sm-5 col-form-label">Ap Paterno:</label>
                                <div class='col-sm-7'>
                                    <input type="text" id="txtApPaterno" name="txtApPaterno" class="form-control" autocomplete="off" required>
                                </div> 
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-row mb-2">
                                <label for="txtApMaterno" class="col-sm-5 col-form-label">Ap Materno:</label>
                                <div class='col-sm-7'>
                                    <input type="text" id="txtApMaterno" name="txtApMaterno" class="form-control" autocomplete="off" required>
                                </div> 
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-12 col-md-6">
                            <div class="form-row mb-2">
                                <label for="txtNombres" class="col-sm-5 col-form-label">Nombres:</label>
                                <div class='col-sm-7'>
                                    <input type="text" id="txtNombres" name='txtNombres' class="form-control" autocomplete="off" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-row mb-2">
                                <label for="txtCI" class="col-sm-3 col-form-label">CI:</label>
                                <div class='col-sm-9'>
                                    <input type="text" id="txtCI" name='txtCI' class="form-control" autocomplete="off" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-12 col-md-6">
                            <div class="form-row mb-2">
                                <label for="txtRU" class="col-sm-3 col-form-label">RU:</label>
                                <div class='col-sm-9'>
                                    <input type="text" id="txtRU" name='txtRU' class="form-control" autocomplete="off" required>
                                </div> 
                            </div>   
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-row mb-2">
                                <label for="txtIdNivel" class="col-sm-3 col-form-label">Nivel:</label>
                                <div class='col-sm-9'>
                                <select name='txtIdNivel' id='txtIdNivel' class="selectpicker form-control show-tick" required>
                                    <option value="">Elegir nivel</option>
                                    @foreach($roles as $valor)
                                        <option value="{{ $valor->id }}">{{ $valor->name }}</option>
                                    @endforeach 
                                </select> 
                                </div> 
                            </div>  
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-12 col-sm-6">
                            <div class="form-row mb-2">
                                <label for="txtIdEstadoUsuario" class="col-sm-4 col-form-label">Estado:</label>
                                <div class='col-sm-8'>
                                <select name='estado_id' id='txtIdEstadoUsuario' class="selectpicker form-control show-tick" required>
                                    @foreach($estados as $valor)
                                        <option value="{{ $valor->id }}">{{ $valor->estado }}</option>
                                    @endforeach 
                                </select>
                                </div>
                            </div> 
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-row mb-2">
                                <label for="txtIdTitulo" class="col-sm-3 col-form-label">Título:</label>
                                <div class='col-sm-9'>
                                    <select name='titulo_id' id='txtIdTitulo' class="selectpicker form-control show-tick" required>
                                        <option value="">Elegir titulo</option>
                                        @foreach($titulos as $valor)
                                            <option value="{{ $valor->id }}">{{ $valor->titulo }}</option>
                                        @endforeach 
                                    </select> 
                                </div> 
                            </div>
                        </div>
                    </div>
                    <div class="form-row mb-2">
                        <label for="txtEmail" class="col-sm-2 col-form-label">Email:</label>
                        <div class='col-sm-10'>
                            <input type="text" id="txtEmail" name="txtEmail" class="form-control" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="form-row mb-2">
                        <label for="txtContrasena" class="col-sm-3 col-form-label">Contraseña:</label>
                        <div class='col-sm-9'>
                            <input type="text" id="txtContrasena" name="txtContrasena" class="form-control" autocomplete="off" required>
                        </div>
                    </div>
                </form>   
            </div>
            <div class="modal-footer bg-primary">
                <button type='button' class="btn btn-success btn-sm" id='btnAgregar'>Agregar</button>
                <button type="button" class="btn btn-info btn-sm" id='btnGuardar'>Guardar cambios</button>
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal para importar registros -->
<div class="modal fade" id="importarUsuarios" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <div class="modal-title text-white">
                    <div class="lead">Importar USUARIOS</div>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('administrador.importarUsuarios') }}" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    @if(Session::has('message'))
                        <p class="alert alert-default-success">{{ Session::get('message') }}</p>
                    @endif
                    <div class="form-group">
                        <label for="exampleFormControlFile1">Subir archivo (formato_usuarios.xlsx)</label>
                        <input type="file" name="excelUsuarios" id="excelUsuarios" class="form-control-file" id="exampleFormControlFile1" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required>
                    </div>
                </div>
                <div class="modal-footer bg-primary">
                    <a href="{{ route('administrador.plantillaUsuarios') }}" type="button" class="btn btn-info btn-sm">Descargar plantilla&nbsp;&nbsp;<i class="fas fa-download"></i></a>
                    <button class="btn btn-success btn-sm" id="btnImportar">Importar&nbsp;&nbsp;<i class="fas fa-file-excel"></i></button>
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
        /* Selectores que se modificaran para gestionar usuarios */
        var tituloForm = $('#tituloForm');
        var tablaUsuarios = $('#tablaUsuarios');
        var txtIdUsuario = $('#txtIdUsuario');
        var txtNombres = $('#txtNombres');
        var txtApPaterno = $('#txtApPaterno');    
        var txtApMaterno=$('#txtApMaterno');
        var txtIdNivel = $('#txtIdNivel');
        var txtCI = $('#txtCI');
        var txtRU = $('#txtRU');
        var txtEmail =  $('#txtEmail');
        var txtUsuario = $('#txtUsuario');
        var txtContrasena = $('#txtContrasena');
        var txtIdEstadoUsuario = $('#txtIdEstadoUsuario');
        var txtIdTitulo = $('#txtIdTitulo'); 
        var btnAgregar = $('#btnAgregar');
        var btnGuardar = $('#btnGuardar');
        var modificarUsuarios = $('#modificarUsuarios');
        var importarUsuarios = $('#importarUsuarios');
        /* Estructurador de la tabla de usuarios */
        tablaUsuarios.bootstrapTable({
            url:"{{ url('/user/show') }}",
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
            buttonsOrder:['nuevoUsuario' , 'importarUsuarios', 'refresh', 'autoRefresh', 'fullscreen', 'columns'],
            buttons:{           
                nuevoUsuario: {
                    text: 'Nuevo usuario',
                    icon: 'fa-plus',
                    attributes:{title: 'Nuevo usuario'},
                    event: function () { 
                        var datos;
                        datos = {
                            idUsuario: '',
                            nombres: '',
                            apPaterno: '',
                            apMaterno: '',
                            numeroCI: '',
                            registroUniv: '',
                            idNivel: '',
                            email: '',
                            contrasena: '',
                            idEstado: '2',
                            idTitulo: '',
                            title:'Nuevo USUARIO'
                        };
                        btnAgregar.show();
                        btnGuardar.hide();
                        formularioUsuario(datos);
                    }
                },
                importarUsuarios: {
                    text: 'Importar usuarios',
                    icon: 'fa-file-excel',
                    attributes:{title: 'Importar usuarios'},
                    event: function () { 
                        importarUsuarios.modal('show');;
                    }
                }
            },
            columns: [{
                field: 'id',
                title: 'Id',
                sortable: true,
                visible: false
            }, {
                field: 'nombreCompleto',
                title: 'Apellidos y Nombres',
                sortable: true
            }, {
                field: 'numeroCI',
                title: 'CI',
                sortable: true,
                visible: false
            },{
                field: 'registroUniv',
                title: 'RU',
                sortable: true,
                visible: false
            },{
                field: 'nivelUsuario',
                title: 'Nivel',
                sortable: true,
                formatter: function(valor,fila,indice){
                    switch (valor) {
                        case 'Administrador':
                            var colorTexto = '<div class="card text-center m-0 bg-danger">'+valor+'</div>';                        
                            break;                    
                        case 'Docente':
                            var colorTexto = '<div class="card text-center m-0 bg-azul">'+valor+'</div>';                        
                            break;
                        case 'Auxiliar':
                            var colorTexto = '<div class="card text-center m-0 bg-verde">'+valor+'</div>';                       
                            break;
                        case 'Estudiante':
                            var colorTexto = '<div class="card text-center m-0 bg-secondary">'+valor+'</div>';                        
                            break;
                        default:
                            break;
                    }           
                    return colorTexto;
                }
            }, {
                field: 'tituloUsuario',
                title: 'Titulo',
                sortable: true,
                visible: false
            }, {
                field: 'email',
                title: 'Email',
                sortable: true,
                visible: true
            },{
                field: 'estadoUsuario',
                title: 'Estado',
                sortable: false,
                formatter: function(valor,fila,indice){
                    if(valor=='Activo'){
                        var colorTexto = '<div class="text-success font-italic">'+valor+'</div>';
                    }else{
                        var colorTexto = '<div class="text-secondary font-italic">'+valor+'</div>';
                    }                
                    return colorTexto;
                }
            },{
                field:'opciones',
                title:'Opciones',
                align:'center',
                valing: 'middle',
                clickToSelect:false,
                events: {
                    'click .editarUsuario': function (e, value, row, index) {
                        var datos;
                        datos = {
                            idUsuario: row.id,
                            nombres: row.name,
                            apPaterno: row.apPaterno,
                            apMaterno: row.apMaterno,
                            idNivel: row.nivele_id,
                            numeroCI: row.numeroCI,
                            registroUniv: row.registroUniv,
                            email: row.email,
                            contrasena: '',
                            idEstado: row.estado_id,
                            idTitulo: row.titulo_id,
                            title:'Editar USUARIO'
                        };
                        btnAgregar.hide();
                        btnGuardar.show();
                        formularioUsuario(datos);
                    },
                    'click .eliminarUsuario': function (e, value, row, index) {
                        datos = {
                            id: row.id,
                            nombres: row.name,
                            apellido_paterno: row.apPaterno,
                            apellido_materno: row.apMaterno,
                            '_token': $("meta[name='csrf-token']").attr("content"),
                            '_method': 'DELETE'
                        };
                        eliminarUsuario(datos);
                    }
                },
                formatter: function(value,row,index){
                    var btnOpciones = '<div class="btn-group" data-toggle="buttons"><a href="#" class="editarUsuario btn btn-sm" title="Editar usuario" ><i class="fas fa-edit text-primary"></i></a><a href="#" class="eliminarUsuario btn btn-sm" title="Eliminar usuario"><i class="fas fa-trash text-danger"></i></a></div>';                
                    return btnOpciones;
                }
            }]
        });
        /* Funcion para recolectar datos del formulario de usuario */
        function recolectarUsuario(method){
            datosUsuario = {
                id: txtIdUsuario.val(),
                nombres: txtNombres.val(),
                apellido_paterno: txtApPaterno.val(),
                apellido_materno: txtApMaterno.val(),
                CI: txtCI.val(),
                RU: txtRU.val(),
                nivel: txtIdNivel.val(),
                email: txtEmail.val(),
                contraseña: txtContrasena.val(),
                estado: txtIdEstadoUsuario.val(),
                titulo: txtIdTitulo.val(),
                '_token': $("meta[name='csrf-token']").attr("content"),
                '_method': method
            };
            return datosUsuario;
        };
        /* Funcion para abrir el formulario de usuarios */
        function formularioUsuario(datos){
            $('#errorValidacion').html('');
            tituloForm.html(datos.title)
            txtIdUsuario.val(datos.idUsuario);
            txtNombres.val(datos.nombres);
            txtApPaterno.val(datos.apPaterno);
            txtApMaterno.val(datos.apMaterno);
            txtCI.val(datos.numeroCI);
            txtRU.val(datos.registroUniv);
            txtIdNivel.val(datos.idNivel);
            txtEmail.val(datos.email);
            txtContrasena.val(datos.contrasena);
            txtIdEstadoUsuario.val(datos.idEstado);
            txtIdTitulo.val(datos.idTitulo);
            txtIdEstadoUsuario.selectpicker('refresh');
            txtIdNivel.selectpicker('refresh');
            txtIdTitulo.selectpicker('refresh');
            modificarUsuarios.modal('show');
        }
        /* Evento para agregar nuevo usuario */
        btnAgregar.on('click',function(e){
            e.preventDefault();
            datosUsuario = recolectarUsuario('POST');    
            $.confirm({
                icon: 'fas fa-plus-circle',
                title: 'Crear usuario',
                content: '¿Confirma crear el usuario '+datosUsuario.apellido_paterno+' '+datosUsuario.apellido_materno+' '+datosUsuario.nombres+'?',
                escapeKey: true,
                backgroundDismiss: true,
                type: 'green',
                buttons: {
                    confirmar:{
                        text:'Confirmar',
                        btnClass: 'btn-success',
                        action: function(){
                            enviarUsuario("",datosUsuario);
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
        /* Evento para editar usuario */
        btnGuardar.on('click',function(e){
            e.preventDefault();
            datosUsuario = recolectarUsuario('PATCH');
            $.confirm({
                icon: 'fas fa-edit',
                title: 'Editar usuario',
                content: '¿Confirma crear el usuario '+datosUsuario.apellido_paterno+' '+datosUsuario.apellido_materno+' '+datosUsuario.nombres+'?',
                escapeKey: true,
                backgroundDismiss: true,
                type: 'blue',
                buttons: {
                    confirmar:{
                        text:'Confirmar',
                        btnClass: 'btn-info',
                        action: function(){
                            enviarUsuario("/",datosUsuario);
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
        function eliminarUsuario(datos){
            $.confirm({
                icon: 'fas fa-exclamation-triangle',
                title: '¿Eliminar usuario?',
                content: 'Recuerde que una vez eliminado el usuario '+datos.apellido_paterno+' '+datos.apellido_materno+' '+datos.nombres+' no se puede recuperar sus datos.',
                type: 'red',
                buttons: {
                    confirmar: {
                        text:'Confirmar',
                        btnClass: 'btn-danger',
                        action: function () { 
                            enviarUsuario("/",datos);
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
        function enviarUsuario(accion,datos){
            
            $.ajax({
                type:'POST',
                url:"{{ url('/user') }}"+accion+datos.id,
                data: datos,
                success: function(sucess){
                    if(sucess){
                        modificarUsuarios.modal('hide');
                        switch (datos['_method']) {
                            case 'POST':
                                $.alert({
                                    title:false,
                                    content: 'Se creó el usuario '+datos.apellido_paterno+' '+datos.apellido_materno+' '+datos.nombres,
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
                                    content: 'Se guardó los cambios del usuario '+datos.apellido_paterno+' '+datos.apellido_materno+' '+datos.nombres,
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
                                    content: 'Se eliminó el usuario '+datos.apellido_paterno+' '+datos.apellido_materno+' '+datos.nombres,
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
                        tablaUsuarios.bootstrapTable('refresh');
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
                    /* $.alert('No se pudo guardar los datos del usuario!'); */
                }
            });
        }
    });
</script> 
@stop