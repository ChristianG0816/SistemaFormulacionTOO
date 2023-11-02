<style>
    body {font-family: Arial, sans-serif;}
    h1 {color: #000;text-align: center;font-size: 14px;}
    h2 {color: #000E51;text-align: left;font-size: 12px;}
    table {width: 100%;border-collapse: collapse;font-size: 12px;border: 1px solid #DDDBDB;}
    table tr td {padding: 8px;border: 1px solid #DDDBDB;}
</style>
<body>
  <h1>Informe de Seguimiento del {{ $proyecto->nombre }}</h1>
  <h2>Detalles del proyecto</h2>
  <div class="row">
    <table class="general table-striped">
      <tbody>
        <tr>
          <td>Estado:</td>
          <td>{{ $proyecto->estado_proyecto->nombre }}</td>
        </tr>
        <tr>
          <td>Objetivo:</td>
          <td>{{ $proyecto->objetivo }}</td>
        </tr>
        <tr>
          <td>Descripción:</td>
          <td>{{ $proyecto->descripcion }}</td>
        </tr>
        <tr>
          <td>Fecha de inicio:</td>
          <td>{{ $proyecto->fecha_inicio }}</td>
        </tr>
        <tr>
          <td>Fecha de fin:</td>
          <td>{{ $proyecto->fecha_fin }}</td>
        </tr>
        <tr>
          <td>Prioridad:</td>
          <td>{{ $proyecto->prioridad }}</td>
        </tr>
        <tr>
          <td>Entregable:</td>
          <td>{{ $proyecto->entregable }}</td>
        </tr>
        <tr>
          <td>Gerente de Proyecto:</td>
          <td>{{ $proyecto->gerente_proyecto->name }} {{ $proyecto->gerente_proyecto->last_name }}</td>
        </tr>
        <tr>
          <td>Cliente:</td>
          <td>{{ $proyecto->cliente->usuario_cliente->name }} {{ $proyecto->cliente->usuario_cliente->last_name }}</td>
        </tr>
      </tbody>
    </table>
  </div>
  <br>
  <h2>Resumen de Actividades</h2>
  <div class="row">
    <table class="">
      <tbody>
        <tr>
          <th>Actividades Pendientes</th>
          <th>Actividades En Proceso</th>
          <th>Finalizadas Con Retraso</th>
          <th>Finalizadas A tiempo</th>
          <th>Actividades Finalizadas</th>
          <th>Total de Actividades</th>
        </tr>
        <tr>
          <td style="text-align: center;" >{{ $pendientes }}</td>
          <td style="text-align: center;" >{{ $enProceso }}</td>
          <td style="text-align: center;" >{{ $finalizadasConRetraso }}</td>
          <td style="text-align: center;" >{{ $finalizadasATiempo }}</td>
          <td style="text-align: center;" >{{ $finalizadas }}</td>
          <td style="text-align: center;" >{{ $totalActividades }}</td>
        </tr>
      </tbody>
  </table>
  </div>
  <br>
  <h2>Listado de Actividades</h2>
  <div class="row">
    <table class="">
        <thead>
            <tr>
                <th>Actividad</th>
                <th>Estado</th>
                <th>Responsable</th>
                <th>Prioridad</th>
                <th>Fecha Inicio</th>
                <th>Fecha Fin</th>
                <th>Observación</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($actividades as $actividad)
                <tr>
                    <td style="text-align: center;">{{ $actividad->nombre }}</td>
                    <td style="text-align: center;">{{ $actividad->nombre_estado }}</td>
                    <td style="text-align: center;">{{ $actividad->nombre_responsable }}</td>
                    <td style="text-align: center;">{{ $actividad->prioridad }}</td>
                    <td style="text-align: center;">{{ $actividad->fecha_inicio }}</td>
                    <td style="text-align: center;">{{ $actividad->fecha_fin }}</td>
                    <td style="text-align: center;">{{ $actividad->observacion }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
  <br>
  <h2>Seguimiento de Actividades de los colaboradores</h2>
  <div class="row">
    @foreach ($actividadesPorColaborador as $nombreResponsable => $actividades)
      @php
        $pendientes = 0;
        $enProceso = 0;
        $finalizadas = 0;
        $finalizadasATiempo = 0;
        $finalizadasConRetraso = 0;
        $totalActividades = 0;
      @endphp
      <table class="">
        <thead>
          <tr>
            <th colspan="6" style="text-align: center; font-weight:bold; background-color: #F8FDFF;">{{ $nombreResponsable }}</th>
          </tr>
          <tr>
              <td style="text-align: center; font-weight:bold">Actividad</td>
              <td style="text-align: center; font-weight:bold">Estado</td>
              <td style="text-align: center; font-weight:bold">Prioridad</td>
              <td style="text-align: center; font-weight:bold">Fecha Inicio</td>
              <td style="text-align: center; font-weight:bold">Fecha Fin</td>
              <td style="text-align: center; font-weight:bold">Observación</td>
          </tr>
        </thead>
        <tbody>
            @foreach ($actividades as $actividad)
                <tr>
                    <td style="text-align: center;">{{ $actividad->nombre }}</td>
                    <td style="text-align: center;">{{ $actividad->nombre_estado }}</td>
                    <td style="text-align: center;">{{ $actividad->prioridad }}</td>
                    <td style="text-align: center;">{{ $actividad->fecha_inicio }}</td>
                    <td style="text-align: center;">{{ $actividad->fecha_fin }}</td>
                    <td style="text-align: center;">{{ $actividad->observacion }}</td>
                </tr>
                @php
                if ($actividad->fecha_fin_real === null) {
                  if($actividad->id_estado_actividad == 1){
                    $pendientes++;
                  }else{
                    $enProceso++;
                  }
                } elseif ($actividad->fecha_fin >= $actividad->fecha_fin_real) {
                  $finalizadasATiempo++;
                  $finalizadas++;
                } else {
                  $finalizadasConRetraso++;
                  $finalizadas++;
                }
                $totalActividades++;
                @endphp
            @endforeach
        </tbody>
        <tfoot>
          <tr>
            <td style="text-align: center; font-weight:bold">Actividades Pendientes</td>
            <td style="text-align: center; font-weight:bold">Actividades En Proceso</td>
            <td style="text-align: center; font-weight:bold">Finalizadas Con Retraso</td>
            <td style="text-align: center; font-weight:bold">Finalizadas A tiempo</td>
            <td style="text-align: center; font-weight:bold">Actividades Finalizadas</td>
            <td style="text-align: center; font-weight:bold">Total de Actividades</td>
          </tr>
          <tr>
            <td style="text-align: center;" >{{ $pendientes }}</td>
            <td style="text-align: center;" >{{ $enProceso }}</td>
            <td style="text-align: center;" >{{ $finalizadasConRetraso }}</td>
            <td style="text-align: center;" >{{ $finalizadasATiempo }}</td>
            <td style="text-align: center;" >{{ $finalizadas }}</td>
            <td style="text-align: center;" >{{ $totalActividades }}</td>
          </tr>
        </tfoot>
    </table>
    <br>
    @endforeach
</div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>