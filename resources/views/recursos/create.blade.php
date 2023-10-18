@extends('adminlte::page')

@section('title', 'Agregar Recurso')

@section('content_header')
<h1 class="text-center">Agregar Recurso</h1>
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
                {!! Form::open(array('route'=>'recursos.store', 'method'=>'POST')) !!}
                <div class="form-group">
                  <label for="nombre" class="text-secondary">Nombre*</label>
                  {!! Form::text('nombre', null, ['class' => 'form-control' . ($errors->has('nombre') ? ' is-invalid' : ''),'maxlength' => 255]) !!}
                  @error('nombre')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="form-group">
                    <label for="disponibilidad" class="text-secondary">Disponibilidad*</label>
                    {!! Form::number('disponibilidad', null, [
                    'class' => 'form-control' . ($errors->has('disponibilidad') ? ' is-invalid' : ''),
                    'step' => '0.01',
                    'min' => '0',
                    'id' => 'disponibilidad',
                    ]) !!}
                    @error('disponibilidad')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
              </div>
              
              <div class="col-lg-6 col-md-12 mb-3">
                <!-- Columna derecha -->
                <div class="form-group">
                  <label for="costo" class="text-secondary">Costo*</label>
                  {!! Form::number('costo', null, [
                  'class' => 'form-control' . ($errors->has('costo') ? ' is-invalid' : ''),
                  'step' => '0.01',
                  'min' => '0',
                  'id' => 'costo',
                  ]) !!}
                  @error('costo')
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
