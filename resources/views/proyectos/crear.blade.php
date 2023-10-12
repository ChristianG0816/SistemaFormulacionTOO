@extends('adminlte::page')
@section('title', 'Proyecto')
@section('content_header')
<h1 class="text-center">Agregar Proyecto</h1>
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
            {!! Form::open(array('route'=>'proyectos.store', 'method'=>'POST')) !!}
              <div class="form-group">
                <label for="nombre" class="text-secondary">Nombre*</label>
                {!! Form::text('nombre', null, array('class'=>'form-control')) !!}
              </div>
              <div class="form-group">
                <label for="objetivo" class="text-secondary">Objetivo*</label>
                {!! Form::textarea('objetivo', null, array('class' => 'form-control', 'rows' => 1)) !!}
              </div>
              <div class="form-group"><!-- Select -->
                <label for="cliente" class="text-secondary">Cliente*</label>
                {!! Form::text('cliente', null, array('class'=>'form-control')) !!}
              </div>
              <div class="form-group"><!-- Select -->
                <label for="dueno" class="text-secondary">Dueño*</label>
                {!! Form::text('dueno', null, array('class'=>'form-control')) !!}
              </div>
              <div class="form-group">
                <label for="descripcion" class="text-secondary">Descripción*</label>
                {!! Form::textarea('descripcion', null, array('class'=>'form-control', 'rows' => 1)) !!}
              </div>
              <div class="form-group">
                <label for="fecha_inicio" class="text-secondary">Fecha Inicio*</label>
                {!! Form::date('fecha_inicio', null, array('class'=>'form-control')) !!}
              </div>
            </div>
            <div class="col-lg-6 col-md-12 mb-3"><!-- Columna derecha -->
              <div class="form-group">
                <label for="fecha_fin" class="text-secondary">Fecha Fin*</label>
                {!! Form::date('fecha_fin', null, array('class'=>'form-control')) !!}
              </div>
              <div class="form-group"><!-- Número -->
                <label for="presupuesto" class="text-secondary">Presupuesto*</label>
                {!! Form::text('presupuesto', null, array('class'=>'form-control')) !!}
              </div>
              <div class="form-group">
                <label for="prioridad" class="text-secondary">Prioridad*</label>
                {!! Form::text('prioridad', null, array('class'=>'form-control')) !!}
              </div>
              <div class="form-group">
                <label for="entregable" class="text-secondary">Entregable*</label>
                {!! Form::text('entregable', null, array('class'=>'form-control')) !!}
              </div>
              <div class="form-group"><!-- Select -->
                <label for="estado" class="text-secondary">Estado*</label>
                {!! Form::text('estado', null, array('class'=>'form-control')) !!}
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
</div>
@stop