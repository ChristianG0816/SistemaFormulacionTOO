@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Editar Usuario</h1>
@stop

@section('content')
    @if ($errors->any())
        <div class="alert alert-dark alert-dismissible fade show" role="alert">
            <strong>Revise los campos</strong>
            @foreach ($errors->all() as $error)
                <span class="badge badge-danger">{{$error}}</span>
            @endforeach
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    {!! Form::model($user, ['method'=>'PATCH', 'route' => ['usuarios.update', $user->id]]) !!}
        <div class="row">
            
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <label for="name">Nombre</label>
                    {!! Form::text('name', null, array('class'=>'form-control')) !!}
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <label for="last_name">Apellido</label>
                    {!! Form::text('last_name', null, array('class'=>'form-control')) !!}
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <label for="email">Correo</label>
                    {!! Form::text('email', null, array('class'=>'form-control')) !!}
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    {!! Form::password('password', array('class'=>'form-control')) !!}
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <label for="confirm-password">Confirmar Contraseña</label>
                    {!! Form::password('confirm-password', array('class'=>'form-control')) !!}
                </div>
            </div>


            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <label for="">Roles</label>
                    {!! Form::select('roles[]', $roles, [], array('class' => 'form-control')) !!}
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>


        </div>
    {!! Form::close() !!}

@stop
