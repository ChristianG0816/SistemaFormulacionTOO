@extends('adminlte::page')
@section('title', 'Reporte')
@section('content_header')
<h1>Reportes</h1>
@stop
@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">
          <!--Sección de botones-->
          <button id="export-copy" class="btn btn-sm btn-outline-secondary buttons-copy" type="button"><span>Copiar</span></button> 
          <button id="export-excel" class="btn btn-sm btn-outline-success buttons-excel" type="button"><span>Exportar</span></button> 
          <button id="export-pdf" class="btn btn-sm btn-outline-danger buttons-pdf" type="button"><span>Exportar</span></button>
        </h3>
      </div>
      <div class="card-body">
        <div id="table_wrapper" class="dataTables_wrapper dt-bootstrap4">
          <div class="row">
            <div class="col-sm-12 card-body table-responsive p-0" style="height: 60vh;">
              <!--Sección de tabla-->
              <table id="tabla-reportes" class="table table-bordered table-striped dataTable dtr-inline mt-1 table-head-fixed text-nowrap" style="width:100%"></table>
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
<script src="{{ asset('js/reportes/reportes.js') }}"></script>
@stop