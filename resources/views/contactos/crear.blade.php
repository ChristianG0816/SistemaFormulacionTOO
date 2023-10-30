@extends('adminlte::page')

@section('title', 'Crear Contacto')

@section('content_header')
    <h1 class="text-center">Crear Contacto</h1>
@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div id="table_wrapper" class="wrapper dt-bootstrap4">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                            {!! Form::open(array('route'=>'contactos.store', 'method'=>'POST')) !!}
                                {!! Form::text('id_cliente', $cliente->id, ['class' => 'form-control d-none']) !!}
                            <div class="form-group">
                                <label for="nombre" class="text-secondary">Nombre*</label>
                                {!! Form::text('nombre', null, ['class' => 'form-control' . ($errors->has('nombre') ? ' is-invalid' : ''), 'maxlength' => 250]) !!}
                                @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="apellido" class="text-secondary">Apellido*</label>
                                {!! Form::text('apellido', null, ['class' => 'form-control' . ($errors->has('apellido') ? ' is-invalid' : ''), 'maxlength' => 250]) !!}
                                @error('apellido')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="rol" class="text-secondary">Rol*</label>
                                {!! Form::text('rol', null, ['class' => 'form-control' . ($errors->has('rol') ? ' is-invalid' : ''), 'maxlength' => 100]) !!}
                                @error('rol')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="correo" class="text-secondary">Correo*</label>
                                {!! Form::email('correo', null, ['class' => 'form-control' . ($errors->has('correo') ? ' is-invalid' : ''),'maxlength' => 100]) !!}
                                @error('correo')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="telefono" class="text-secondary">Teléfono</label>
                                {!! Form::text('telefono', null, ['class' => 'form-control' . ($errors->has('telefono') ? ' is-invalid' : ''),'maxlength' => 9, 'placeholder' => '####-####']) !!}
                                @error('telefono')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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
    </div>
@stop
@section('js')
    <script src="{{ asset('js/contactos/contactos.js') }}"></script>
@stop
