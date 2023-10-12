@extends('adminlte::page')

@section('title', 'Actividades')

@section('content_header')
    <h1>Actividades</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                <!--Sección de botones-->
                <a class="btn btn-sm btn-outline-warning" href="{{ route('actividades.create', $proyecto->id) }}">Nuevo</a>
                <button id="export-copy" class="btn btn-sm btn-outline-secondary buttons-copy" type="button"><span>Copiar</span></button> 
                <button id="export-excel" class="btn btn-sm btn-outline-success buttons-excel" type="button"><span>Exportar</span></button> 
                <button id="export-pdf" class="btn btn-sm btn-outline-danger buttons-pdf" type="button"><span>Exportar</span></button> 
                </h3>
                <p id="id_proyecto" data-id-proyecto="{{ $proyecto->id }}" class="d-none"></p>
            </div>
            <div class="card-body">
                <div id="table_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div class="row">
                    <div class="col-sm-12 card-body table-responsive p-0" style="height: 60vh;">
                    <!--Sección de tabla-->
                    <table id="tabla-actividades" class="table table-bordered table-striped dataTable dtr-inline mt-1 table-head-fixed"></table>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>
    </div>
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
