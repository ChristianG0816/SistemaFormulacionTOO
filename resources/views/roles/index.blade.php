@extends('adminlte::page')
@section('title', 'Roles')
@section('content_header')
    <h1>Roles</h1>
@stop

@section('content')

    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <!--Sección de botones-->
                    @can('crear-rol')
                        <a class="btn btn-sm btn-outline-warning" href="{{ route('roles.create') }}">Nuevo</a>
                        <br><br>
                    @endcan
                </h3>
            </div>

            <div class="card-body">
                <div id="table_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="row">
                        <div class="col-sm-12 card-body table-responsive p-0" style="height: 60vh;">
                            <!--Sección de tabla-->
                            <table id="tabla-roles"
                                class="table table-bordered table-striped dataTable dtr-inline mt-1 table-head-fixed text-nowrap">
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- Modal de eliminar -->
    <div class="modal fade" id="confirmarEliminarModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Confirmar eliminación</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <strong>¿Estás seguro de eliminar el rol seleccionado?</strong>
                    <p>Ten en cuenta que se eliminarán los datos relacionados al rol.</p>
                </div>
                <div class="modal-footer">
                    <button id="eliminarRolBtn" class="btn btn-outline-danger btn-sm">Eliminar</button>
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
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            @if (Session::has('success'))
                toastr.success("{{ session('success') }}");
            @endif

            @if (Session::has('error'))
                toastr.error("{{ session('error') }}");
            @endif
        })(jQuery);
    </script>
    <script src="{{ asset('js/roles/roles.js') }}"></script>

    <!--Permisos-->

    <script>
        var canEditarRol =
            @can('editar-rol', $roles)
                true
            @else
                false
            @endcan ;
        var mensajeNoTienesPermiso = '';
    </script>

    <script>
        var canEliminarRol =
            @can('borrar-rol', $roles)
                true
            @else
                false
            @endcan ;
        var mensajeNoTienesPermiso = '';
    </script>

@stop
