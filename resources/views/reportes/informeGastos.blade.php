<style>
    body {font-family: Arial, sans-serif;}
    h1 {color: #000;text-align: center;font-size: 14px;}
    h2 {color: #000E51;text-align: left;font-size: 12px;}
    table {width: 100%;border-collapse: collapse;font-size: 12px;border: 1px solid #DDDBDB;}
    table tr td {padding: 8px;border: 1px solid #DDDBDB;}

</style>

<body>

  <h1>Informe de Gastos del Proyecto {{ $proyecto->nombre }}</h1>
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
          <td>Presupuesto:</td>
          <td>$ {{ $proyecto->presupuesto }}</td>
        </tr>
        <tr>
          <td>Gasto Total:</td>
          <td>$ {{ $gastoTotal }}</td>
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
  <h2>Recursos utilizados</h2>
  <div class="row">
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Cantidad</th>
                <th>Costo Unitario</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($recursos as $idRecurso => $asignaciones)
                @php
                    $recurso1 = $asignaciones->first()->recurso;
                    $cantidadTotal = $asignaciones->sum('cantidad');
                    $subtotalRecurso = $recurso1->costo * $cantidadTotal; // Corrección del cálculo del subtotal
                    $subtotalesRecursos[] = $subtotalRecurso;
                @endphp
                <tr>
                    <td>{{ $recurso1->nombre }}</td>
                    <td style="text-align: center;">{{ $cantidadTotal }}</td>
                    <td style="text-align: right;">$ {{ $recurso1->costo }}</td>
                    <td style="text-align: right;">$ {{ $subtotalRecurso }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="3">Total</td>
                <td style="text-align: right;">$ {{ array_sum($subtotalesRecursos) }}</td>
            </tr>
        </tbody>
    </table>
</div>
  </br>
<h2>Mano de obra</h2>
<div class="row">
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Profesión</th>
                <th>Subtotal</th>
                <!--<th>Subtotal</th>-->
            </tr>
        </thead>
        <tbody>
            @foreach ($manoDeObra as $manoObra)
                @php
                    $persona = $manoObra->mano_obra->persona;
                    $person = $manoObra->mano_obra->usuario;
                    $costo = $manoObra->mano_obra->costo_servicio;
                    $subtotal = $costo;
                    $subtotalesManoObra[] = $subtotal;
                @endphp
                <tr>
                    <td>{{ $person->name }}</td>
                    <td>{{ $person->last_name }}</td>
                    <td>{{ $persona->profesion }}</td>
                    <td style="text-align: right;">$ {{ $costo }}</td>
                    <!--<td style="text-align: right;">$ {{ $subtotal }}</td>-->
                </tr>
            @endforeach
            <tr>
                <td colspan="3">Total</td>
                <td style="text-align: right;">$ {{ array_sum($subtotalesManoObra) }}</td>
            </tr>
        </tbody>
    </table>
</div>
</br>
<h2>Recursos utilizados por actividad</h2>
<div class="row">
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Cantidad</th>
                <th>Costo Unitario</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @php
                $subtotalesActividad = [];
            @endphp
            @foreach ($recursosActividad as $recurso)
                <tr>
                    <td colspan="3" style="text-align: center; background-color: #F8FDFF;">Actividad - {{ $recurso['actividad']->nombre }}</td>
                    <td style="text-align: right; background-color: #F8FDFF;">
                        $ {{ $recurso['asignacionesRecursos']->sum(function ($asignacion) {return $asignacion->cantidad * $asignacion->recurso->costo;}) }}
                    </td>
                </tr>
                @foreach ($recurso['asignacionesRecursos'] as $asignacion)
                    @php
                        $subtotalActividad = $asignacion->cantidad * $asignacion->recurso->costo;
                        $subtotalesActividad[] = $subtotalActividad;
                    @endphp
                    <tr>
                        <td>{{ $asignacion->recurso->nombre }}</td>
                        <td style="text-align: center;">{{ $asignacion->cantidad }}</td>
                        <td style="text-align: right;">$ {{ $asignacion->recurso->costo }}</td>
                        <td style="text-align: right;">$ {{ $subtotalActividad }}</td>
                    </tr>
                @endforeach
            @endforeach
                <tr>
                    <td colspan="3">Total</td>
                    <td style="text-align: right;">$ {{ array_sum($subtotalesActividad) }}</td>
                </tr>
        </tbody>
    </table>
</div>

</body>