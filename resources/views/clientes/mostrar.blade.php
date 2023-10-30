@extends('adminlte::page')
@section('title', 'Contactos')
@section('content_header')
<h1 class="text-center">Cartera de contactos</h1>
<p id="id_cliente" data-id-cliente="{{ $cliente->id }}" class="d-none"></p>
@stop
@section('content')
<div class="row justify-content-center">
<div class="col-md-10">
  <div class="card">
    <div class="card-body justify-content-center d-flex pl-0 pr-0">
      <div  class="row col-lg-12 col-md-12">
        <div class="col-lg-12 col-md-12">
          <div id="table_wrapper" class="wrapper dt-bootstrap4">
            <!--Sección de información general del cliente-->
            <div class="row">
              <div class="col-lg-12 col-md-12 mb-3">
                <div class="card">
                  <div class="card-header d-flex align-items-center">
                    <h3 class="card-title">Información General del Cliente</h3>
                    <div class="card-tools ml-auto">
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
                              <div class="col-md-2">
                                <div class="form-group">
                                  <label for="tipo_cliente" class="text-secondary">Tipo de Cliente</label>
                                </div>
                              </div>
                              <div class="col-md-10">
                                {!! Form::text('tipo_cliente', $cliente->tipo_cliente, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-2">
                                <div class="form-group">
                                  <label for="nombre" class="text-secondary">Nombre</label>
                                </div>
                              </div>
                              <div class="col-md-10">
                                {!! Form::text('name', $cliente->usuario_cliente->name, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                              </div>
                            </div>
                            @if ($cliente->tipo_cliente === 'Persona Natural')
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="last_name" class="text-secondary">Apellido</label>
                                        </div>
                                    </div>
                                    <div class="col-md-10">
                                        {!! Form::text('last_name', $cliente->usuario_cliente->last_name, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                                    </div>
                                </div>
                            @endif
                            <div class="row">
                              <div class="col-md-2">
                                <div class="form-group">
                                  <label for="email" class="text-secondary">Correo</label>
                                </div>
                              </div>
                              <div class="col-md-10">
                                {!! Form::text('email', $cliente->usuario_cliente->email, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-2">
                                <div class="form-group">
                                  <label for="telefono" class="text-secondary">Teléfono</label>
                                </div>
                              </div>
                              <div class="col-md-10">
                                {!! Form::text('telefono', $cliente->telefono, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
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
            <!--Sección de contactos-->
            <div class="row">
              <div class="col-lg-12 col-md-12 mb-3">
                <div class="card">
                  <div class="card-header d-flex align-items-center">
                    <h3 class="card-title">Contactos</h3>
                    <div class="card-tools ml-auto">
                      <a class="btn btn-sm btn-outline-warning my-0" href="{{ route('contactos.create', $cliente->id) }}">Agregar</a>
                      <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                      <i class="fas fa-minus"></i>
                      </button>
                    </div>
                  </div>
                  <div class="card-body">
                    <div id="table_wrapper" class="dataTables_wrapper dt-bootstrap4">
                      <div class="row">
                        <div class="col-sm-12 card-body table-responsive p-0">
                          <!--Sección de tabla-->
                            <table id="tabla-contactos" class="table table-bordered table-striped dataTable dtr-inline mt-1 table-head-fixed w-100"></table>
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
        <strong>¿Estás seguro de eliminar el contacto seleccionado?</strong>
        <p>El contacto será eliminado de forma permanente.</p>
      </div>
      <div class="modal-footer">
        <button id="eliminarContactoBtn" class="btn btn-outline-danger btn-sm">Eliminar</button>
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
</script>
<script src="{{ asset('js/contactos/contactos.js') }}"></script>
@stop