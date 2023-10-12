@extends('adminlte::page')
@section('title', 'Actividad')
@section('content_header')
<h1 class="text-center">Agregar Actividad</h1>
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
            {!! Form::open(array('route'=>'actividades.store', 'method'=>'POST')) !!}
                {!! Form::text('id_proyecto', $proyecto->id, array('class'=>'form-control d-none')) !!}
                <div class="form-group">
                    <label for="nombre" class="text-secondary">Nombre*</label>
                    {!! Form::text('nombre', null, array('class'=>'form-control')) !!}
                </div>
                <div class="form-group">
                    <label for="prioridad" class="text-secondary">Prioridad*</label>
                    {!! Form::text('prioridad', null, array('class'=>'form-control')) !!}
                </div>
                <div class="form-group">
                    <label for="fecha_inicio" class="text-secondary">Fecha Inicio*</label>
                    {!! Form::date('fecha_inicio', null, array('class'=>'form-control')) !!}
                </div>
                <div class="form-group">
                    <label for="fecha_fin" class="text-secondary">Fecha Fin*</label>
                    {!! Form::date('fecha_fin', null, array('class'=>'form-control')) !!}
                </div>
                <div class="form-group">
                    <label for="id_estado_actividad" class="text-secondary">Estado Actividad*</label>
                    {!! Form::select('id_estado_actividad', $estadosActividad, [], ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="col-lg-6 col-md-12 mb-3"><!-- Columna derecha -->
                <div class="form-group">
                    <label for="responsabilidades" class="text-secondary">Responsabilidades*</label>
                    {!! Form::textarea('responsabilidades', null, array('class'=>'form-control')) !!}
                </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row align-items-center">
                <div class="col-md-6 col-6 text-left">
                    <small>Los campos con (*) son requeridos</small>
                </div>
                <div class="col-md-6 col-6 text-right">
                    <button type="submit" class="btn btn-info">Guardar</button>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
      </div>
    </div>
  </div>
</div>
@stop