@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Roles</h1>
@stop

@section('content')

    @can('crear-rol')
        <a class="btn btn-warning" href="{{route('roles.create')}}">Nuevo</a>
    @endcan

    <table class="table table-striped mt-2">
        <thread style="background-color: #6777ef;">
            <th style="color: #fff">Rol</th>
            <th style="color: #fff">Acciones</th>
        </thread>

        <tbody>
            @foreach($roles as $role)
                <tr>
                    <td>{{$role->name}}</td>
                    <td>
                        @can('editar-rol')
                            <a class="btn btn-primary" href="{{route('roles.edit', $role->id)}}">Editar</a>
                        @endcan

                        @can('borrar-rol')
                            {!! Form::open(['method' => 'DELETE', 'route' => ['roles.destroy', $role->id], 'style'=>'display:inline']) !!}
                                {!! Form::submit('Eliminar', ['class' => 'btn btn-danger']) !!}
                            {!! Form::close() !!}
                        @endcan
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@stop
