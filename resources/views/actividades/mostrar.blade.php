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
                <div class="col-lg-9 col-md-9 table-responsive" style="height: 80vh;">
                    <div id="table_wrapper" class="wrapper dt-bootstrap4">
                        <!--Sección de información de la actividad-->
                        <div class="row">
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
                        <!--Sección de mano de obra-->
                        <div class="row">
                            <div class="col-lg-12 col-md-12 mb-3">
                                <div class="card collapsed-card">
                                    <div class="card-header d-flex align-items-center">
                                        <h3 class="card-title">Mano de obra</h3>
                                        <div class="card-tools ml-auto">
                                            <input type="button" value="Agregar" class="btn btn-sm btn-outline-warning my-0" data-toggle="modal" data-target="#agregarMiembroModal">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body" style="display: none;">
                                        <div id="table_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                        <div class="row">
                                            <div class="col-sm-12 card-body table-responsive p-0" style="height: 40vh;">
                                            <table id="tableMiembrosActividad" class="table table-bordered table-striped dataTable dtr-inline mt-1 table-head-fixed w-100"></table>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Mas secciones-->
                        <div class="row">
                            <div class="col-lg-12 col-md-12 mb-3">
                            </div>
                        </div>
                    </div>
                </div>
                <!--Sección de comentarios-->
                <div class="col col-lg-3">
                    <div class="card bg-secondary" style="height: 100%;">
                        <div class="col-lg-12 card-body" style="z-index: 2; position: relative;">
                            <div class="card bg-secondary border-0 shadow-none rounded-0 p-0 m-0 collapsed-card" style="z-index: 2; position: absolute; width:90%">
                                <div class="card-header border-0 m-0 p-0 w-100">
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
                                                {!! Form::textarea('linea_comentario_comentario', null, ['class' => 'form-control', 'rows' => 3]) !!}
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
    <script>
        $(document).ready(function () {
            var $id_actividad_comentario = $("#id_actividad").val();
            $('#enviar-formulario').click(function (e) {
                e.preventDefault();
                var $form = $('#comentario-form-agregar');
                var formData = $form.serialize();
                $.ajax({
                    type: 'POST',
                    data: formData,
                    url: $form.attr('action'),
                    success: function (response) {
                        var textarea = document.querySelector('textarea[name="linea_comentario_comentario"]');
                        textarea.value = '';
                        $.ajax({
                            type: 'GET',
                            url: "/actividades/show/" + $id_actividad_comentario,
                            success: function (response) {
                                var elementoActualizable = $(response).find('#lista-comentarios');
                                $('#lista-comentarios').html(elementoActualizable.html());
                            }
                        });
                    }
                });
            });
            $('#lista-comentarios').on('click', 'a[data-comentario-id-eliminar]', function (e) {
                e.preventDefault();
                var comentarioId = $(this).data('comentario-id-eliminar');
                var $form = $('#comentario-form-eliminar' + comentarioId);
                var formData = $form.serialize();
                $.ajax({
                    type: 'POST',
                    data: formData,
                    url: $form.attr('action'),
                    success: function (response) {
                        $.ajax({
                            type: 'GET',
                            url: "/actividades/show/" + $id_actividad_comentario,
                            success: function (response) {
                                var elementoActualizable = $(response).find('#lista-comentarios');
                                $('#lista-comentarios').html(elementoActualizable.html());
                            }
                        });
                    }
                });
            });
            $('#lista-comentarios').on('click', 'a[data-comentario-id-editar]', function (e) {
                e.preventDefault();
                var comentarioId = $(this).data('comentario-id-editar');
                $("#parrafo-comentario"+comentarioId).hide();
                $("#linea-comentario"+comentarioId).show();
                $("#edi"+comentarioId).hide();
                $("#del"+comentarioId).hide();
                $("#upd"+comentarioId).show();
                $("#cal"+comentarioId).show();
            });
            $('#lista-comentarios').on('click', 'a[data-comentario-id-cancelar]', function (e) {
                e.preventDefault();
                var comentarioId = $(this).data('comentario-id-cancelar');
                $("#parrafo-comentario"+comentarioId).show();
                $("#linea-comentario"+comentarioId).hide();
                $("#edi"+comentarioId).show();
                $("#del"+comentarioId).show();
                $("#upd"+comentarioId).hide();
                $("#cal"+comentarioId).hide();
            });
            $('#lista-comentarios').on('click', 'a[data-comentario-id-actualizar]', function (e) {
                e.preventDefault();
                var comentarioId = $(this).data('comentario-id-actualizar');
                var $form = $('#comentario-form-actualizar' + comentarioId);
                var formData = $form.serialize();
                $.ajax({
                    type: 'POST',
                    data: formData,
                    url: $form.attr('action'),
                    success: function (response) {
                        $.ajax({
                            type: 'GET',
                            url: "/actividades/show/" + $id_actividad_comentario,
                            success: function (response) {
                                var elementoActualizable = $(response).find('#lista-comentarios');
                                $('#lista-comentarios').html(elementoActualizable.html());
                            }
                        });
                    }
                });
            });
            // Función para ajustar la altura de elemento1 a la altura de elemento2
    function ajustarAlturaElemento1() {
      var elemento1 = document.getElementById('columna-derecha');
      var elemento2 = document.getElementById('columna-izquierda');
      elemento1.style.height = elemento2.clientHeight + 'px';
    }

    // Asegúrate de que el código se ejecute después de que el DOM esté completamente cargado
    document.addEventListener('DOMContentLoaded', function() {
      ajustarAlturaElemento1();
    });

    // Escucha el evento de cambio de tamaño de la ventana
    window.addEventListener('resize', ajustarAlturaElemento1);
        });
    </script>
@stop