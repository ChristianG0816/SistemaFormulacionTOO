@extends('adminlte::page')

@section('title', 'Editar Cliente')

@section('content_header')
    <h1 class="text-center">Editar Cliente</h1>
@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div id="table_wrapper" class="wrapper dt-bootstrap4">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                            {!! Form::model($cliente, ['method'=>'PATCH', 'route' => ['clientes.update', $cliente->id]]) !!}
                            <div class="form-group">
                                <label for="tipo_cliente" class="text-secondary">Tipo de Cliente*</label>
                                {!! Form::select('tipo_cliente', ['Persona Natural' => 'Persona Natural', 'Persona Jurídica' => 'Persona Jurídica'], null, ['class' => 'form-control' . ($errors->has('tipo_cliente') ? ' is-invalid' : ''), 'id' => 'tipo_cliente']) !!}
                                @error('tipo_cliente')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group natural">
                                <label for="name" class="text-secondary">Nombre*</label>
                                {!! Form::text('name', $usuario->name, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''), 'maxlength' => 255]) !!}
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group juridica">
                                <label for="last_name" class="text-secondary">Apellido*</label>
                                {!! Form::text('last_name', $usuario->last_name, ['class' => 'form-control' . ($errors->has('last_name') ? ' is-invalid' : ''), 'maxlength' => 255]) !!}
                                @error('last_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="email" class="text-secondary">Correo*</label>
                                {!! Form::email('email', $usuario->email, ['class' => 'form-control' . ($errors->has('email') ? ' is-invalid' : ''),'maxlength' => 255]) !!}
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="telefono" class="text-secondary">Teléfono*</label>
                                {!! Form::text('telefono', null, ['class' => 'form-control' . ($errors->has('telefono') ? ' is-invalid' : ''),'maxlength' => 9]) !!}
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
    <script src="{{ asset('js/clientes/clientes-form.js') }}"></script>
@stop
