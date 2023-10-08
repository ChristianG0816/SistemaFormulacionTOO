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
                    <td class="d-none">{{$manoObra->id}}</td>
                    <td>{{$manoObra->usuario->name}} {{$manoObra->usuario->last_name}}</td>
                    <td>{{$manoObra->profesion}}</td>
                    <td>{{$manoObra->costo_servicio}}</td>
                    <td>{{$manoObra->dui}}</td>
                    <td>{{$manoObra->afp}}</td>
                    <td>{{$manoObra->isss}}</td>
                    <td>
                        <a class="btn btn-secondary" href="{{route('miembros.show', $manoObra->id)}}">Mostrar</a>
                        <a class="btn btn-primary" href="{{route('miembros.edit', $manoObra->id)}}">Editar</a>
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
                                        {!! Form::open(['method' => 'DELETE', 'route'=>['miembros.destroy', $manoObra->id], 'style'=> 'display:inline' ]) !!}
                                            {!! Form::submit('Eliminar', ['class' => 'btn btn-danger'])!!}
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
