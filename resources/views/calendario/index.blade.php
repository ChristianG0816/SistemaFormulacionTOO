@extends('adminlte::page')

@section('title', 'Calendario')

@section('content_header')
@stop

@section('content')
<div class="container">
    <div class="form-group" style="margin: 5px;"> 
        <label for="proyectoSelect">Seleccione un Proyecto:</label>
        <div class="input-group"> <!-- Usamos un elemento 'input-group' de Bootstrap -->
            <select class="form-control" id="proyectoSelect" style="margin: 5px;">
                <option value="0">Todos los proyectos</option>
                @foreach ($proyectos as $proyecto)
                    <option value="{{ $proyecto->id }}">{{ $proyecto->nombre }}</option>
                @endforeach
            </select>
            <!-- Agregamos el botón al lado del select -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#evento" id="btnCrearEvento">Crear Evento</button>
        </div>
    </div>
    <div id="calendario"></div>
</div>

    <!--Creación de modal para poder crear un evento por proyecto -->
    <div class="modal fade" id="evento" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Creación de Evento</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    
                    <form action="" id="eventos">
                        {!! csrf_field() !!}

                        <div class="form-group d-none">
                            <label for="id">ID:</label>
                            <input type="text" class="form-control" name="id" id="id" aria-describedby="helpId" placeholder="">
                        </div>

                        <div class="form-group">
                                
                            <div class="form-group">
                                <label for="nombre">Nombre:</label>
                                <input type="text" class="form-control" name="nombre" id="nombre" aria-describedby="helpId" placeholder="">
                                <div id="errorNombre" class="text-danger"></div>
                            </div>

                            <div class="form-group">
                                <label for="descripcion">Descripción:</label>
                                <input type="text" class="form-control" name="descripcion" id="descripcion" aria-describedby="helpId" placeholder="">
                                <div id="errorDes" class="text-danger"></div>
                            </div>
                            
                            <div class="form-group">
                                <label for="direccion">Dirección:</label>
                                <input type="text" class="form-control" name="direccion" id="direccion" aria-describedby="helpId" placeholder="">
                                <div id="errorDir" class="text-danger"></div>
                            </div>
                            
                            <label for="proyecto">Proyecto Asociado:</label>
                            <select class="form-control" name="proyecto" id="proyecto" disabled>
                                <option value="">Seleccione un proyecto</option>
                                @foreach($proyectos as $proyecto)
                                    <option value="{{ $proyecto->id }}">{{ $proyecto->nombre }}</option>
                                @endforeach
                            </select>

                            <div class="form-group">
                                <label for="fecha_inicio">Fecha Inicio</label>
                                <input type="date" class="form-control" name="fecha_inicio" id="fecha_inicio" aria-describedby="helpId" placeholder="">
                                <div id="errorFechaInicio" class="text-danger"></div>
                            </div>
                            
                            <div class="form-group">
                                <label for="fecha_fin">Fecha Fin</label>
                                <input type="date" class="form-control" name="fecha_fin" id="fecha_fin" aria-describedby="helpId" placeholder="">
                                <div id="errorFechaFin" class="text-danger"></div>
                            </div>
                            
                            <div class="form-group">
                                <label for="hora_inicio">Hora Inicio</label>
                                <input type="time" class="form-control" name="hora_inicio" id="hora_inicio" aria-describedby="helpId" placeholder="">
                                <div id="errorHoraInicio" class="text-danger"></div>
                            </div>

                            <div class="form-group">
                                <label for="hora_fin">Hora Fin</label>
                                <input type="time" class="form-control" name="hora_fin" id="hora_fin" aria-describedby="helpId" placeholder="">
                                <div id="errorHoraFin" class="text-danger"></div>
                            </div>

                            <div class="form-group">
                                <label label for="fecha_recordatorio">Fecha Recordatorio:</label>
                                <input type="date" class="form-control" name="fecha_recordatorio" id="fecha_recordatorio" aria-describedby="helpId" placeholder="">
                                <div id="errorFechaRecord" class="text-danger"></div>
                            </div>
                            
                            <div class="form-group">
                                <label for="link_reunion">Link de la reunión:</label>
                                <input type="text" class="form-control" name="link_reunion" id="link_reunion" aria-describedby="helpId" placeholder="">
                                <div id="errorlink" class="text-danger"></div>
                            </div>

                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="btnGuardar">Guardar</button>
                    <button type="button" class="btn btn-warning" id="btnModificar">Modificar</button>
                    <button type="button" class="btn btn-danger" id="btnEliminar" >Eliminar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!--Creación de modal para consultar la actividad que se presione -->
    
    <!-- Modal -->
    <div class="modal fade" id="actividad" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Datos de Actividad</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body custom-modal-body">
                    <form action="" id="actividades">
                        <p><strong>Nombre Paquete:</strong> <span id="titleForm"></span></p>
                        <p><strong>Proyecto:</strong> <span id="proyectoForm"></span></p>
                        <p><strong>Fecha Inicio:</strong> <span id="fechaInicioForm"></span></p>
                        <p><strong>Fecha Fin:</strong> <span id="fechaFinForm"></span></p>
                        <p><strong>Estado:</strong> <span id="estadoForm"></span></p>
                        <div class="form-group" id="diasRestantesDiv">
                            <p><strong id="dia">Dias Restantes:</strong> <span id="diaForm"></span></p>
                        </div>

                        <!-- Agregar un botón para redirigir a la actividad -->
                        <a href="#" id="btnRedirigir" class="btn btn-primary">Ir a la Actividad</a>

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

    <script src="{{ asset('js/Calendario/calendario.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <!--Establecer una url general-->
    <script type="text/javascript">
        var baseUrl = {!! json_encode(url('')) !!}
    </script>

@stop
