@extends('adminlte::page')

@section('title', 'Editar Rol')

@section('content_header')
    <h1>Editar Rol</h1>
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

    {!! Form::model($role, ['method' => 'PATCH', 'route' => ['roles.update', $role->id]]) !!}
        <div class="row">
            
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <label for="name">Nombre del Rol:</label>
                    {!! Form::text('name', null, array('class'=>'form-control')) !!}
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <label for="">Permisos para este Rol:</label>
                    <br>
                    @foreach ($permission as $value)
                        <label>
                            {{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ?? true) }}
                            {{$value->name}}
                        </label>
                    <br>
                    @endforeach
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    {!! Form::close() !!}

@stop
