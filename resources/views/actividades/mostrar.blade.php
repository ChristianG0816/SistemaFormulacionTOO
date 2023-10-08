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

    {!! Form::model($actividad, ['method'=>'PATCH', 'route' => ['actividades.update', $actividad->id]]) !!}
    <div class="container pb-5">
        <div class="row col-xs-12 col-sm-12 col-md-12">
            <div class="col-xs-6 col-sm-6 col-md-6">
                {!! Form::text('id_proyecto', $actividad->id_proyecto, ['class' => 'form-control d-none', 'readonly' => 'readonly']) !!}
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    {!! Form::text('nombre', null, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                </div>
                <div class="form-group">
                    <label for="fecha_inicio">Fecha Inicio</label>
                    {!! Form::date('fecha_inicio', null, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                </div>
                <div class="form-group">
                    <label for="fecha_fin">Fecha Fin</label>
                    {!! Form::date('fecha_fin', null, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                </div>
                <div class="form-group">
                    <label for="prioridad">Prioridad</label>
                    {!! Form::text('prioridad', null, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                </div>
                <div class="form-group">
                    <label for="id_estado_actividad">Estado Actividad</label>
                    {!! Form::text('id_estado_actividad', $actividad->estado_actividad->nombre, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                </div>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                    <label for="responsabilidades">Responsabilidades</label>
                    {!! Form::textarea('responsabilidades', null, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop
