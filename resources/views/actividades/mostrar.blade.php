@extends('adminlte::page')
@section('title', 'Actividad')
@section('css')
<style>
@media (max-width: 767px) {
    #lista-comentarios {
        max-height: none !important; /* Quita la propiedad max-height */
        height: 100%; /* Establece la altura al 100% */
        margin-top: 0; /* Modifica el margen superior si es necesario */
    }
    #informacion-actividad {
        height: auto !important; /* Quita la propiedad max-height */
        height: 100%; /* Establece la altura al 100% */
        margin-top: 0; /* Modifica el margen superior si es necesario */
    }
}
</style>
@stop
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
                        <div id="informacion-actividad-modal" class="row">
                            <div class="col-lg-6 col-md-6 mb-3"><!-- Columna izquierda -->
                                <input type="hidden" id="id_proyecto" name="id_proyecto" value="{{$actividad->id_proyecto}}">
                                <input type="hidden" id="id_actividad" name="id_actividad" value="{{$actividad->id}}">
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
                            <div class="col-lg-6 col-md-6 mb-3"><!-- Columna derecha -->
                                <div class="form-group">
                                    <label for="responsabilidades" class="text-secondary">Responsabilidades</label>
                                    {!! Form::textarea('responsabilidades', $actividad->responsabilidades, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                                </div>
                            </div>
                        </div>
                        <!--Sección de tareas-->
                        <div class="row">
                            <div class="col-lg-12 col-md-12 mb-3">
                                <div class="card collapsed-card">
                                    <div class="card-header d-flex align-items-center">
                                        <h3 class="card-title mb-0">Tareas</h3>
                                        <div class="card-tools ml-auto">
                                            <input type="button" value="Agregar" class="btn btn-sm btn-outline-warning my-0" data-toggle="modal" data-target="#agregarTareaModal">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body" style="display: none;">
                                        <div id="table_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                        <div class="row">
                                            <div class="col-sm-12 card-body table-responsive p-0" style="height: 40vh;">
                                            <table id="tabla-tareas" class="table table-bordered table-striped dataTable dtr-inline mt-1 table-head-fixed w-100"></table>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Sección de mano de obra-->
                        @include('miembrosActividad.asignar')
                        <!--Mas secciones-->
                        <div class="row">
                            <div class="col-lg-12 col-md-12 mb-3">
                            </div>
                        </div>
                        {{--  Seccion para asignar mano de obra a las actividades --}}
                        @include('recursos.asignar')
                    </div>
                </div>
                <!--Sección de comentarios-->
                <div class="col col-lg-3">
                    <div class="card" style="height: 100%; background-color: #EBF5FB;">
                        <div class="col-lg-12 card-body" style="z-index: 2; position: relative;">
                            <div class="card border-0 shadow-none rounded-0 p-0 m-0 collapsed-card" style="z-index: 2; position: absolute; width:92%; background-color: #EBF5FB;">
                                <div class="card-header border-0 m-0 p-0 w-100" style="background-color: #EBF5FB;">
                                    <div class="d-flex align-items-center m-1">
                                        <h5 class="text-center font-weight-bold">Comentarios</h5>
                                        <a type="button" class="btn btn-tool ml-auto" data-card-widget="collapse" title="Collapse">
                                            <i class="fas fa-plus"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body border-0 m-0 p-0 pr-1" style="display: none;">
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
                            </div>
                            <div id="lista-comentarios" class="table-responsive" style="max-height: 70vh; margin-top:45px;">
                                @foreach ($comentarios as $comentario)
                                    <div class="card bg-white mr-1">
                                        <div class="card-body pb-0">
                                            <p class="font-weight-bold text-secondary m-0">{{ $comentario->usuario->name }} {{ $comentario->usuario->last_name }}</p>
                                            <p id="parrafo-comentario{{$comentario->id}}" class="text-justify text-black mb-3">{{ $comentario->linea_comentario }}</p>
                                            @if ($comentario->usuario->id == $usuario->id)
                                                {!! Form::model($comentario, ['method' => 'PATCH', 'route' => ['comentarios.update', $comentario->id], 'id' => 'comentario-form-actualizar' . $comentario->id]) !!}
                                                {!! Form::text('id-actividad-comentario-update'.$comentario->id, $actividad->id, ['class' => 'form-control d-none']) !!}
                                                {!! Form::textarea('linea-comentario-update'.$comentario->id, $comentario->linea_comentario, ['class' => 'form-control', 'rows' => 3, 'style' => 'display: none;', 'id' => 'linea-comentario'.$comentario->id]) !!}
                                                {!! Form::close() !!}
                                                <p class="text-right m-0 p-0">
                                                    <a href="#" id="edi{{ $comentario->id }}" class="text-info"  data-comentario-id-editar="{{ $comentario->id }}">Editar</a>
                                                    <a href="#" id="upd{{ $comentario->id }}" class="text-warning"  data-comentario-id-actualizar="{{ $comentario->id }}" style="display:none">Guardar</a>
                                                    <a href="#" id="del{{ $comentario->id }}" class="text-danger pl-2" data-comentario-id-eliminar="{{ $comentario->id }}">Eliminar</a>
                                                    <a href="#" id="cal{{ $comentario->id }}" class="text-dark pl-2" data-comentario-id-cancelar="{{ $comentario->id }}" style="display:none">Cancelar</a>
                                                    {!! Form::open(['route' => ['comentarios.destroy', $comentario->id], 'method' => 'DELETE', 'id' => 'comentario-form-eliminar' . $comentario->id]) !!}
                                                    {!! Form::hidden('_token', csrf_token()) !!}
                                                    {!! Form::close() !!}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


<!-- Modal Agregar Tarea -->
<div class="modal fade" id="agregarTareaModal" tabindex="-1" role="dialog" aria-labelledby="agregarTareaModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar Tarea a la Actividad</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {!! Form::open(['route' => 'tareas.store', 'method' => 'POST', 'id' => 'tarea-form-agregar']) !!}
                {!! Form::text('id-actividad-tarea', $actividad->id, ['class' => 'form-control d-none']) !!}
                <div class="form-group">
                    <label for="nombre" class="text-secondary">Nombre*</label>
                    {!! Form::text('nombre-tarea', null, ['id' => 'nombre-tarea', 'class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    <label for="finalizada" class="text-secondary">Selecciona el estado:*</label>
                    {!! Form::select('finalizada-tarea', $estadosTarea, [], ['id' => 'finalizada-tarea', 'class' => 'form-control']) !!}
                </div>
                
                {!! Form::close() !!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-warning" id="agregarTareaBtn">Agregar</button>
                <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Editar Tarea -->
<div class="modal fade" id="editarTareaModal" tabindex="-1" role="dialog" aria-labelledby="editarTareaModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Tarea de la Actividad</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {!! Form::open(['route' => 'tareas.store', 'method' => 'POST', 'id' => 'tarea-form-editar']) !!}
                {!! Form::text('id-actividad-tarea-editar', $actividad->id, ['class' => 'form-control d-none']) !!}
                <div class="form-group">
                    <label for="nombre" class="text-secondary">Nombre*</label>
                    {!! Form::text('nombre-tarea-editar', null, ['id' => 'nombre-tarea-editar', 'class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    <label for="finalizada" class="text-secondary">Selecciona el estado:*</label>
                    {!! Form::select('finalizada-tarea-editar', $estadosTarea, null, ['id' => 'finalizada-tarea-editar', 'class' => 'form-control']) !!}
                </div>
                {!! Form::close() !!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-warning" id="editarTareaBtn">Guardar</button>
                <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal de eliminar -->
<div class="modal fade" id="confirmarEliminarModalTarea" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Confirmar eliminación</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <strong>¿Estás seguro de eliminar la tarea seleccionada?</strong>
                <p>Ten en cuenta que se eliminarán los datos relacionados a la tarea.</p>
            </div>
            <div class="modal-footer">
                <button id="eliminarTareaBtn" class="btn btn-outline-danger btn-sm">Eliminar</button>
                <button type="button" class="btn btn-outline-dark btn-sm" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>                 
<!-- /.Modal de eliminar -->

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
    <script src="{{ asset('js/miembrosActividad/miembrosActividad.js') }}"></script>
    <script src="{{ asset('js/actividades/comentarios.js') }}"></script>
    <script src="{{ asset('js/actividades/tareas.js') }}"></script>
    <script src="{{ asset('js/recursos/recursosAsignados.js') }}"></script>
@stop