@extends('adminlte::page')
@section('title', 'Actividad')
@section('content_header')
<h1 class="text-center">Editar Actividad</h1>
@stop
@section('content')
<div class="row justify-content-center">
  <div class="col-md-8">
    <div class="card">
      <div class="card-body">
        <div id="table_wrapper" class="wrapper dt-bootstrap4">
          <div class="row">
            <div class="col-lg-6 col-md-12 mb-3"><!-- Columna izquierda -->
            {!! Form::model($actividad, ['method'=>'PATCH', 'route' => ['actividades.update', $actividad->id]]) !!}
                {!! Form::text('id_proyecto', $actividad->id_proyecto, array('class'=>'form-control d-none')) !!}
                <div class="form-group">
                    <label for="nombre" class="text-secondary">Nombre*</label>
                    {!! Form::text('nombre', null, [
                        'class' => 'form-control' . ($errors->has('nombre') ? ' is-invalid' : ''),
                    ]) !!}
                    @error('nombre')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="prioridad" class="text-secondary">Prioridad*</label>
                    {!! Form::select('prioridad', $prioridades, null, [
                        'class' => 'form-control' . ($errors->has('prioridad') ? ' is-invalid' : ''),
                    ]) !!}
                    @error('prioridad')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="fecha_inicio" class="text-secondary">Fecha Inicio*</label>
                    {!! Form::date('fecha_inicio', null, [
                        'class' => 'form-control' . ($errors->has('fecha_inicio') ? ' is-invalid' : ''),
                    ]) !!}
                    @error('fecha_inicio')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="fecha_fin" class="text-secondary">Fecha Fin*</label>
                    {!! Form::date('fecha_fin', null, [
                        'class' => 'form-control' . ($errors->has('fecha_fin') ? ' is-invalid' : ''),
                    ]) !!}
                    @error('fecha_fin')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="id_estado_actividad" class="text-secondary">Estado Actividad*</label>
                    {!! Form::select('id_estado_actividad', $estadosActividad, null, [
                        'class' => 'form-control' . ($errors->has('id_estado_actividad') ? ' is-invalid' : ''),
                    ]) !!}
                    @error('id_estado_actividad')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-6 col-md-12 mb-3"><!-- Columna derecha -->
                <div class="form-group">
                    <label for="id_responsable" class="text-secondary">Responsable*</label>
                    {!! Form::select('id_responsable', $miembrosEquipoTrabajo, null, [
                        'class' => 'form-control' . ($errors->has('id_responsable') ? ' is-invalid' : ''),
                    ]) !!}
                    @error('id_responsable')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
              <div class="form-group">
                  <label for="responsabilidades" class="text-secondary">Responsabilidades*</label>
                  {!! Form::textarea('responsabilidades', null, [
                      'class' => 'form-control' . ($errors->has('responsabilidades') ? ' is-invalid' : ''),
                  ]) !!}
                  @error('responsabilidades')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
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