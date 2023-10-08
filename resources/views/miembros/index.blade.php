@extends('adminlte::page')

@section('title', 'Mano Obra')

@section('content_header')
    <h1>Mano Obra</h1>
@stop

@section('content')
    <a class="btn btn-warning" href="{{route('miembros.create')}}">Nuevo</a>

    <table class="table table-striped mt-2">
        <thread style="background-color: #6777ef;">
            <th class="d-none">ID</th>
            <th>Nombre</th>
            <th>Profesión</th>
            <th>Costo Servicio</th>
            <th>DUI</th>
            <th>AFP</th>
            <th>ISS</th>
            <th>Acciones</th>
        </thread>

        <tbody>
            @foreach($manoObras as $manoObra)
                <tr>
                    <td style="display: none;">{{$manoObra->id}}</td>
                    <td>{{$manoObra->usuario->name}} {{$manoObra->usuario->last_name}}</td>
                    <td>{{$manoObra->profesion}}</td>
                    <td>{{$manoObra->costo_servicio}}</td>
                    <td>{{$manoObra->dui}}</td>
                    <td>{{$manoObra->afp}}</td>
                    <td>{{$manoObra->isss}}</td>
                    <td>
                        <a class="btn btn-secondary" href="{{route('miembros.show', $manoObra->id)}}">Mostrar</a>
                        <a class="btn btn-info" href="{{route('miembros.edit', $manoObra->id)}}">Editar</a>
                        {!! Form::open(['method' => 'DELETE', 'route'=>['miembros.destroy', $manoObra->id], 'style'=> 'display:inline' ]) !!}
                            {!! Form::submit('Eliminar', ['class' => 'btn btn-danger'])!!}
                        {!! Form::close() !!}
                    </td>

                </tr>
            @endforeach
        </tbody>

    </table>

@stop
