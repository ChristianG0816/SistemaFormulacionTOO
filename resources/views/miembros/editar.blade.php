@extends('adminlte::page')
@section('title', 'Mano Obra')
@section('content_header')
<h1 class="text-center">Editar Miembro</h1>
@stop
@section('content')
<div class="row justify-content-center">
  <div class="col-md-8">
    <div class="card">
      <div class="card-body">
        <div id="table_wrapper" class="wrapper dt-bootstrap4">
          <div class="row">
            <div class="col-lg-6 col-md-12 mb-3"><!-- Columna izquierda -->
            {!! Form::model($manoObraUser, ['method'=>'PATCH', 'route' => ['miembros.update', $manoObraUser->id]]) !!}
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
                    <label for="tipo_documento" class="text-secondary">Tipo Documento*</label>
                    {!! Form::select('tipo_documento', $tipos_documentos, $manoObraUser->tipo_documento, [
                        'class' => 'form-control' . ($errors->has('tipo_documento') ? ' is-invalid' : ''), 'id' => 'select-tipo-documento'
                    ]) !!}
                    @error('tipo_documento')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="numero_documento" class="text-secondary">N° Documento*</label>
                    {!! Form::text('numero_documento', null, [
                        'class' => 'form-control' . ($errors->has('numero_documento') ? ' is-invalid' : ''),
                    ]) !!}
                    @error('numero_documento')
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
                    <label for="id_pais" class="text-secondary">País de Origen*</label>
                    {!! Form::select('id_pais', $paises, $manoObraUser->id_pais, [
                        'class' => 'form-control' . ($errors->has('id_pais') ? ' is-invalid' : ''), 'id' => 'select-pais'
                    ]) !!}
                    @error('id_pais')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div id="group-departamento" class="form-group">
                    <label for="departamento" class="text-secondary">Departamento*</label>
                    {!! Form::select('departamento', $departamentos, $manoObraUser->id_departamento, [
                        'class' => 'form-control' . ($errors->has('departamento') ? ' is-invalid' : ''), 'id' => 'select-departamento'
                    ]) !!}
                    @error('departamento')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div id="group-municipio" class="form-group">
                    <label for="municipio" class="text-secondary">Municipio*</label>
                    <select id="select-municipio" name="municipio" class="form-control {{ $errors->has('municipio') ? 'is-invalid' : '' }}">
                        @foreach ($municipios as $municipio)
                        <option value="{{ $municipio->id }}" data-departamento="{{ $municipio->id_departamento }}" {{ $municipio->id == $manoObraUser->id_municipio ? 'selected' : '' }}>
                            {{ $municipio->nombre }}
                        </option>
                        @endforeach
                    </select>
                    @error('municipio')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-6 col-md-12 mb-3"><!-- Columna derecha -->
            <div class="form-group">
                    <label for="estado_civil" class="text-secondary">Estado Civil*</label>
                    {!! Form::select('estado_civil', $estado_civil, $manoObraUser->estado_civil, [
                        'class' => 'form-control' . ($errors->has('estado_civil') ? ' is-invalid' : ''),
                    ]) !!}
                    @error('estado_civil')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="sexo" class="text-secondary">Sexo*</label>
                    {!! Form::select('sexo', $sexos, $manoObraUser->sexo, [
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