@extends('adminlte::page')

@section('title', 'Recursos')

@section('content_header')
<h1 class="text-center">Gestionar Recurso</h1>
@stop
@section('content')
<div class="row justify-content-center">
<div class="col-md-12">
  <div class="card">
    <div class="card-body justify-content-center d-flex pl-0 pr-0">
      <div  class="row col-lg-12 col-md-12">
        <div class="col-lg-12 col-md-12">
          <div id="table_wrapper" class="wrapper dt-bootstrap4">
            <div class="row">
              <div class="col-lg-12 col-md-12 mb-3">
                <div class="card">
                  <div class="card-header d-flex align-items-center">
                    <h3 class="card-title">Información General</h3>
                    <div class="card-tools ml-auto">
                      <button class="btn btn-sm btn-outline-info my-0 edit-recurso" data-id="{{ $recurso->id }}">Editar</button>
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
                                {!! Form::text('nombre', $recurso->nombre, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-1">
                                <div class="form-group">
                                  <label for="disponibilidad" class="text-secondary">disponibilidad</label>
                                </div>
                              </div>
                              <div class="col-md-11">
                                {!! Form::number('disponibilidad', $recurso->disponibilidad, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                              </div>
                            </div>
                            <div class="row">
                                <div class="col-md-1">
                                  <div class="form-group">
                                    <label for="costo" class="text-secondary">costo</label>
                                  </div>
                                </div>
                                <div class="col-md-11">
                                  {!! Form::number('disponibilidad', $recurso->costo, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
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
    </div>
  </div>
</div>
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
    <script src="{{ asset('js/recursos/recursos.js') }}"></script>
@stop
