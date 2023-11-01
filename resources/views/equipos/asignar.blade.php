<div class="row">
    <div class="col-lg-12 col-md-12 mb-3">
    <div class="card">
        <div class="card-header d-flex align-items-center">
        <h3 class="card-title">Equipo de Trabajo</h3>
        <div class="card-tools ml-auto">
            @if ($proyecto->estado_proyecto->nombre == 'Formulacion')
            @can('crear-equipo-trabajo')
            <a class="btn btn-sm btn-outline-warning my-0" type="button" value="Agregar" data-toggle="modal" data-target="#agregarMiembroModal">Agregar</a>
            @endcan
            @endif
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
            <i class="fas fa-minus"></i>
            </button>
        </div>
        </div>
        <div class="card-body">
        <div id="table_wrapper" class="dataTables_wrapper dt-bootstrap4">
            <div class="row">
            <div class="col-sm-12 card-body table-responsive p-0">
                <table id="tableEquipo" class="table table-bordered table-striped dataTable dtr-inline mt-1 table-head-fixed w-100">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Telefono</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody></tbody>
                </table>
            </div>
            </div>
        </div>
        </div>
    </div>
    </div>
</div>
<!-- Modal Agregar Miembro -->
<div class="modal fade" id="agregarMiembroModal" tabindex="-1" role="dialog" aria-labelledby="agregarMiembroModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="agregarMiembroModalLabel">Agregar Miembro al Equipo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="agregarMiembroForm">
                    <div class="form-group">
                        <label for="miembroSelect">Selecciona un miembro:</label>
                        <select class="form-control" id="miembroSelect" name="miembroSelect">
                        </select>
                    </div>
                </form>
                <div id="miembroDetalle">
                    <p><strong>Nombre:</strong> <span id="nombreMiembro"></span></p>
                    <p><strong>Correo:</strong> <span id="correoMiembro"></span></p>
                    <p><strong>Teléfono:</strong> <span id="telefonoMiembro"></span></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="agregarMiembroBtn">Agregar</button>
            </div>
        </div>
    </div>
</div>
<!-- /.Modal Agregar Miembro -->
<!-- Modal de eliminar Miembro-->
<div class="modal fade" id="confirmarEliminarMiembroModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Confirmar eliminación</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
      <div class="modal-body">
        <strong>¿Estás seguro de eliminar el miembro seleccionado del equipo de trabajo?</strong>
        <p>Ten en cuenta que se eliminarán sus datos asociados a la actividad.</p>
      </div>
      <div class="modal-footer">
        <button id="eliminarEqipoBtn" class="btn btn-outline-danger btn-sm">Eliminar</button>
        <button type="button" class="btn btn-outline-dark btn-sm" data-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>
<!-- /.Modal de eliminar Miembro-->