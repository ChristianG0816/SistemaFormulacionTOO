@extends('adminlte::page')

@section('title', 'Recursos')

@section('content_header')
    <h1>Recursos</h1>
@stop

@section('content')
    <a class="btn btn-sm btn-outline-warning" href="{{route('recursos.create')}}">Nuevo</a>
    <button id="export-copy" class="btn btn-sm btn-outline-secondary buttons-copy" type="button"><span>Copiar</span></button> 
    <button id="export-excel" class="btn btn-sm btn-outline-success buttons-excel" type="button"><span>Exportar</span></button> 
    <button id="export-pdf" class="btn btn-sm btn-outline-danger buttons-pdf" type="button"><span>Exportar</span></button> 

    <table id="tabla-recursos" class="table table-striped mt-2">
        <thread style="background-color: #6777ef;">
            <th>Nombre</th>
            <th>Disponibilidad</th>
            <th>Costo</th>
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
    <script src="{{ asset('js/recursos/recursos.js') }}"></script>
@stop