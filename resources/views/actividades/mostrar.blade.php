@extends('adminlte::page')
@section('title', 'Actividad')
@section('content_header')
<h1 class="text-center">Actividad</h1>
@stop
@section('content')
@if ($errors->any())
<div class="container">
    <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Revise los campos</strong>
                @foreach ($errors->all() as $error)
                <span class="text-danger">{{$error}}</span>
                @endforeach
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
    </div>
</div>
@endif
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
        <div class="card-body">
            <div id="table_wrapper" class="wrapper dt-bootstrap4">
                <div class="row">
                    <div class="col-lg-6 col-md-12 mb-3"><!-- Columna izquierda -->
                        {!! Form::text('id_proyecto', $actividad->id_proyecto, ['class' => 'form-control d-none', 'readonly' => 'readonly']) !!}
                        {!! Form::text('id_actividad', $actividad->id, ['class' => 'form-control d-none', 'readonly' => 'readonly']) !!}
                        <div class="form-group">
                            <label for="nombre" class="text-secondary">Nombre</label>
                            {!! Form::text('nombre', $actividad->nombre, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                        </div>
                        <div class="form-group">
                            <label for="prioridad" class="text-secondary">Prioridad</label>
                            {!! Form::text('prioridad', $actividad->prioridad, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                        </div>
                        <div class="form-group">
                            <label for="fecha_inicio" class="text-secondary">Fecha Inicio</label>
                            {!! Form::date('fecha_inicio', $actividad->fecha_inicio, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                        </div>
                        <div class="form-group">
                            <label for="fecha_fin" class="text-secondary">Fecha Fin</label>
                            {!! Form::date('fecha_fin', $actividad->fecha_fin, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                        </div>
                        <div class="form-group">
                            <label for="id_estado_actividad" class="text-secondary">Estado Actividad</label>
                            {!! Form::text('id_estado_actividad', $actividad->estado_actividad->nombre, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 mb-3"><!-- Columna derecha -->
                        <div class="form-group">
                            <label for="responsabilidades" class="text-secondary">Responsabilidades</label>
                            {!! Form::textarea('responsabilidades', $actividad->responsabilidades, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 mb-3">
                        <div class="card">
                            <div class="card-header d-flex align-items-center">
                                <h3 class="card-title">Mano de obra</h3>
                                <div class="card-tools ml-auto">
                                    <input type="button" value="Agregar" class="btn btn-sm btn-outline-warning my-0" data-toggle="modal" data-target="#agregarMiembroModal">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="table_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                <div class="row">
                                    <div class="col-sm-12 card-body table-responsive p-0" style="height: 40vh;">
                                    <!--Sección de tabla-->
                                    <table id="tableMiembrosActividad" class="table table-bordered table-striped dataTable dtr-inline mt-1 table-head-fixed text-nowrap"></table>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Agregar Miembro -->
<div class="modal fade" id="agregarMiembroModal" tabindex="-1" role="dialog" aria-labelledby="agregarMiembroModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="agregarMiembroModalLabel">Agregar Miembro a la Actividad</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="agregarMiembroForm">
                    <div class="form-group">
                        <label for="miembroSelect">Selecciona un miembro:</label>
                        <select class="form-control" id="miembroSelect" name="miembroSelect">
                        </select>
                    </div>
                </form>
                <div id="miembroDetalle">
                    <p><strong>Nombre:</strong> <span id="nombreMiembro"></span></p>
                    <p><strong>Correo:</strong> <span id="correoMiembro"></span></p>
                    <p><strong>Costo por Servicio:</strong> <span id="telefonoMiembro"></span></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="agregarMiembroBtn">Agregar</button>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
    <script src="{{ asset('js/miembrosActividad/main.js') }}"></script>
@stop