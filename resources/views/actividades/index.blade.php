@extends('adminlte::page')

@section('title', 'Actividad')

@section('content_header')
    <h1>Actividad</h1>
@stop

@section('content')
    <a class="btn btn-warning" href="{{ route('actividades.create', $proyecto->id) }}">Nuevo</a>

    <table class="table table-striped mt-2">
        <thread style="background-color: #6777ef;">
            <th class="d-none">ID</th>
            <th>Nombre</th>
            <th>Prioridad</th>
            <th>Fecha Inicio</th>
            <th>Fecha Fin</th>
            <th>Responsabilidades</th>
            <th>Estado Actividad</th>
            <th>Acciones</th>
        </thread>

        <tbody>
            @foreach($actividades as $actividad)
                <tr>
                    <td class="d-none">{{$actividad->id}}</td>
                    <td>{{$actividad->nombre}}</td>
                    <td>{{$actividad->prioridad}}</td>
                    <td>{{$actividad->fecha_inicio}}</td>
                    <td>{{$actividad->fecha_fin}}</td>
                    <td>{{$actividad->responsabilidades}}</td>
                    <td>{{$actividad->estado_actividad->nombre}}</td>
                    <td>
                        <a class="btn btn-info" href="{{route('actividades.edit', $actividad->id)}}">Editar</a>
                        <a href="#confirmDeleteModal" class="btn btn-danger" data-toggle="modal">Eliminar</a>
                        <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myModalLabel">Confirmar eliminación</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    </div>
                                    <div class="modal-body">
                                        ¿Estás seguro de que deseas eliminar este registro?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['actividades.destroy', $actividad->id], 'style' => 'display:inline']) !!}
                                            {!! Form::submit('Eliminar', ['class' => 'btn btn-danger']) !!}
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>
@stop
