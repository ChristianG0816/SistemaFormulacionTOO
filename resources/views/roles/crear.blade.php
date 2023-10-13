@extends('adminlte::page')

@section('title', 'Crear Rol')

@section('content_header')
    <h1 class="text-center">Crear Rol</h1>
@stop

@section('content')
    @if ($errors->any())
        <div class="alert alert-dark alert-dismissible fade show" role="alert">
            <strong>Revise los campos</strong>
            @foreach ($errors->all() as $error)
                <span class="badge badge-danger">{{ $error }}</span>
            @endforeach
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div id="table_wrapper" class="wrapper dt-bootstrap4">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                {!! Form::open(['route' => 'roles.store', 'method' => 'POST']) !!}
                                <div class="form-group">
                                    <label for="name">Nombre del Rol*:</label>
                                    {!! Form::text('name', null, ['class' => 'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    <label for="">Permisos para este Rol*:</label>
                                    <br>
                                    @foreach ($permission as $value)
                                        <label>
                                            {{ Form::checkbox('permission[]', $value->id, false, ['class' => 'name']) }}
                                            {{ $value->name }}
                                        </label>
                                        <br>
                                    @endforeach
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
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
