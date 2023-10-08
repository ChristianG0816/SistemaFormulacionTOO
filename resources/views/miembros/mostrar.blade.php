@extends('adminlte::page')

@section('title', 'Mano Obra')

@section('content_header')
    <div class="container">
        <div class="row col-xs-12 col-sm-12 col-md-12">
            <h1 class="text-blue">Mano Obra</h1>
        </div>
    </div>
@stop

@section('content')
    @if ($errors->any())
        <div class="alert alert-dark alert-dismissible fade show" role="alert">
            <strong>Revise los campos</strong>
            @foreach ($errors->all() as $error)
                <span class="badge badge-danger">{{$error}}</span>
            @endforeach
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="container pb-5">
        <div class="row col-xs-12 col-sm-12 col-md-12">
            <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                    <label for="name">Nombre</label>
                    {!! Form::text('name', $manoObraUser->name, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                </div>
                <div class="form-group">
                    <label for="name">Apellido</label>
                    {!! Form::text('last_name', $manoObraUser->last_name, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                </div>
                <div class="form-group">
                    <label for="dui">DUI</label>
                    {!! Form::text('dui', $manoObraUser->dui, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                </div>
                <div class="form-group">
                    <label for="afp">AFP</label>
                    {!! Form::text('afp', $manoObraUser->afp, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                </div>
                <div class="form-group">
                    <label for="isss">ISSS</label>
                    {!! Form::text('isss', $manoObraUser->isss, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                </div>
                <div class="form-group">
                    <label for="pasaporte">Pasaporte</label>
                    {!! Form::text('pasaporte', $manoObraUser->pasaporte, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                </div>
                <div class="form-group">
                    <label for="">Sexo</label>
                    {!! Form::text('sexo', $manoObraUser->sexo, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                </div>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                    <label for="profesion">Profesión</label>
                    {!! Form::text('profesion', $manoObraUser->profesion, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                </div>
                <div class="form-group">
                    <label for="costo_servicio">Costo Servicio</label>
                    {!! Form::text('costo_servicio', $manoObraUser->costo_servicio, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                </div>
                <div class="form-group">
                    <label for="nacionalidad">Nacionalidad</label>
                    {!! Form::text('nacionalidad', $manoObraUser->nacionalidad, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                </div>
                <div class="form-group">
                    <label for="telefono">Teléfono</label>
                    {!! Form::text('telefono', $manoObraUser->telefono, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                </div>
                <div class="form-group">
                    <label for="estado_civil">Estado Civil</label>
                    {!! Form::text('estado_civil', $manoObraUser->estado_civil, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                </div>
                <div class="form-group">
                    <label for="fecha_nacimiento">Fecha Nacimiento</label>
                    {!! Form::date('fecha_nacimiento', $manoObraUser->fecha_nacimiento, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                </div>
            </div>
        </div>
    </div>
@stop
