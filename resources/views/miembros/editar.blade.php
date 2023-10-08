@extends('adminlte::page')

@section('title', 'Mano Obra')

@section('content_header')
    <div class="container">
        <div class="row col-xs-12 col-sm-12 col-md-12">
            <h1 class="text-blue">Editar Mano Obra</h1>
        </div>
    </div>
@stop

@section('content')
    @if ($errors->any())
    <div class="container">
        <div class="row col-xs-12 col-sm-12 col-md-12">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="alert alert-dark alert-dismissible fade show" role="alert">
                    <strong>Revise los campos</strong>
                    @foreach ($errors->all() as $error)
                        <span class="badge badge-danger">{{$error}}</span>
                    @endforeach
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    {!! Form::model($manoObraUser, ['method'=>'PATCH', 'route' => ['miembros.update', $manoObraUser->id]]) !!}
    <div class="container pb-5">
        <div class="row col-xs-12 col-sm-12 col-md-12">
            <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                    <label for="name">Nombre</label>
                    {!! Form::text('name', null, array('class'=>'form-control')) !!}
                </div>
                <div class="form-group">
                    <label for="name">Apellido</label>
                    {!! Form::text('last_name', null, array('class'=>'form-control')) !!}
                </div>
                <div class="form-group">
                    <label for="dui">DUI</label>
                    {!! Form::text('dui', null, array('class'=>'form-control')) !!}
                </div>
                <div class="form-group">
                    <label for="afp">AFP</label>
                    {!! Form::text('afp', null, array('class'=>'form-control')) !!}
                </div>
                <div class="form-group">
                    <label for="isss">ISSS</label>
                    {!! Form::text('isss', null, array('class'=>'form-control')) !!}
                </div>
                <div class="form-group">
                    <label for="pasaporte">Pasaporte</label>
                    {!! Form::text('pasaporte', null, array('class'=>'form-control')) !!}
                </div>
                <div class="form-group">
                    <label for="">Sexo</label>
                    {!! Form::select('sexo', $sexos, $manoObraUser->sexo, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                    <label for="profesion">Profesión</label>
                    {!! Form::text('profesion', null, array('class'=>'form-control')) !!}
                </div>
                <div class="form-group">
                    <label for="costo_servicio">Costo Servicio</label>
                    {!! Form::text('costo_servicio', null, array('class'=>'form-control')) !!}
                </div>
                <div class="form-group">
                    <label for="nacionalidad">Nacionalidad</label>
                    {!! Form::text('nacionalidad', null, array('class'=>'form-control')) !!}
                </div>
                <div class="form-group">
                    <label for="telefono">Teléfono</label>
                    {!! Form::text('telefono', null, ['class' => 'form-control', 'maxlength' => 8]) !!}
                </div>
                <div class="form-group">
                    <label for="estado_civil">Estado Civil</label>
                    {!! Form::text('estado_civil', null, array('class'=>'form-control')) !!}
                </div>
                <div class="form-group">
                    <label for="fecha_nacimiento">Fecha Nacimiento</label>
                    {!! Form::date('fecha_nacimiento', null, array('class'=>'form-control')) !!}
                </div>
            </div>
        </div>
        <div class="row col-xs-12 col-sm-12 col-md-12">
            <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
    </div>
    {!! Form::close() !!}

@stop
