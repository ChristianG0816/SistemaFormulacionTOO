@extends('adminlte::page')

@section('title', 'Editar Usuario')

@section('content_header')
    <h1 class="text-center">Editar Usuario</h1>
@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div id="table_wrapper" class="wrapper dt-bootstrap4">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                {!! Form::model($user, ['method' => 'PATCH', 'route' => ['usuarios.update', $user->id]]) !!}
                                
                                <div class="form-group">
                                    <label for="name">Nombre*</label>
                                    {!! Form::text('name', null, [
                                        'class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''),
                                    ]) !!}
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="last_name">Apellido*</label>
                                    {!! Form::text('last_name', null, [
                                        'class' => 'form-control' . ($errors->has('last_name') ? ' is-invalid' : ''),
                                    ]) !!}
                                    @error('last_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="email">Correo*</label>
                                    {!! Form::text('email', null, [
                                        'class' => 'form-control' . ($errors->has('email') ? ' is-invalid' : ''),
                                    ]) !!}
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="form-group">
                                    <label for="password">Contraseña</label>
                                    {!! Form::password('password', [
                                        'class' => 'form-control' . ($errors->has('password') ? ' is-invalid' : ''),
                                    ]) !!}
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="confirm-password">Confirmar Contraseña</label>
                                    {!! Form::password('confirm-password', ['class' => 'form-control']) !!}
                                </div>


                                <div class="form-group">
                                    <label for="">Roles*</label>
                                    {!! Form::select('roles[]', $roles, [], [
                                        'class' => 'form-control' . ($errors->has('roles') ? ' is-invalid' : ''),
                                    ]) !!}
                                    @error('roles')
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
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
