 <!-- Seccion para agregar mano de obra a las actividades -->
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

<div id="actividad-id" data-id="{{ $actividad->id }}"></div>
<div id="csrf-token" data-token="{{ csrf_token() }}"></div>

<!-- Modal Agregar Recurso -->
<div class="modal fade" id="agregarRecursoModal" tabindex="-1" role="dialog" aria-labelledby="agregarRecursoModalLabel" aria-hidden="true">
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
                        {{-- {!! Form::text('cantidad', null, array('class'=>'form-control', 'id' => 'cantidadRecurso')) !!} --}}
                    </div>
                </form>
                <div id="recursoDetalle">
                    <p><strong>Nombre:</strong> <span id="nombreRecurso"></span></p>
                    {{-- <p><strong>Cantidad:</strong> <span id="correoRecuso"></span></p> --}}
                    <p><strong>Costo:</strong> <span id="costoRecurso"></span></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="agregarRecursoBtn">Agregar</button>
            </div>
        </div>
    </div>
</div>