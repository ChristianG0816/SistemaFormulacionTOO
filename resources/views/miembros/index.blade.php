@extends('adminlte::page')

@section('title', 'Mano Obra')

@section('content_header')
    <h1>Mano Obra</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                <!--Sección de botones-->
                @can('crear-miembro')
                <a class="btn btn-sm btn-outline-warning" href="{{route('miembros.create')}}">Nuevo</a>
                @endcan
                @can('exportar-miembro')
                <button id="export-copy" class="btn btn-sm btn-outline-secondary buttons-copy" type="button"><span>Copiar</span></button> 
                <button id="export-excel" class="btn btn-sm btn-outline-success buttons-excel" type="button"><span>Exportar</span></button> 
                <button id="export-pdf" class="btn btn-sm btn-outline-danger buttons-pdf" type="button"><span>Exportar</span></button>
                @endcan 
                </h3>
            </div>
            <div class="card-body">
                <div id="table_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div class="row">
                    <div class="col-sm-12 card-body table-responsive p-0" style="height: 60vh;">
                    <!--Sección de tabla-->
                    <table id="tabla-miembros" class="table table-bordered table-striped dataTable dtr-inline mt-1 table-head-fixed"></table>
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
                    <strong>¿Estás seguro de eliminar el miembro seleccionado?</strong>
                    <p>Ten en cuenta que se eliminarán los datos relacionados al miembro.</p>
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
@php
    $permisos = [
        'ver-miembro' => auth()->user()->can('ver-miembro'),
        'editar-miembro' => auth()->user()->can('editar-miembro'),
        'borrar-miembro' => auth()->user()->can('borrar-miembro'),
    ];
@endphp
@section('js')
    <script>
        var permisos = @json($permisos);
    </script>
    <script>
    jQuery.noConflict();
    (function($) {      
        toastr.options = {"closeButton": true, "progressBar": true}
        @if (Session::has('success'))
        toastr.success("{{ session('success') }}");
        @endif

        @if (Session::has('error'))
        toastr.error("{{ session('error') }}");
        @endif
    })(jQuery);
    </script>
    <script src="{{ asset('js/miembros/miembros.js') }}"></script>
@stop
