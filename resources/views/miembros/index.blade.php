@extends('adminlte::page')

@section('title', 'Mano Obra')

@section('content_header')
    <h1>Mano Obra</h1>
@stop

@section('content')
    <a class="btn btn-sm btn-outline-warning" href="{{route('miembros.create')}}">Nuevo</a>
    <button id="export-copy" class="btn btn-sm btn-outline-secondary buttons-copy" type="button"><span>Copiar</span></button> 
    <button id="export-excel" class="btn btn-sm btn-outline-success buttons-excel" type="button"><span>Exportar</span></button> 
    <button id="export-pdf" class="btn btn-sm btn-outline-danger buttons-pdf" type="button"><span>Exportar</span></button> 

    <table id="tabla-miembros" class="table table-striped mt-2">
        <thread style="background-color: #6777ef;">
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Profesión</th>
            <th>Costo Servicio</th>
            <th>DUI</th>
            <th>AFP</th>
            <th>ISS</th>
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
                    <strong>¿Estás seguro de eliminar la actividad seleccionada?</strong>
                    <p>Ten en cuenta que se eliminarán los datos relacionados a la actividad.</p>
                </div>
                <div class="modal-footer">
                    <button id="eliminarMiembroBtn" class="btn btn-outline-danger btn-sm">Eliminar</button>
                    <button type="button" class="btn btn-outline-dark btn-sm" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>                 
    <!-- /.Modal de eliminar -->
@stop

@section('js')
    <script src="{{ asset('js/miembros/miembros.js') }}"></script>
@stop
