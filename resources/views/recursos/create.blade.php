@extends('adminlte::page')

@section('title', 'Recursos')

@section('content_header')
    <div class="container">
        <div class="row col-xs-12 col-sm-12 col-md-12">
            <h1 class="text-blue">Agregar Recursos</h1>
        </div>
    </div>
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

    {!! Form::open(array('route'=>'recursos.store', 'method'=>'POST')) !!}
    <div class="container pb-5">
        <div class="row col-xs-12 col-sm-12 col-md-12">
            <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    {!! Form::text('nombre', null, array('class'=>'form-control')) !!}
                </div>
                <div class="form-group">
                    <label for="">Disponibilidad</label>
                    {!! Form::select('disponibilidad[]', $disponibilidades, [], array('class' => 'form-control')) !!}
                </div>
                <div class="form-group">
                    <label for="costo">Costo</label>
                    {!! Form::text('costo', null, array('class'=>'form-control')) !!}
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}

@stop
