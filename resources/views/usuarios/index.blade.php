@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Usuarios</h1>
@stop

@section('content')
    <a class="btn btn-warning" href="{{route('usuarios.create')}}">Nuevo</a>

    <table class="table table-striped mt-2">
        <thread style="background-color: #6777ef;">
            <th style="display: none;">ID</th>
            <th style="color: #fff">Nombre</th>
            <th style="color: #fff">Correo</th>
            <th style="color: #fff">Rol</th>
            <th style="color: #fff">Acciones</th>
        </thread>

        <tbody>
            @foreach($usuarios as $usuario)
                <tr>
                    <td style="display: none;">{{$usuario->id}}</td>
                    <td>{{$usuario->name}}</td>
                    <td>{{$usuario->email}}</td>
                    <td>
                        @if(!empty($usuario->getRoleNames()))
                            @foreach ($usuario->getRoleNames() as $rolName)
                                <h5><span class="badge badge-dark">{{$rolName}}</span></h5>
                            @endforeach
                        @endif
                    </td>

                    <td>
                        <a class="btn btn-info" href="{{route('usuarios.edit', $usuario->id)}}">Editar</a>
                        
                        {!! Form::open(['method' => 'DELETE', 'route'=>['usuarios.destroy', $usuario->id], 'style'=> 'display:inline' ]) !!}
                            {!! Form::submit('Eliminar', ['class' => 'btn btn-danger'])!!}

                        {!! Form::close() !!}
                    </td>

                </tr>
            @endforeach
        </tbody>

    </table>

@stop
