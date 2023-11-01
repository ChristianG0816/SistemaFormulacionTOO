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
    <table class="general">
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
  </br>
  <h2>Resumen de Actividades</h2>
  <div class="row">
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Estado</th>
                <th>Responsable</th>
                <th>Prioridad</th>
                <th>Fecha Inicio</th>
                <th>Fecha Fin Prevista</th>
                <th>Fecha Fin Real</th>
                <th>Finalización</th>
            </tr>
        </thead>
        <tbody>
            @php
            @endphp
            @foreach ($actividades as $actividad)
                <tr>
                    <td style="text-align: center;">{{ $actividad->nombre }}</td>
                    <td style="text-align: center;">{{ $actividad->nombre_estado }}</td>
                    <td style="text-align: center;">{{ $actividad->nombre_responsable }}</td>
                    <td style="text-align: center;">{{ $actividad->prioridad }}</td>
                    <td style="text-align: center;">{{ $actividad->fecha_inicio }}</td>
                    <td style="text-align: center;">{{ $actividad->fecha_fin }}</td>
                    <td style="text-align: center;">{{ $actividad->fecha_fin_real }}</td>
                    <td style="text-align: center;">{{ $actividad->estado_finalizacion }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
  </br>
  <div class="row">
    <table>
        <tbody>
            <tr>
                <td colspan="2" style="text-align: center;">Actividades Pendientes</td>
                <td colspan="2" style="text-align: center;">{{ $pendientes }}</td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center;">Actividades En Proceso</td>
                <td colspan="2" style="text-align: center;">{{ $enProceso }}</td>
            </tr>
            <tr>
                <td rowspan="2" style="text-align: center;">Actividades Finalizadas</td>
                <td rowspan="2" style="text-align: center;">{{ $finalizadas }}</td>
                <td style="text-align: center;">Finalizadas Con retraso</td>
                <td style="text-align: center;">{{ $finalizadasConRetraso }}</td>
            </tr>
            <tr>
                <td style="text-align: center;">Finalizadas A tiempo</td>
                <td style="text-align: center;">{{ $finalizadasATiempo }}</td>
            </tr>
        </tbody> 

    </table>
    
  </div>

</body>