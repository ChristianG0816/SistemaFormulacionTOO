@extends('adminlte::page')

@section('title', 'Actividades')

@section('content_header')
    <h1>Actividades</h1>
@stop

@section('content')
    <a class="btn btn-outline-warning btn-sm" href="{{ route('actividades.create', $proyecto->id) }}">Nuevo</a>
    <button id="export-copy" class="btn btn-sm btn-outline-secondary buttons-copy" type="button"><span>Copiar</span></button> 
    <button id="export-excel" class="btn btn-sm btn-outline-success buttons-excel" type="button"><span>Exportar</span></button> 
    <button id="export-pdf" class="btn btn-sm btn-outline-danger buttons-pdf" type="button"><span>Exportar</span></button> 
    <p id="id_proyecto" data-id-proyecto="{{ $proyecto->id }}" class="d-none"></p>

    <table id="tabla-actividades" class="table table-striped mt-2">
        <thread style="background-color: #6777ef;">
            <th>Nombre</th>
            <th>Prioridad</th>
            <th>Fecha Inicio</th>
            <th>Fecha Fin</th>
            <th>Responsabilidades</th>
            <th>Estado Actividad</th>
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
                    <button id="eliminarActividadBtn" class="btn btn-outline-danger btn-sm">Eliminar</button>
                    <button type="button" class="btn btn-outline-dark btn-sm" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>                 
    <!-- /.Modal de eliminar -->
@stop

@section('js')
    <script src="{{ asset('js/actividades/actividades.js') }}"></script>
@stop
