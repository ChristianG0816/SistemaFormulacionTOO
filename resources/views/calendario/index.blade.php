@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
aqui iria el filtro y boton
@stop

@section('content')
    <div class="container">
        <div id="calendario">
        </div>
    </div>

    <!--Creación de modal para consultar la actividad que se presione -->
    
    <!-- Modal -->
    <div class="modal fade" id="actividad" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    <form action="" id="actividades">
                        <div class="form-group">
                            <label for="title">Nombre Actividad</label>
                            <input type="text" class="form-control" name="title" id="title" aria-describedby="helpId" placeholder="">
                            <label for="start">Fecha Inicio</label>
                            <input type="text" class="form-control" name="start" id="start" aria-describedby="helpId" placeholder="">
                            <label for="end">Fecha Fin</label>
                            <input type="text" class="form-control" name="end" id="end" aria-describedby="helpId" placeholder="">
                        </div>
                    </form>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="{{ asset('js/Calendario/calendario.js') }}"></script>

    <!--Establecer una url general-->
    <script type="text/javascript">
        var baseUrl = {!! json_encode(url('')) !!}
    </script>

@stop
