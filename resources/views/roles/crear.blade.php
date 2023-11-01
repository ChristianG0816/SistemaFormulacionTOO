@extends('adminlte::page')

@section('title', 'Crear Rol')

@section('content_header')
    <h1 class="text-center">Crear Rol</h1>
@stop

@section('content')
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
                                    {!! Form::text('name', null, [
                                        'class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''),
                                    ]) !!}
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="form-group">
                                    <label for="">Permisos para este Rol*:</label>
                                    @error('permission')
                                        <div style="font-size: 80%; color: #dc3545;">{{ $message }}</div>
                                    @enderror
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
