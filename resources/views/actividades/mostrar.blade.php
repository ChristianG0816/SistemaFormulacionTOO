@extends('adminlte::page')

@section('title', 'Actividad')

@section('content_header')
    <div class="container">
        <div class="row col-xs-12 col-sm-12 col-md-12">
            <h1 class="text-blue">Actividad</h1>
        </div>
    </div>
@stop

@section('content')
    @if ($errors->any())
    <div class="container">
        <div class="row col-xs-12 col-sm-12 col-md-12">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="alert alert-dark alert-dismissible fade show" role="alert">
                    <strong>Revise los campos</strong>
                    @foreach ($errors->all() as $error)
                        <span class="badge badge-danger">{{$error}}</span>
                    @endforeach
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="container pb-5">
        <div class="row col-xs-12 col-sm-12 col-md-12">
            <div class="col-xs-6 col-sm-6 col-md-6">
                {!! Form::text('id_proyecto', $actividad->id_proyecto, ['class' => 'form-control d-none', 'readonly' => 'readonly']) !!}
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    {!! Form::text('nombre', $actividad->nombre, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                </div>
                <div class="form-group">
                    <label for="fecha_inicio">Fecha Inicio</label>
                    {!! Form::date('fecha_inicio', $actividad->fecha_inicio, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                </div>
                <div class="form-group">
                    <label for="fecha_fin">Fecha Fin</label>
                    {!! Form::date('fecha_fin', $actividad->fecha_fin, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                </div>
                <div class="form-group">
                    <label for="prioridad">Prioridad</label>
                    {!! Form::text('prioridad', $actividad->prioridad, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                </div>
                <div class="form-group">
                    <label for="id_estado_actividad">Estado Actividad</label>
                    {!! Form::text('id_estado_actividad', $actividad->estado_actividad->nombre, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                </div>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                    <label for="responsabilidades">Responsabilidades</label>
                    {!! Form::textarea('responsabilidades', $actividad->responsibilidades, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                </div>
            </div>
        </div>
    </div>

    <!-- Seccion para agregar mano de obra a las actividades -->
<div class="container">    
    <div class="row">
        <div class="col-md-12">
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">Mano de obra</h3>
                    <div class="card-tools">
                        <input type="button" value="Agregar" class="btn btn-sm btn-success my-0" data-toggle="modal" data-target="#agregarMiembroModal">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            
                        </div>
                    </div>
                    <table id="tableMiembrosActividad" class="table">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Correo</th>
                                <th>Costo por Servicio</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
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

@section('css')
    <!-- <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css"> -->
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
@stop

@section('js')
    <!-- <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script> -->
    <script src="//cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        var csrfToken = '{{ csrf_token() }}';
        var actividadId = {{ $actividad->id }};
    </script>
    <script src="{{ asset('js/miembrosActividad/main.js') }}"></script>
@stop