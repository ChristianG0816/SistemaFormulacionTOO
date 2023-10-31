<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Bitacora;

class LogActions
{
    public function handle(Request $request, Closure $next){

        // Obtener la URL de la solicitud actual
        $url = $request->url();

        // Verificar si la URL coincide con la ruta que deseas omitir
        if ($url === route('login')) {
            return $next($request);
        }
        
        $response = $next($request);

        //Verificar si el usuario está autenticado
        if (auth()->check()) {
            // Registrar la acción en la tabla de bitácora
            $bitacora = new Bitacora();
            $bitacora->usuario = auth()->user()->name . ' ' . auth()->user()->last_name;
            $bitacora->contexto_Evento = $this->getContextoEvento($request);
            $bitacora->nombre_Evento = $this->getNombreEvento($request);
            $bitacora->hora_accion = now();
            $bitacora->ip_Equipo = $request->ip();
            $bitacora->save();
        }

        return $response;
    }

    //Método para obtener el nombre de la acción realizada
    private function getNombreEvento($request){
        switch ($request->route()->getName()) {
            //Inicio al sistema
            case 'home':
                return 'Ver Inicio';

            //Roles
            case 'roles.index':
                return 'Ver Roles';
            case 'roles.create':
                return 'Crear Rol';
            case 'roles.store':
                return 'Guardar Rol';
            case 'roles.edit':
                return 'Editar Rol';
            case 'roles.update':
                return 'Actualizar Rol';
            case 'roles.destroy':
                return 'Eliminar Rol';
            
            //Usuarios
            case 'usuarios.index':
                return 'Ver Usuarios';
            case 'usuarios.create':
                return 'Crear Usuario';
            case 'usuarios.store':
                return 'Guardar Usuario';
            case 'usuarios.edit':
                return 'Editar Usuario';
            case 'usuarios.update':
                return 'Actualizar Usuario';
            case 'usuarios.destroy':
                return 'Eliminar Usuario';

            //Tablas gerenciales
            case 'proveedor.index':
                return 'Ver Proveedores';
            case 'insumo.index':
                return 'Ver Insumos';
            case 'empleado.index':
                return 'Ver Empleados';
            case 'servicio.index':
                return 'Ver Servicios';
            case 'venta.index':
                return 'Ver Ventas';
            case 'servicioInsumo.index':
                return 'Ver Insumos por Servicio';

            case 'proveedor.create':
                return 'Importar Datos para Proveedores';
            case 'insumo.create':
                return 'Importar Datos para Insumos';
            case 'empleado.create':
                return 'Importar Datos para Empleados';
            case 'servicio.create':
                return 'Importar Datos para Servicios';
            case 'venta.create':
                return 'Importar Datos para Ventas';
            case 'servicioInsumo.create':
                return 'Importar Datos para Insumos por Servicio';

            case 'proveedor.store':
                return 'Datos Importados en Proveedores';
            case 'insumo.store':
                return 'Datos Importados en Insumos';
            case 'empleado.store':
                return 'Datos Importados en Empleados';
            case 'servicio.store':
                return 'Datos Importados en Servicios';
            case 'venta.store':
                return 'Datos Importados en Ventas';
            case 'servicioInsumo.store':
                return 'Datos Importados en Insumos por Servicio';
            
            //Reportes
            case 'proyeccionVentas.index':
                return 'Ver Reporte de Proyecciones de Ventas';
            case 'margenBruto.index':
                return 'Ver Reporte del Margen Bruto de Ventas';
            case 'ventasEmpleado.index':
                return 'Ver Reporte de las Ventas Realizadas por Empleado';
            case 'tasaCrecimiento.index':
                return 'Ver Reporte de la Tasa de Crecimiento de las Ventas ';
            case 'ingresoServicio.index':
                return 'Ver Reporte de Ingresos Obtenidos por Servicio';
            
            //Bitacora
            case 'bitacora.index':
                return 'Ver Bitacora';
                
            default:
                return '';
        }
    }

    //Método para obtener pantalla donde se hizo la acción
    private function getContextoEvento($request){
        $nombresTablas = [
            //Inicio al sistema
            'home' => 'Inicio del Sitio',
            
            //Bitacora
            'bitacora.index' => 'Bitacora',

            //Roles
            'roles.index' => 'Roles',
            'roles.create' => 'Roles',
            'roles.store' => 'Roles',
            'roles.edit' => 'Roles',
            'roles.update' => 'Roles',
            'roles.destroy' => 'Roles',

            //Usuarios
            'usuarios.index' => 'Usuarios',
            'usuarios.create' => 'Usuarios',
            'usuarios.store' => 'Usuarios',
            'usuarios.edit' => 'Usuarios',
            'usuarios.update' => 'Usuarios',
            'usuarios.destroy' => 'Usuarios',

            //Tablas gerenciales
            'proveedor.index' => 'Proveedores',
            'insumo.index' => 'Insumos',
            'empleado.index' => 'Empleados',
            'servicio.index' => 'Servicios',
            'venta.index' => 'Ventas',
            'servicioInsumo.index' => 'Insumos por Servicio',

            'proveedor.create' => 'Proveedores',
            'insumo.create' => 'Insumos',
            'empleado.create' => 'Empleados',
            'servicio.create' => 'Servicios',
            'venta.create' => 'Ventas',
            'servicioInsumo.create' => 'Insumos por Servicio',

            'proveedor.store' => 'Proveedores',
            'insumo.store' => 'Insumos',
            'empleado.store' => 'Empleados',
            'servicio.store' => 'Servicios',
            'venta.store' => 'Ventas',
            'servicioInsumo.store' => 'Insumos por Servicio',

            //Reportes
            'proyeccionVentas.index' => 'Reporte de Proyecciones de Ventas',
            'margenBruto.index' => 'Reporte del Margen Bruto de Ventas',
            'ventasEmpleado.index' => 'Reporte de las Ventas Realizadas por Empleado',
            'tasaCrecimiento.index' => 'Reporte de la Tasa de Crecimiento de las Ventas ',
            'ingresoServicio.index' => 'Reporte de Ingresos Obtenidos por Servicio',

        ];
        $nombreTabla = $nombresTablas[$request->route()->getName()] ?? '';
        return $nombreTabla;
    }

}
