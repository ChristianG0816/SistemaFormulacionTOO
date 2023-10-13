@extends('adminlte::page')
@section('title', 'Editar Proyecto')
@section('content_header')
<h1 class="text-center">Editar Proyecto</h1>
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
            {!! Form::model($proyecto, ['method'=>'PATCH', 'route' => ['proyectos.update', $proyecto->id]]) !!}
              <input type="hidden" name="origin" value="{{ request('origin') }}">
              <div class="form-group">
                <label for="nombre" class="text-secondary">Nombre*</label>
                {!! Form::text('nombre', null, array('class'=>'form-control', 'maxlength' => 255)) !!}
              </div>
              <div class="form-group">
                <label for="objetivo" class="text-secondary">Objetivo*</label>
                {!! Form::textarea('objetivo', null, array('class' => 'form-control', 'maxlength' => 255, 'rows' => 1)) !!}
              </div>
              <div class="form-group">
                <label for="id_cliente" class="text-secondary">Cliente*</label>
                {!! Form::select('id_cliente', $clientes, null, array('class'=>'form-control')) !!}
              </div>
              <div class="form-group">
                <label for="id_dueno" class="text-secondary">Dueño*</label>
                {!! Form::select('id_dueno', $duenos, null, array('class'=>'form-control')) !!}
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
              <div class="form-group">
                <label for="presupuesto" class="text-secondary">Presupuesto*</label>
                {!! Form::number('presupuesto', null, ['class' => 'form-control', 'step' => '0.01', 'min' => '0', 'id' => 'presupuesto']) !!}
              </div>
              <div class="form-group">
                <label for="prioridad" class="text-secondary">Prioridad*</label>
                {!! Form::select('prioridad', $prioridades,[], array('class'=>'form-control')) !!}
              </div>
              <div class="form-group">
                <label for="entregable" class="text-secondary">Entregable*</label>
                {!! Form::text('entregable', null, array('class'=>'form-control', 'maxlength' => 250)) !!}
              </div>
              <div class="form-group">
                <label for="id_estado_proyecto" class="text-secondary">Estado*</label>
                {!! Form::select('id_estado_proyecto', $estados, $proyecto->estado_proyecto->nombre,  ['class' => 'form-control']) !!}
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