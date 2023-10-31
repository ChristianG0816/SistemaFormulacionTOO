@extends('adminlte::page')

@section('title', 'Editar Documento')

@section('content_header')
    <h1 class="text-center">Editar Documento</h1>
@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div id="table_wrapper" class="wrapper dt-bootstrap4">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                            {!! Form::model($documento, ['method'=>'PATCH', 'route' => ['documentos.update', $documento->id]]) !!}
                                {!! Form::text('id_proyecto', $proyecto->id, ['class' => 'form-control d-none']) !!}
                            <div class="form-group">
                                <label for="id_tipo_documento" class="text-secondary">Tipo de Documento*</label>
                                {!! Form::select('id_tipo_documento', $tipoDocumentos, null, ['class' => 'form-control' . ($errors->has('id_tipo_documento') ? ' is-invalid' : '')]) !!}
                                @error('id_tipo_documento')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="nombre" class="text-secondary">Nombre*</label>
                                {!! Form::text('nombre', null, ['class' => 'form-control' . ($errors->has('nombre') ? ' is-invalid' : ''), 'maxlength' => 255]) !!}
                                @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="autor" class="text-secondary">Autor*</label>
                                {!! Form::text('autor', null, ['class' => 'form-control' . ($errors->has('autor') ? ' is-invalid' : ''), 'maxlength' => 255]) !!}
                                @error('autor')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="link" class="text-secondary">Link*</label>
                                {!! Form::text('link', null, ['class' => 'form-control' . ($errors->has('link') ? ' is-invalid' : ''), 'maxlength' => 255]) !!}
                                @error('link')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="fecha_creacion" class="text-secondary">Fecha de Creación*</label>
                                {!! Form::date('fecha_creacion', null, ['class' => 'form-control' . ($errors->has('fecha_creacion') ? ' is-invalid' : '')]) !!}
                                @error('fecha_creacion')
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
