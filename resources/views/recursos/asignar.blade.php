 <!-- Seccion para agregar recursos -->
@can('ver-asignacionRecurso')
<div class="row">
    <div class="col-lg-12 col-md-12 mb-3">
        <div class="card collapsed-card">
            <div class="card-header d-flex align-items-center">
                <h3 class="card-title mb-0">Recursos</h3>
                <div class="card-tools ml-auto">
                    <input type="button" value="Agregar" class="btn btn-sm btn-outline-warning my-0" data-toggle="modal" data-target="#agregarRecursoModal">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body" style="display: none;">
                <div id="table_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div class="row">
                    <div class="col-sm-12 card-body table-responsive p-0">
                    <!--Sección de tabla-->
                    <table id="tableRecursosActividad" class="table table-bordered table-striped dataTable dtr-inline mt-1 table-head-fixed w-100"></table>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endcan

<div id="actividad-id" data-id="{{ $actividad->id }}"></div>
<div id="csrf-token" data-token="{{ csrf_token() }}"></div>
<div id="proyecto-id" data-id="{{ $actividad->id_proyecto}}"></div>

<!-- Modal Agregar Recurso -->
<div class="modal fade" id="agregarRecursoModal" tabindex="-1" role="dialog" aria-labelledby="agregarRecursoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar Recurso a la Actividad</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="agregarRecursoForm">
                    <div class="form-group">
                        <label for="recursoSelect" class="text-secondary">Selecciona un recurso:*</label>
                        <select class="form-control" id="recursoSelect" name="recursoSelect">
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="disponibilidad" class="text-secondary">Disponibilidad:</label>
                        <input type="number" class="form-control" id="disponibilidadRecurso" readonly>
                    </div>
                    <div class="form-group">
                        <label for="costo" class="text-secondary">Costo:</label>
                        <input type="number" class="form-control" id="costoRecurso" readonly>
                    </div>
                    <div class="form-group">
                        <label for="cantidad" class="text-secondary">Cantidad:*</label>
                        <input type="number" class="form-control" id="cantidadRecurso" name="cantidadRecurso">
                        <div class="invalid-feedback"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-warning" id="agregarRecursoBtn">Agregar</button>
                <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Editar Recurso -->
<div class="modal fade" id="editarRecursoModal" tabindex="-1" role="dialog" aria-labelledby="editarRecursoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Recurso a la Actividad</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editarRecursoForm">
                    <div class="form-group">
                        <label for="nombre" class="text-secondary">Nombre:</label>
                        <input type="text" class="form-control" id="nombreRecursoE" readonly>
                    </div>
                    <div class="form-group">
                        <label for="disponibilidad" class="text-secondary">Disponibilidad:</label>
                        <input type="number" class="form-control" id="disponibilidadRecursoE" readonly>
                    </div>
                    <div class="form-group">
                        <label for="costo" class="text-secondary">Costo:</label>
                        <input type="number" class="form-control" id="costoRecursoE" readonly>
                    </div>
                    <div class="form-group">
                        <label for="cantidad" class="text-secondary">Cantidad:*</label>
                        <input type="number" class="form-control" id="cantidadRecursoE" name="cantidadRecurso">
                        <div class="invalid-feedback"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-warning" id="editarRecursoBtn">Editar</button>
                <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de eliminar -->
<div class="modal fade" id="confirmarEliminarModalRecurso" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Confirmar eliminación</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <strong>¿Estás seguro de eliminar el recurso seleccionado?</strong>
                <p>Ten en cuenta que se eliminarán los datos relacionados al recurso.</p>
            </div>
            <div class="modal-footer">
                <button id="eliminarRecursoBtn" class="btn btn-outline-danger btn-sm">Eliminar</button>
                <button type="button" class="btn btn-outline-dark btn-sm" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>                 
<!-- /.Modal de eliminar -->

{{-- <div class="modal fade" id="agregarRecursoModal" tabindex="-1" role="dialog" aria-labelledby="agregarRecursoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="agregarRecursoModalLabel">Agregar Recurso a la Actividad</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="agregarRecursoForm">
                    <div class="form-group">
                        <label for="recursoSelect">Selecciona un recurso:</label>
                        <select class="form-control" id="recursoSelect" name="recursoSelect">
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="cantidad" class="">Cantidad:</label>
                        <input type="number" class="form-control" id="cantidadRecurso">
                    </div>
                </form>
                <div id="recursoDetalle">
                    <p><strong>Nombre:</strong> <span id="nombreRecurso"></span></p>
                    <p><strong>Costo:</strong> <span id="costoRecurso"></span></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="agregarRecursoBtn">Agregar</button>
            </div>
        </div>
    </div>
</div> --}}