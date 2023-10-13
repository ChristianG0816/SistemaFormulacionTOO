@extends('adminlte::page')
@section('title', 'Mano Obra')
@section('content_header')
<h1 class="text-center">Agregar Miembro</h1>
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
            {!! Form::open(array('route'=>'miembros.store', 'method'=>'POST')) !!}
                <h4 class="text-secondary">Información de la Mano Obra*</h4>
                <div class="form-group">
                    <label for="dui" class="text-secondary">DUI*</label>
                    {!! Form::text('dui', null, array('class'=>'form-control')) !!}
                </div>
                <div class="form-group">
                    <label for="afp" class="text-secondary">AFP*</label>
                    {!! Form::text('afp', null, array('class'=>'form-control')) !!}
                </div>
                <div class="form-group">
                    <label for="isss" class="text-secondary">ISSS*</label>
                    {!! Form::text('isss', null, array('class'=>'form-control')) !!}
                </div>
                <div class="form-group">
                    <label for="nacionalidad" class="text-secondary">Nacionalidad*</label>
                    {!! Form::text('nacionalidad', null, array('class'=>'form-control')) !!}
                </div>
                <div class="form-group">
                    <label for="pasaporte" class="text-secondary">Pasaporte*</label>
                    {!! Form::text('pasaporte', null, array('class'=>'form-control')) !!}
                </div>
                <div class="form-group">
                    <label for="telefono" class="text-secondary">Teléfono*</label>
                    {!! Form::text('telefono', null, array('class'=>'form-control')) !!}
                </div>
                <div class="form-group">
                    <label for="profesion" class="text-secondary">Profesión*</label>
                    {!! Form::text('profesion', null, array('class'=>'form-control')) !!}
                </div>
                <div class="form-group">
                    <label for="estado_civil" class="text-secondary">Estado Civil*</label>
                    {!! Form::text('estado_civil', null, array('class'=>'form-control')) !!}
                </div>
                <div class="form-group">
                    <label for="sexo" class="text-secondary">Sexo*</label>
                    {!! Form::select('sexo', $sexos, [], ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    <label for="fecha_nacimiento" class="text-secondary">Fecha Nacimiento*</label>
                    {!! Form::date('fecha_nacimiento', null, array('class'=>'form-control')) !!}
                </div>
                <div class="form-group">
                    <label for="costo_servicio" class="text-secondary">Costo Servicio*</label>
                    {!! Form::text('costo_servicio', null, array('class'=>'form-control')) !!}
                </div>
            </div>
            <div class="col-lg-6 col-md-12 mb-3"><!-- Columna derecha -->
                <h4 class="text-secondary">Usuario de la Mano Obra*</h4>
                <div class="form-group">
                    <label for="name" class="text-secondary">Nombre*</label>
                    {!! Form::text('name', null, array('class'=>'form-control')) !!}
                </div>
                <div class="form-group">
                    <label for="name" class="text-secondary">Apellido*</label>
                    {!! Form::text('last_name', null, array('class'=>'form-control')) !!}
                </div>
                <div class="form-group">
                    <label for="email" class="text-secondary">Correo*</label>
                    {!! Form::text('email', null, array('class'=>'form-control')) !!}
                </div>
                <div class="form-group">
                    <label for="password" class="text-secondary">Contraseña*</label>
                    {!! Form::password('password', array('class'=>'form-control')) !!}
                </div>
                <div class="form-group">
                    <label for="confirm-password" class="text-secondary">Confirmar Contraseña*</label>
                    {!! Form::password('confirm-password', array('class'=>'form-control')) !!}
                </div>
                <div class="form-group">
                    <label for="roles" class="text-secondary">Roles*</label>
                    {!! Form::select('roles[]', $roles, [], array('class' => 'form-control')) !!}
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