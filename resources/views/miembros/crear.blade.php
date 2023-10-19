@extends('adminlte::page')
@section('title', 'Mano Obra')
@section('content_header')
<h1 class="text-center">Agregar Miembro</h1>
@stop
@section('content')
<div class="row justify-content-center">
  <div class="col-md-8">
    <div class="card">
      <div class="card-body">
        <div id="table_wrapper" class="wrapper dt-bootstrap4">
          <div class="row">
            <div class="col-lg-6 col-md-12 mb-3"><!-- Columna izquierda -->
                {!! Form::open(['route' => 'miembros.store', 'method' => 'POST']) !!}
                <div class="form-group">
                    <label for="name" class="text-secondary">Nombre*</label>
                    {!! Form::text('name', null, [
                        'class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''),
                    ]) !!}
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="last_name" class="text-secondary">Apellido*</label>
                    {!! Form::text('last_name', null, [
                        'class' => 'form-control' . ($errors->has('last_name') ? ' is-invalid' : ''),
                    ]) !!}
                    @error('last_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="dui" class="text-secondary">DUI*</label>
                    {!! Form::text('dui', null, [
                        'class' => 'form-control' . ($errors->has('dui') ? ' is-invalid' : ''),
                    ]) !!}
                    @error('dui')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="afp" class="text-secondary">AFP*</label>
                    {!! Form::text('afp', null, [
                        'class' => 'form-control' . ($errors->has('afp') ? ' is-invalid' : ''),
                    ]) !!}
                    @error('afp')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="isss" class="text-secondary">ISSS*</label>
                    {!! Form::text('isss', null, [
                        'class' => 'form-control' . ($errors->has('isss') ? ' is-invalid' : ''),
                    ]) !!}
                    @error('isss')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="profesion" class="text-secondary">Profesión*</label>
                    {!! Form::text('profesion', null, [
                        'class' => 'form-control' . ($errors->has('profesion') ? ' is-invalid' : ''),
                    ]) !!}
                    @error('profesion')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="nacionalidad" class="text-secondary">País de Origen*</label>
                    {!! Form::select('id_nacionalidad', $nacionalidades, null, [
                        'class' => 'form-control' . ($errors->has('id_nacionalidad') ? ' is-invalid' : ''), 'id' => 'select-nacionalidad'
                    ]) !!}
                    @error('nacionalidad')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-6 col-md-12 mb-3"><!-- Columna derecha -->
                <div class="form-group">
                    <label for="pasaporte" class="text-secondary">Pasaporte</label>
                    {!! Form::text('pasaporte', null, [
                        'class' => 'form-control' . ($errors->has('pasaporte') ? ' is-invalid' : ''),
                    ]) !!}
                    @error('pasaporte')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="estado_civil" class="text-secondary">Estado Civil*</label>
                    {!! Form::select('estado_civil', $estado_civil, null, [
                        'class' => 'form-control' . ($errors->has('estado_civil') ? ' is-invalid' : ''),
                    ]) !!}
                    @error('estado_civil')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="sexo" class="text-secondary">Sexo*</label>
                    {!! Form::select('sexo', $sexos, null, [
                        'class' => 'form-control' . ($errors->has('sexo') ? ' is-invalid' : ''),
                    ]) !!}
                    @error('sexo')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="costo_servicio" class="text-secondary">Costo Servicio*</label>
                    {!! Form::text('costo_servicio', null, [
                        'class' => 'form-control' . ($errors->has('costo_servicio') ? ' is-invalid' : ''),
                    ]) !!}
                    @error('costo_servicio')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="fecha_nacimiento" class="text-secondary">Fecha Nacimiento*</label>
                    {!! Form::date('fecha_nacimiento', null, [
                        'class' => 'form-control' . ($errors->has('fecha_nacimiento') ? ' is-invalid' : ''),
                    ]) !!}
                    @error('fecha_nacimiento')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="telefono" class="text-secondary">Teléfono*</label>
                    {!! Form::text('telefono', null, [
                        'class' => 'form-control' . ($errors->has('telefono') ? ' is-invalid' : ''),
                    ]) !!}
                    @error('telefono')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email" class="text-secondary">Correo*</label>
                    {!! Form::text('email', null, [
                        'class' => 'form-control' . ($errors->has('email') ? ' is-invalid' : ''),
                    ]) !!}
                    @error('email')
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
@section('js')
    <script>
    jQuery.noConflict();
    (function($) {      
        toastr.options = {"closeButton": true, "progressBar": true}
        @if (Session::has('success'))
        toastr.success("{{ session('success') }}");
        @endif

        @if (Session::has('error'))
        toastr.error("{{ session('error') }}");
        @endif
    })(jQuery);
    </script>
    <script src="{{ asset('js/miembros/form-miembros.js') }}"></script>
@stop