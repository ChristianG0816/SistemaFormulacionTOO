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
    <div class="col-md-12">
        <div class="card" id="contenedor-informacion">
        <div class="card-body justify-content-center d-flex pl-0 pr-0">
            <div  class="row d-flex col-lg-12 col-md-12">
                <div id="informacion-actividad" class="col-lg-9 col-md-9 table-responsive" style="height: 80vh;">
                    <div id="table_wrapper" class="wrapper dt-bootstrap4">
                        <!--Sección de información de la actividad-->
                        {!! Form::model($actividad, ['method' => 'PATCH', 'route' => ['actividades.actualizar', $actividad->id], 'id' => 'actividad-form-actualizar']) !!}
                        <div id="informacion-actividad-modal" class="row">
                            <div class="col-lg-6 col-md-6 mb-3"><!-- Columna izquierda -->
                                <input type="hidden" id="id_proyecto" name="id_proyecto" value="{{$actividad->id_proyecto}}">
                                <input type="hidden" id="id_actividad" name="id_actividad" value="{{$actividad->id}}">
                                <input type="hidden" id="id_responsable" name="id_responsable" value="{{$actividad->id_responsable}}">
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
                                @if ($proyecto->estado_proyecto->nombre == 'Iniciado' && $userRole == 'Colaborador')
                                <div class="form-group">
                                    <label for="id_estado_actividad" class="text-secondary">Estado Actividad</label>
                                    {!! Form::select('id_estado_actividad', $estadosActividad,  $actividad->id_estado_actividad, [
                                        'class' => 'form-control' . ($errors->has('id_estado_actividad') ? ' is-invalid' : ''), 'id' => 'select-estado-actividad',
                                    ]) !!}
                                </div>
                                @else
                                <div class="form-group">
                                    <label for="id_estado_actividad" class="text-secondary">Estado Actividad</label>
                                    {!! Form::text('estado_actividad',  $actividad->estado_actividad->nombre, ['class' => 'form-control' , 'readonly' => 'readonly']) !!}
                                </div>
                                @endif
                            </div>
                            <div class="col-lg-6 col-md-6 mb-3"><!-- Columna derecha -->
                                <div class="form-group">
                                    <label for="id_responsable" class="text-secondary">Responsable</label>
                                    {!! Form::text('responsable', $actividad->responsable->mano_obra->usuario->name .' ' .$actividad->responsable->mano_obra->usuario->last_name, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                                </div>
                                <div class="form-group">
                                    <label for="responsabilidades" class="text-secondary">Responsabilidades</label>
                                    {!! Form::textarea('responsabilidades', $actividad->responsabilidades, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                        <div id="group-boton-guardar" class="form-group" style="display:none;">
                            <div class="row align-items-center">
                                <div class="col-md-12 col-12 text-right">
                                    <button id="boton-editar-actividad" type="submit" class="btn btn-info">Guardar</button>
                                </div>
                            </div>
                        </div>
                        @include('recursos.asignar')
                    </div>
                </div>
                <!--Sección de comentarios-->
                @can('gestionar-comentario')
                <div class="col col-lg-3">
                    <div class="card" style="height: 100%; background-color: #EBF5FB;">
                        <div class="col-lg-12 card-body" style="z-index: 2; position: relative;">
                            <div id="titulo-encabezado-comentario" class="card border-0 shadow-none rounded-0 p-0 m-0 collapsed-card" style="z-index: 2; position: absolute; width:92%; background-color: #EBF5FB;">
                                <div class="card-header border-0 m-0 p-0 w-100" style="background-color: #EBF5FB;">
                                    <div class="d-flex align-items-center m-1">
                                        <h5 class="text-center font-weight-bold">Comentarios</h5>
                                        @if ($proyecto->estado_proyecto->nombre == 'Iniciado')
                                        @can('crear-comentario')
                                        <a type="button" class="btn btn-tool ml-auto" data-card-widget="collapse" title="Collapse">
                                            <i id="icono-boton-comentario" class="fas fa-plus"></i>
                                        </a>
                                        @endcan
                                        @endif
                                    </div>
                                </div>
                                @if ($proyecto->estado_proyecto->nombre == 'Iniciado')
                                @can('crear-comentario')
                                <div id="formulario-comentario" class="card-body border-0 m-0 p-0 pr-1" style="display: none;">
                                    <div class="card bg-white">
                                        <div class="card-body">
                                            {!! Form::open(['route' => 'comentarios.store', 'method' => 'POST', 'id' => 'comentario-form-agregar']) !!}
                                                {!! Form::text('id_actividad_comentario', $actividad->id, ['class' => 'form-control d-none']) !!}
                                                {!! Form::textarea('linea_comentario_comentario', null, ['id' => 'linea_comentario_comentario', 'class' => 'form-control', 'rows' => 3]) !!}
                                                <p class="text-right m-0 mt-2">
                                                    <a href="#" id="enviar-formulario" class="text-warning ml-auto">Agregar</a>
                                                </p>
                                            {!! Form::close() !!}
                                        </div>
                                    </div>
                                </div>
                                @endcan
                                @endif
                            </div>
                            <div id="lista-comentarios" class="table-responsive" style="max-height: 70vh; margin-top:45px;">
                                @foreach ($comentarios as $comentario)
                                    <div class="card bg-white mr-1">
                                        <div class="card-body pb-0">
                                            <p class="font-weight-bold text-secondary m-0">{{ $comentario->usuario->name }} {{ $comentario->usuario->last_name }}</p>
                                            <p id="parrafo-comentario{{$comentario->id}}" class="text-justify text-black mb-3">{{ $comentario->linea_comentario }}</p>
                                            @if ($proyecto->estado_proyecto->nombre == 'Iniciado')
                                            @if ($comentario->usuario->id == $usuario->id)
                                                @can('editar-comentario')
                                                {!! Form::model($comentario, ['method' => 'PATCH', 'route' => ['comentarios.update', $comentario->id], 'id' => 'comentario-form-actualizar' . $comentario->id]) !!}
                                                {!! Form::text('id-actividad-comentario-update'.$comentario->id, $actividad->id, ['class' => 'form-control d-none']) !!}
                                                {!! Form::textarea('linea-comentario-update'.$comentario->id, $comentario->linea_comentario, ['class' => 'form-control', 'rows' => 3, 'style' => 'display: none;', 'id' => 'linea-comentario'.$comentario->id]) !!}
                                                {!! Form::close() !!}
                                                @endcan
                                                <p class="text-right m-0 p-0 pb-2">
                                                    @can('editar-comentario')
                                                    <a href="#" id="edi{{ $comentario->id }}" class="text-info"  data-comentario-id-editar="{{ $comentario->id }}">Editar</a>
                                                    @endcan
                                                    @can('editar-comentario')
                                                    <a href="#" id="upd{{ $comentario->id }}" class="text-warning"  data-comentario-id-actualizar="{{ $comentario->id }}" style="display:none">Guardar</a>
                                                    @endcan
                                                    @can('borrar-comentario')
                                                    <a href="#" id="del{{ $comentario->id }}" class="text-danger pl-2" data-comentario-id-eliminar="{{ $comentario->id }}">Eliminar</a>
                                                    @endcan
                                                    @can('editar-comentario')
                                                    <a href="#" id="cal{{ $comentario->id }}" class="text-dark pl-2" data-comentario-id-cancelar="{{ $comentario->id }}" style="display:none">Cancelar</a>
                                                    @endcan
                                                    @can('borrar-comentario')
                                                    {!! Form::open(['route' => ['comentarios.destroy', $comentario->id], 'method' => 'DELETE', 'id' => 'comentario-form-eliminar' . $comentario->id]) !!}
                                                    {!! Form::hidden('_token', csrf_token()) !!}
                                                    {!! Form::close() !!}
                                                    @endcan
                                                </p>
                                            @endif
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @endcan
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
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
    var actividadId = {{ $actividad->id }};
    var proyectoId = {{$actividad->id_proyecto}};
    var csrfToken = '{{ csrf_token() }}';
    </script>
    <script src="{{ asset('js/actividades/actividad.js') }}"></script>
    <script src="{{ asset('js/actividades/comentarios.js') }}"></script>
    <script src="{{ asset('js/recursos/recursosAsignados.js') }}"></script>
@stop