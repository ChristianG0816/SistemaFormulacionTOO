@extends('adminlte::page')
@section('title', 'Proyecto')
@section('content_header')
<h1 class="text-center">Agregar Proyecto</h1>
@stop
@section('content')
<div class="row justify-content-center">
  <div class="col-md-8">
    <div class="card">
      <div class="card-body">
        <div id="table_wrapper" class="wrapper dt-bootstrap4">
          <div class="row">
            <div class="col-lg-6 col-md-12 mb-3">
              <!-- Columna izquierda -->
              {!! Form::open(array('route'=>'proyectos.store', 'method'=>'POST')) !!}
              <div class="form-group">
                <label for="nombre" class="text-secondary">Nombre*</label>
                {!! Form::text('nombre', null, ['class' => 'form-control' . ($errors->has('nombre') ? ' is-invalid' : ''),'maxlength' => 255]) !!}
                @error('nombre')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="form-group">
                <label for="objetivo" class="text-secondary">Objetivo*</label>
                {!! Form::textarea('objetivo', null, ['class' => 'form-control' . ($errors->has('objetivo') ? ' is-invalid' : ''),'maxlength' => 255,'rows' => 1]) !!}
                @error('objetivo')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="form-group">
                <label for="id_cliente" class="text-secondary">Cliente*</label>
                {!! Form::select('id_cliente', $clientes, null, ['class' => 'form-control' . ($errors->has('id_cliente') ? ' is-invalid' : '')]) !!}
                @error('id_cliente')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="form-group">
                <label for="id_dueno" class="text-secondary">Dueño*</label>
                {!! Form::select('id_dueno', $duenos, null, ['class' => 'form-control' . ($errors->has('id_dueno') ? ' is-invalid' : '')]) !!}
                @error('id_dueno')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="form-group">
                <label for="descripcion" class="text-secondary">Descripción*</label>
                {!! Form::textarea('descripcion', null, ['class' => 'form-control' . ($errors->has('descripcion') ? ' is-invalid' : ''),'rows' => 1]) !!}
                @error('descripcion')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="form-group">
                <label for="fecha_inicio" class="text-secondary">Fecha Inicio*</label>
                {!! Form::date('fecha_inicio', null, ['class' => 'form-control' . ($errors->has('fecha_inicio') ? ' is-invalid' : '')]) !!}
                @error('fecha_inicio')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <div class="col-lg-6 col-md-12 mb-3">
              <!-- Columna derecha -->
              <div class="form-group">
                <label for="fecha_fin" class="text-secondary">Fecha Fin*</label>
                {!! Form::date('fecha_fin', null, ['class' => 'form-control' . ($errors->has('fecha_fin') ? ' is-invalid' : '')]) !!}
                @error('fecha_fin')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="form-group">
                <label for="presupuesto" class="text-secondary">Presupuesto*</label>
                {!! Form::number('presupuesto', null, [
                'class' => 'form-control' . ($errors->has('presupuesto') ? ' is-invalid' : ''),
                'step' => '0.01',
                'min' => '0',
                'id' => 'presupuesto',
                ]) !!}
                @error('presupuesto')
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
                <label for="entregable" class="text-secondary">Entregable*</label>
                {!! Form::text('entregable', null, [
                'class' => 'form-control' . ($errors->has('entregable') ? ' is-invalid' : ''),
                'maxlength' => 250,
                ]) !!}
                @error('entregable')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="form-group">
                <label for="id_estado_proyecto" class="text-secondary">Estado*</label>
                {!! Form::select('id_estado_proyecto', $estados, null, [
                'class' => 'form-control' . ($errors->has('id_estado_proyecto') ? ' is-invalid' : ''),
                ]) !!}
                @error('id_estado_proyecto')
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
</div>
@stop