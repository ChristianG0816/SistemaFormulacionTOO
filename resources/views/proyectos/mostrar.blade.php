@extends('adminlte::page')
@section('title', 'Gestión Proyectos')
@section('content_header')
<h1 class="text-center">Gestionar Proyecto</h1>
<p id="id_proyecto" data-id-proyecto="{{ $proyecto->id }}" class="d-none"></p>
@stop
@section('content')
@if ($errors->any())
<div class="container">
  <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <strong>Revise los campos</strong>
      @foreach ($errors->all() as $error)
      <span class="text-danger">{{$error}}</span>
      @endforeach
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      </button>
    </div>
  </div>
</div>
@endif
<div class="row justify-content-center">
<div class="col-md-12">
  <div class="card">
    <div class="card-body justify-content-center d-flex pl-0 pr-0">
      <div  class="row col-lg-12 col-md-12">
        <div class="col-lg-12 col-md-12">
          <div id="table_wrapper" class="wrapper dt-bootstrap4">
            <!--Sección de información general de de proyecto-->
            <div class="row">
              <div class="col-lg-12 col-md-12 mb-3">
                <div class="card">
                  <div class="card-header d-flex align-items-center">
                    <h3 class="card-title">Información General</h3>
                    <div class="card-tools ml-auto">
                      <button class="btn btn-sm btn-outline-info my-0 edit-proyecto" data-id="{{ $proyecto->id }}" data-origin="detalle">Editar</button>
                      <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                      <i class="fas fa-minus"></i>
                      </button>
                    </div>
                  </div>
                  <div class="card-body">
                    <div id="table_wrapper" class="dataTables_wrapper dt-bootstrap4">
                      <div class="row">
                        <div class="col-sm-12 card-body table-responsive p-0">
                          <div class="col-lg-12 col-md-12 mb-3">
                            <div class="row">
                              <div class="col-md-1">
                                <div class="form-group">
                                  <label for="nombre" class="text-secondary">Nombre</label>
                                </div>
                              </div>
                              <div class="col-md-11">
                                {!! Form::text('nombre', $proyecto->nombre, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-1">
                                <div class="form-group">
                                  <label for="objetivo" class="text-secondary">Objetivo</label>
                                </div>
                              </div>
                              <div class="col-md-11">
                                {!! Form::textarea('objetivo', $proyecto->objetivo, ['class' => 'form-control', 'rows' => 1, 'readonly' => 'readonly']) !!}
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-1">
                                <div class="form-group">
                                  <label for="id_cliente" class="text-secondary">Cliente</label>
                                </div>
                              </div>
                              <div class="col-md-11">
                                {!! Form::text('id_cliente', $proyecto->cliente->name . ' ' . $proyecto->cliente->last_name, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-1">
                                <div class="form-group">
                                  <label for="id_dueno" class="text-secondary">Dueño</label>
                                </div>
                              </div>
                              <div class="col-md-11">
                                {!! Form::text('id_dueno', $proyecto->dueno->name . ' ' . $proyecto->dueno->last_name, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-1">
                                <div class="form-group">
                                  <label for="descripcion" class="text-secondary">Descripción</label>
                                </div>
                              </div>
                              <div class="col-md-11">
                                {!! Form::textarea('descripcion', $proyecto->descripcion, ['class' => 'form-control', 'rows' => 1, 'readonly' => 'readonly']) !!}
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-1">
                                <div class="form-group">
                                  <label for="fecha_inicio" class="text-secondary">Fecha Inicio</label>
                                </div>
                              </div>
                              <div class="col-md-11">
                                {!! Form::date('fecha_inicio', $proyecto->fecha_inicio, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-1">
                                <div class="form-group">
                                  <label for="fecha_fin" class="text-secondary">Fecha Fin</label>
                                </div>
                              </div>
                              <div class="col-md-11">
                                {!! Form::date('fecha_fin', $proyecto->fecha_fin, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-1">
                                <div class="form-group">
                                  <label for="presupuesto" class="text-secondary">Presupuesto</label>
                                </div>
                              </div>
                              <div class="col-md-11">
                                {!! Form::number('presupuesto', $proyecto->presupuesto, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-1">
                                <div class="form-group">
                                  <label for="prioridad" class="text-secondary">Prioridad</label>
                                </div>
                              </div>
                              <div class="col-md-11">
                                {!! Form::text('prioridad', $proyecto->prioridad, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-1">
                                <div class="form-group">
                                  <label for="entregable" class="text-secondary">Entregable</label>
                                </div>
                              </div>
                              <div class="col-md-11">
                                {!! Form::text('entregable', $proyecto->entregable, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-1">
                                <div class="form-group">
                                  <label for="id_estado_proyecto" class="text-secondary">Estado</label>
                                </div>
                              </div>
                              <div class="col-md-11">
                                {!! Form::text('id_estado_proyecto', $proyecto->estado_proyecto->nombre, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!--Sección de equipo de trabajo-->
            @include('equipos.asignar')
            <!--Sección de actividades-->
            <div class="row">
              <div class="col-lg-12 col-md-12 mb-3">
                <div class="card collapsed-card">
                  <div class="card-header d-flex align-items-center">
                    <h3 class="card-title">Actividades</h3>
                    <div class="card-tools ml-auto">
                      <a class="btn btn-sm btn-outline-warning my-0" href="{{ route('actividades.create', $proyecto->id) }}">Agregar</a>
                      <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                      <i class="fas fa-plus"></i>
                      </button>
                    </div>
                  </div>
                  <div class="card-body" style="display:none">
                    <div id="table_wrapper" class="dataTables_wrapper dt-bootstrap4">
                      <div class="row">
                        <div class="col-sm-12 card-body table-responsive p-0">
                          <!--Sección de tabla-->
                            <table id="tabla-actividades" class="table table-bordered table-striped dataTable dtr-inline mt-1 table-head-fixed w-100"></table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Modal de eliminar -->
<div class="modal fade" id="confirmarEliminarModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Confirmar eliminación</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
      <div class="modal-body">
        <strong>¿Estás seguro de eliminar la actividad seleccionada?</strong>
        <p>Ten en cuenta que no se eliminará si ya ha sido asignado a una o más actividades.</p>
      </div>
      <div class="modal-footer">
        <button id="eliminarActividadBtn" class="btn btn-outline-danger btn-sm">Eliminar</button>
        <button type="button" class="btn btn-outline-dark btn-sm" data-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>
<!-- /.Modal de eliminar -->

@stop
@section('js')
<script>
  jQuery.noConflict();
  (function($) {      
      toastr.options = {"closeButton": true, "progressBar": true}
      @if (Session::has('success'))
      toastr.success("{{ session('success') }}");
      @endif
  
      @if (Session::has('error'))
      toastr.error("{{ session('error') }}");
      @endif
  })(jQuery);
  var proyectoId = {{ $proyecto->id }};
  var csrfToken = '{{ csrf_token() }}';
</script>
<script src="{{ asset('js/proyectos/proyectos.js') }}"></script>
<script src="{{ asset('js/actividades/actividades.js') }}"></script>
<script src="{{ asset('js/equipos/equipos.js') }}"></script>
@stop