@extends('adminlte::page')

@section('title', 'Recursos')

@section('content_header')
    <h1>Recursos</h1>
@stop

@section('content')
    <a class="btn btn-warning" href="{{route('recursos.create')}}">Nuevo</a>

    <table class="table table-striped mt-2">
        <thread style="background-color: #6777ef;">
            <th class="d-none">ID</th>
            <th>Nombre</th>
            <th>Disponibilidad</th>
            <th>Costo</th>
            <th>Acciones</th>
        </thread>

        <tbody>
            @foreach($recursos as $recurso)
                <tr>
                    <td style="display: none;">{{ $recurso->id }}</td>
                    <td>{{ $recurso->nombre }}</td>
                    <td>{{ $recurso->disponibilidad }}</td>
                    <td>{{ $recurso->costo }}</td>
                    <td>
                        <a class="btn btn-secondary" href="{{ route('recursos.show', $recurso->id) }}">Mostrar</a>
                        <a class="btn btn-info" href="{{ route('recursos.edit', $recurso->id) }}">Editar</a>
                        {!! Form::open(['method' => 'DELETE', 'route'=>['recursos.destroy', $recurso->id], 'style'=> 'display:inline' ]) !!}
                            {!! Form::submit('Eliminar', ['class' => 'btn btn-danger']) !!}
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
        </tbody>
        

    </table>

@stop
