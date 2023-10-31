<!--Sección de documentos legales-->
<div class="row">
    <div class="col-lg-12 col-md-12 mb-3">
    <div class="card">
        <div class="card-header d-flex align-items-center">
        <h3 class="card-title">Documentos Legales</h3>
        <div class="card-tools ml-auto">
            <a class="btn btn-sm btn-outline-warning my-0" href="{{ route('documentos.create', $proyecto->id) }}">Agregar</a>
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse"><i class="fas fa-minus"></i></button>
        </div>
        </div>
        <div class="card-body">
        <div id="table_wrapper" class="dataTables_wrapper dt-bootstrap4">
            <div class="row">
            <div class="col-sm-12 card-body table-responsive p-0">
                <!--Sección de tabla-->
                <table id="tabla-documentos" class="table table-bordered table-striped dataTable dtr-inline mt-1 table-head-fixed w-100"></table>
            </div>
            </div>
        </div>
        </div>
    </div>
    </div>
</div>
<!-- Modal de eliminar Documento-->
<div class="modal fade" id="confirmarEliminarDocumentoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Confirmar eliminación</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
      <div class="modal-body">
        <strong>¿Estás seguro de eliminar el Documento seleccionado?</strong>
        <p>Ten en cuenta que se eliminará de forma permanente.</p>
      </div>
      <div class="modal-footer">
        <button id="eliminarDocumentBtn" class="btn btn-outline-danger btn-sm">Eliminar</button>
        <button type="button" class="btn btn-outline-dark btn-sm" data-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>
<!-- /.Modal de eliminar Documento-->