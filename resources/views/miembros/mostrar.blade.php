@extends('adminlte::page')
@section('title', 'Mano Obra')
@section('content_header')
<h1 class="text-center">Perfil Miembro</h1>
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
                <div class="form-group">
                    <label for="name" class="text-secondary">Nombre</label>
                    {!! Form::text('name', $manoObraUser->name, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                </div>
                <div class="form-group">
                    <label for="name" class="text-secondary">Apellido</label>
                    {!! Form::text('last_name', $manoObraUser->last_name, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                </div>
                <div class="form-group">
                    <label for="dui" class="text-secondary">DUI</label>
                    {!! Form::text('dui', $manoObraUser->dui, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                </div>
                <div class="form-group">
                    <label for="afp" class="text-secondary">AFP</label>
                    {!! Form::text('afp', $manoObraUser->afp, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                </div>
                <div class="form-group">
                    <label for="isss" class="text-secondary">ISSS</label>
                    {!! Form::text('isss', $manoObraUser->isss, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                </div>
                <div class="form-group">
                    <label for="nacionalidad" class="text-secondary">Nacionalidad</label>
                    {!! Form::text('nacionalidad',$manoObraUser->nacionalidad , ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                </div>
                <div class="form-group">
                    <label for="pasaporte" class="text-secondary">Pasaporte</label>
                    {!! Form::text('pasaporte', $manoObraUser->pasaporte, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                </div>
            </div>
            <div class="col-lg-6 col-md-12 mb-3"><!-- Columna derecha -->
                <div class="form-group">
                    <label for="telefono" class="text-secondary">Teléfono</label>
                    {!! Form::text('telefono', $manoObraUser->telefono, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                </div>
                <div class="form-group">
                    <label for="profesion" class="text-secondary">Profesión</label>
                    {!! Form::text('profesion', $manoObraUser->profesion, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                </div>
                <div class="form-group">
                    <label for="estado_civil" class="text-secondary">Estado Civil</label>
                    {!! Form::text('estado_civil', $manoObraUser->estado_civil, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                </div>
                <div class="form-group">
                    <label for="sexo" class="text-secondary">Sexo</label>
                    {!! Form::text('sexo', $manoObraUser->sexo, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                </div>
                <div class="form-group">
                    <label for="fecha_nacimiento" class="text-secondary">Fecha Nacimiento</label>
                    {!! Form::date('fecha_nacimiento', $manoObraUser->fecha_nacimiento, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                </div>
                <div class="form-group">
                    <label for="costo_servicio" class="text-secondary">Costo Servicio</label>
                    {!! Form::text('costo_servicio', $manoObraUser->costo_servicio, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                </div>
            </div>
          </div>
      </div>
    </div>
  </div>
</div>
@stop