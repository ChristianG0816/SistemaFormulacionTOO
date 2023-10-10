@extends('adminlte::page')

@section('title', 'Usuarios')

@section('content_header')
    <h1>Usuarios</h1>
@stop

@section('content')
    <a class="btn btn-sm btn-outline-warning" href="{{route('usuarios.create')}}">Nuevo</a>
    <br>

    <table id="tabla-usuarios" class="table table-striped mt-2">
        <thread style="background-color: #6777ef;">
            <th>Nombre</th>
            <th>Correo</th>
            <th>Rol</th>
            <th>Acciones</th>
        </thread>

        <tbody>
        </tbody>
    </table>

    <!-- Modal de eliminar -->
    <div class="modal fade" id="confirmarEliminarModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Confirmar eliminación</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <strong>¿Estás seguro de eliminar el usuario seleccionado?</strong>
                    <p>Ten en cuenta que se eliminarán los datos relacionados al usuario.</p>
                </div>
                <div class="modal-footer">
                    <button id="eliminarUsuarioBtn" class="btn btn-outline-danger btn-sm">Eliminar</button>
                    <button type="button" class="btn btn-outline-dark btn-sm" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>                 
    <!-- /.Modal de eliminar -->

@stop

@section('js')
    <script src="{{ asset('js/usuarios/usuarios.js') }}"></script>
@stop
