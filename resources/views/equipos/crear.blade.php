@extends('adminlte::page') @section('title', 'Gestionar Proyecto')
@section('content_header')
<h1>Gestionar Proyecto</h1>
@stop

@section('content')
@if ($errors->any())
<div class="alert alert-dark alert-dismissible fade show" role="alert">
    <strong>Revise los campos</strong>
    @foreach ($errors->all() as $error)
    <span class="badge badge-danger">{{ $error }}</span>
    @endforeach
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<div class="row">
    <div class="col-md-12">
        <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title">General</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="inputName">Project Name</label>
                    <input type="text" id="inputName" class="form-control" value="" />
                </div>
                <div class="form-group">
                    <label for="inputDescription">Project Description</label>
                    <textarea id="inputDescription" class="form-control" rows="4"></textarea>
                </div>
                <div class="form-group">
                    <label for="inputStatus">Status</label>
                    <select id="inputStatus" class="form-control custom-select">
                        <option disabled>Select one</option>
                        <option>On Hold</option>
                        <option>Canceled</option>
                        <option selected>Success</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="inputClientCompany">Client Company</label>
                    <input type="text" id="inputClientCompany" class="form-control" value="" />
                </div>
                <div class="form-group">
                    <label for="inputProjectLeader">Project Leader</label>
                    <input type="text" id="inputProjectLeader" class="form-control" value="" />
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Equipo de Trabajo</h3>
                <div class="card-tools">
                    <input type="submit" value="Agregar" class="btn btn-sm btn-success my-0">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        
                    </div>
                </div>
                <table id="tableEquipo" class="table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Telefono</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
    <!-- <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css"> -->
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
@stop

@section('js')
    <!-- <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script> -->
    <script src="//cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        var proyectoId = {{ $proyectoId }};
    </script>
    <script src="{{ asset('js/equipos/main.js') }}"></script>
@stop