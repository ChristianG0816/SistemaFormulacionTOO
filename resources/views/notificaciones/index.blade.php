@extends('adminlte::page')
@section('title', 'Notificacion')
@section('content_header')
<h1>Notificaciones</h1>
@stop
@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <div class="row">
          <div class="col-12">
            <div class="float-right">
              <button id="marcarTodas" class="btn btn-outline-success">Marcar todas como leídas</button>
              <button id="eliminarTodas" class="btn btn-outline-danger">Eliminar todas</button>
            </div>
          </div>
      </div>
      <div class="card-body">
        <div id="table_wrapper" class="dataTables_wrapper dt-bootstrap4">
          <div class="row">
            <div class="col-sm-12 card-body table-responsive p-0">
              <!--Sección de tabla-->
              <table id="tabla-notificaciones" class="table table-bordered table-striped dataTable dtr-inline mt-1 table-head-fixed text-nowrap w-100 text-center"></table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Modal de eliminar Notificacion-->
<div class="modal fade" id="confirmarEliminarNotificacionModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Confirmar eliminación</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
      <div class="modal-body">
        <strong>¿Estás seguro de eliminar la notificación seleccionada?</strong>
      </div>
      <div class="modal-footer">
        <button id="eliminarNotificacion" class="btn btn-outline-danger btn-sm">Eliminar</button>
        <button type="button" class="btn btn-outline-dark btn-sm" data-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>
<!-- /.Modal de eliminar Notificacion-->
<!-- Modal eliminar todas las notificaciones -->
<div class="modal fade" id="confirmarEliminarTodasNotificacionModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Confirmar eliminación</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
      <div class="modal-body">
        <strong>¿Estás seguro de eliminar todas las notificaciones?</strong>
      </div>
      <div class="modal-footer">
        <button id="eliminarTodasNotificacion" class="btn btn-outline-danger btn-sm">Eliminar</button>
        <button type="button" class="btn btn-outline-dark btn-sm" data-dismiss="modal">Cancelar</button>
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

  var csrfToken = '{{ csrf_token() }}';
</script>
<script src="{{ asset('js/notificaciones/notificaciones.js') }}"></script>
@stop
