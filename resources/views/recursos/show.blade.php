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

    <div class="container pb-5">
        <div class="row col-xs-12 col-sm-12 col-md-12">
            <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    {!! Form::text('name', $recurso->nombre, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                </div>
                <div class="form-group">
                    <label for="">Disponibilidad</label>
                    {!! Form::text('disponibilidad', $recurso->disponibilidad, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                </div>
                <div class="form-group">
                    <label for="costo">Costo</label>
                    {!! Form::text('costo', $recurso->costo, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                </div>
            </div>
        </div>
    </div>
@stop
