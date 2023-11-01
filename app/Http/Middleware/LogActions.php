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
            $usuario = auth()->user();
            $usuarioNombre = $usuario->name . ' ' . $usuario->last_name;
            $contextoEvento = $this->getContextoEvento($request);
            $nombreEvento = $this->getNombreEvento($request);
    
            // Verificar si los campos no están vacíos
            if (!empty($usuarioNombre) && !empty($contextoEvento) && !empty($nombreEvento)) {
                // Registrar la acción en la tabla de bitácora
                $bitacora = new Bitacora();
                $bitacora->usuario = $usuarioNombre;
                $bitacora->contexto_Evento = $contextoEvento;
                $bitacora->nombre_Evento = $nombreEvento;
                $bitacora->hora_accion = now();
                $bitacora->ip_Equipo = $request->ip();
                $bitacora->save();
            }
        }

        return $response;
    }

    //Método para obtener el nombre de la acción realizada
    /*private function getNombreEvento($request){
        switch ($request->route()->getName()) {
            
            //Inicio al sistema
                case 'home':
                    return 'Ver Inicio';
            //}
            
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
            //}
            
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
            //}

            //Perfil Usuario
                case 'perfil':
                    return 'Ver Perfil';
                case 'deshabilitarFA':
                    return 'Deshabilitar Factor de Autenticación';
                case 'habilitarFA':
                    return 'Habilitar Factor de Autenticación';
                case 'perfil.updateInfo':
                    return 'Actualizar Información de Perfil';
                case 'perfil.updatePass':
                    return 'Actualizar Contraseña en Perfil';
            //}

            //Clientes
                case 'clientes.index':
                    return 'Ver Clientes';
                case 'clientes.create':
                    return 'Crear Cliente';
                case 'clientes.store':
                    return 'Guardar Cliente';
                case 'clientes.edit':
                    return 'Editar Cliente';
                case 'clientes.update':
                    return 'Actualizar Cliente';
                case 'clientes.destroy':
                    return 'Eliminar Cliente';
            //}
            
            //Contactos
                case 'contactos.index':
                    return 'Ver Contactos del Cliente';
                case 'contactos.create':
                    return 'Crear Contacto del Cliente';
                case 'contactos.store':
                    return 'Guardar Contacto del Cliente';
                case 'contactos.edit':
                    return 'Editar Contacto del Cliente';
                case 'contactos.update':
                    return 'Actualizar Contacto del Cliente';
                case 'contactos.destroy':
                    return 'Eliminar Contacto del Cliente';
            //}
            
            //Proyectos
                case 'proyectos.index':
                    return 'Ver Proyectos';
                case 'proyectos.create':
                    return 'Crear Proyecto';
                case 'proyectos.store':
                    return 'Guardar Proyecto';
                case 'proyectos.show':
                    return 'Ver Detalles del Proyecto';
                case 'proyectos.edit':
                    return 'Editar Proyecto';
                case 'proyectos.update':
                    return 'Actualizar Proyecto';
                case 'proyectos.destroy':
                    return 'Eliminar Proyecto';
                case 'proyectos.backup':
                    return 'Crear Respaldo del Proyecto';
                case 'proyectos.revision':
                    return 'Enviar a Revisión el Proyecto';
                case 'proyectos.aprobar':
                    return 'Aprobar Proyecto';
                case 'proyectos.rechazar':
                    return 'Rechazar Proyecto';
                case 'proyectos.iniciar':
                    return 'Iniciar Proyecto';
                case 'proyectos.finalizar':
                    return 'Finalizar Proyecto';
            //}

            //Documentos
                case 'documentos.index':
                    return 'Ver Documentos del Proyecto';
                case 'documentos.create':
                    return 'Crear Documento del Proyecto';
                case 'documentos.store':
                    return 'Guardar Documento del Proyecto';
                case 'documentos.edit':
                    return 'Editar Documento del Proyecto';
                case 'documentos.update':
                    return 'Actualizar Documento del Proyecto';
                case 'documentos.destroy':
                    return 'Eliminar Documento del Proyecto';
            //}

            //Mano de obra
                case 'miembros.index':
                    return 'Ver Miembros';
                case 'miembros.create':
                    return 'Crear Mano de Obra';
                case 'miembros.store':
                    return 'Guardar Mano de Obra';
                case 'miembros.edit':
                    return 'Editar Mano de Obra';
                case 'miembros.update':
                    return 'Actualizar Mano de Obra';
                case 'miembros.destroy':
                    return 'Eliminar Mano de Obra';
            //}

            //Recursos
                case 'recursos.index':
                    return 'Ver Recursos';
                case 'recursos.create':
                    return 'Crear Recurso';
                case 'recursos.store':
                    return 'Guardar Recurso';
                case 'recursos.edit':
                    return 'Editar Recurso';
                case 'recursos.update':
                    return 'Actualizar Recurso';
                case 'recursos.destroy':
                    return 'Eliminar Recurso';
            //}

            //Asignacion Recursos
                case 'asignacionrecurso.crear':
                    return 'Crear Asignación de Recurso para Actividad';
                case 'asignacionrecurso.destroy':
                    return 'Eliminar Asignación de Recurso de Actividad';
                case 'asignacionrecurso.edit':
                    return 'Editar Asignación de Recurso para Actividad';
                case 'asignacionrecurso.update':
                    return 'Actualizar Asignación de Recurso para Actividad';
            //}

            //Actividades
                case 'actividades.index':
                    return 'Ver Actividades';
                case 'actividades.create':
                    return 'Crear Actividad';
                case 'actividades.store':
                    return 'Guardar Actividad';
                case 'actividades.edit':
                    return 'Editar Actividad';
                case 'actividades.update':
                    return 'Actualizar Actividad';
                case 'actividades.destroy':
                    return 'Eliminar Actividad';
                case 'actividades.enviarRecordatorio':
                    return 'Enviar Recordatorio de Actividades';
            //}

            //Comentarios
                case 'comentarios.index':
                    return 'Ver Comentarios';
                case 'comentarios.create':
                    return 'Crear Comentario';
                case 'comentarios.store':
                    return 'Guardar Comentario';
                case 'comentarios.edit':
                    return 'Editar Comentario';
                case 'comentarios.update':
                    return 'Actualizar Comentario';
                case 'comentarios.destroy':
                    return 'Eliminar Comentario';
            //}

            //EqipoTrabajo
                case 'equipos.crearEquiposTrabajo':
                    return 'Crear Equipo de Trabajo del Proyecto';
                case 'equipos.eliminarEquipos':
                    return 'Eliminar Equipos de Trabajo del Proyecto';
            //}

            //calendario
                case 'calendario.consultarActividad':
                    return 'Consultar Actividad en el Calendario';
                case 'calendario.GuardarEvento':
                    return 'Agregar Evento al Calendario';
                case 'calendario.consultarEvento':
                    return 'Consultar Evento en el Calendario';
                case 'calendario.actualizarEvento':
                    return 'Actualizar Evento en el Calendario';
                case 'calendario.eliminarEvento':
                    return 'Eliminar Evento del Calendario';
            //}

            //Reportes
                case 'reportes.informeGasto':
                    return 'Ver Informe de gastos del proyecto';
                case 'reportes.informeSeguimiento':
                    return 'Ver Informe de seguimiento del proyecto';
            //}
                
            default:
                return '';
        }
    }*/

    private function getNombreEvento($request){
        $routes = [
            'home' => 'Ver Inicio',

            'roles.index' => 'Ver Roles',
            'roles.create' => 'Crear Rol',
            'roles.store' => 'Guardar Rol',
            'roles.edit' => 'Editar Rol',
            'roles.update' => 'Actualizar Rol',
            'roles.destroy' => 'Eliminar Rol',

            'usuarios.index' => 'Ver Usuarios',
            'usuarios.create' => 'Crear Usuario',
            'usuarios.store' => 'Guardar Usuario',
            'usuarios.edit' => 'Editar Usuario',
            'usuarios.update' => 'Actualizar Usuario',
            'usuarios.destroy' => 'Eliminar Usuario',

            'perfil' => 'Ver Perfil',
            'deshabilitarFA' => 'Deshabilitar Factor de Autenticación',
            'habilitarFA' => 'Habilitar Factor de Autenticación',
            'perfil.updateInfo' => 'Actualizar Información de Perfil',
            'perfil.updatePass' => 'Actualizar Contraseña en Perfil',

            'clientes.index' => 'Ver Clientes',
            'clientes.create' => 'Crear Cliente',
            'clientes.store' => 'Guardar Cliente',
            'clientes.edit' => 'Editar Cliente',
            'clientes.update' => 'Actualizar Cliente',
            'clientes.destroy' => 'Eliminar Cliente',

            'contactos.index' => 'Ver Contactos del Cliente',
            'contactos.create' => 'Crear Contacto del Cliente',
            'contactos.store' => 'Guardar Contacto del Cliente',
            'contactos.edit' => 'Editar Contacto del Cliente',
            'contactos.update' => 'Actualizar Contacto del Cliente',
            'contactos.destroy' => 'Eliminar Contacto del Cliente',

            'proyectos.index' => 'Ver Proyectos',
            'proyectos.create' => 'Crear Proyecto',
            'proyectos.store' => 'Guardar Proyecto',
            'proyectos.show' => 'Ver Detalles del Proyecto',
            'proyectos.edit' => 'Editar Proyecto',
            'proyectos.update' => 'Actualizar Proyecto',
            'proyectos.destroy' => 'Eliminar Proyecto',
            'proyectos.backup' => 'Crear Respaldo del Proyecto',
            'proyectos.revision' => 'Enviar a Revisión el Proyecto',
            'proyectos.aprobar' => 'Aprobar Proyecto',
            'proyectos.rechazar' => 'Rechazar Proyecto',
            'proyectos.iniciar' => 'Iniciar Proyecto',
            'proyectos.finalizar' => 'Finalizar Proyecto',

            'documentos.index' => 'Ver Documentos del Proyecto',
            'documentos.create' => 'Crear Documento del Proyecto',
            'documentos.store' => 'Guardar Documento del Proyecto',
            'documentos.edit' => 'Editar Documento del Proyecto',
            'documentos.update' => 'Actualizar Documento del Proyecto',
            'documentos.destroy' => 'Eliminar Documento del Proyecto',

            'miembros.index' => 'Ver Miembros',
            'miembros.create' => 'Crear Mano de Obra',
            'miembros.store' => 'Guardar Mano de Obra',
            'miembros.edit' => 'Editar Mano de Obra',
            'miembros.update' => 'Actualizar Mano de Obra',
            'miembros.destroy' => 'Eliminar Mano de Obra',

            'recursos.index' => 'Ver Recursos',
            'recursos.create' => 'Crear Recurso',
            'recursos.store' => 'Guardar Recurso',
            'recursos.edit' => 'Editar Recurso',
            'recursos.update' => 'Actualizar Recurso',
            'recursos.destroy' => 'Eliminar Recurso',

            'asignacionrecurso.crear' => 'Crear Asignación de Recurso para Actividad',
            'asignacionrecurso.destroy' => 'Eliminar Asignación de Recurso de Actividad',
            'asignacionrecurso.edit' => 'Editar Asignación de Recurso para Actividad',
            'asignacionrecurso.update' => 'Actualizar Asignación de Recurso para Actividad',

            'actividades.index' => 'Ver Actividades',
            'actividades.create' => 'Crear Actividad',
            'actividades.store' => 'Guardar Actividad',
            'actividades.edit' => 'Editar Actividad',
            'actividades.update' => 'Actualizar Actividad',
            'actividades.destroy' => 'Eliminar Actividad',
            'actividades.enviarRecordatorio' => 'Enviar Recordatorio de Actividades',

            'comentarios.index' => 'Ver Comentarios',
            'comentarios.create' => 'Crear Comentario',
            'comentarios.store' => 'Guardar Comentario',
            'comentarios.edit' => 'Editar Comentario',
            'comentarios.update' => 'Actualizar Comentario',
            'comentarios.destroy' => 'Eliminar Comentario',

            'equipos.crearEquiposTrabajo' => 'Crear Equipo de Trabajo del Proyecto',
            'equipos.eliminarEquipos' => 'Eliminar Equipos de Trabajo del Proyecto',

            'calendario.consultarActividad' => 'Consultar Actividad en el Calendario',
            'calendario.GuardarEvento' => 'Agregar Evento al Calendario',
            'calendario.consultarEvento' => 'Consultar Evento en el Calendario',
            'calendario.actualizarEvento' => 'Actualizar Evento en el Calendario',
            'calendario.eliminarEvento' => 'Eliminar Evento del Calendario',

            'reportes.informeGasto' => 'Ver Informe de gastos del proyecto',
            'reportes.informeSeguimiento' => 'Ver Informe de seguimiento del proyecto'
        ];
    
        $routeName = $request->route()->getName();
    
        return $routes[$routeName] ?? '';
    }
    
    //Método para obtener pantalla donde se hizo la acción
    private function getContextoEvento($request){
        $nombresTablas = [
            'home' => 'Inicio del Sitio',

            'roles.index' => 'Roles',
            'roles.create' => 'Roles',
            'roles.store' => 'Roles',
            'roles.edit' => 'Roles',
            'roles.update' => 'Roles',
            'roles.destroy' => 'Roles',

            'usuarios.index' => 'Usuarios',
            'usuarios.create' => 'Usuarios',
            'usuarios.store' => 'Usuarios',
            'usuarios.edit' => 'Usuarios',
            'usuarios.update' => 'Usuarios',
            'usuarios.destroy' => 'Usuarios',

            'perfil' => 'Perfil',
            'deshabilitarFA' => 'Perfil',
            'habilitarFA' => 'Perfil',
            'perfil.updateInfo' => 'Perfil',
            'perfil.updatePass' => 'Perfil',

            'clientes.index' => 'Clientes',
            'clientes.create' => 'Clientes',
            'clientes.store' => 'Clientes',
            'clientes.edit' => 'Clientes',
            'clientes.update' => 'Clientes',
            'clientes.destroy' => 'Clientes',

            'contactos.index' => 'Contactos',
            'contactos.create' => 'Contactos',
            'contactos.store' => 'Contactos',
            'contactos.edit' => 'Contactos',
            'contactos.update' => 'Contactos',
            'contactos.destroy' => 'Contactos',

            'proyectos.index' => 'Proyectos',
            'proyectos.create' => 'Proyectos',
            'proyectos.store' => 'Proyectos',
            'proyectos.show' => 'Proyectos',
            'proyectos.edit' => 'Proyectos',
            'proyectos.update' => 'Proyectos',
            'proyectos.destroy' => 'Proyectos',
            'proyectos.backup' => 'Proyectos',
            'proyectos.revision' => 'Proyectos',
            'proyectos.aprobar' => 'Proyectos',
            'proyectos.rechazar' => 'Proyectos',
            'proyectos.iniciar' => 'Proyectos',
            'proyectos.finalizar' => 'Proyectos',

            'documentos.index' => 'Documentos',
            'documentos.create' => 'Documentos',
            'documentos.store' => 'Documentos',
            'documentos.edit' => 'Documentos',
            'documentos.update' => 'Documentos',
            'documentos.destroy' => 'Documentos',

            'miembros.index' => 'Miembros',
            'miembros.create' => 'Miembros',
            'miembros.store' => 'Miembros',
            'miembros.edit' => 'Miembros',
            'miembros.update' => 'Miembros',
            'miembros.destroy' => 'Miembros',

            'recursos.index' => 'Recursos',
            'recursos.create' => 'Recursos',
            'recursos.store' => 'Recursos',
            'recursos.edit' => 'Recursos',
            'recursos.update' => 'Recursos',
            'recursos.destroy' => 'Recursos',

            'asignacionrecurso.crear' => 'Asignación Recurso',
            'asignacionrecurso.destroy' => 'Asignación Recurso',
            'asignacionrecurso.edit' => 'Asignación Recurso',
            'asignacionrecurso.update' => 'Asignación Recurso',

            'actividades.index' => 'Actividades',
            'actividades.create' => 'Actividades',
            'actividades.store' => 'Actividades',
            'actividades.edit' => 'Actividades',
            'actividades.update' => 'Actividades',
            'actividades.destroy' => 'Actividades',
            'actividades.enviarRecordatorio' => 'Actividades',

            'comentarios.index' => 'Comentarios',
            'comentarios.create' => 'Comentarios',
            'comentarios.store' => 'Comentarios',
            'comentarios.edit' => 'Comentarios',
            'comentarios.update' => 'Comentarios',
            'comentarios.destroy' => 'Comentarios',

            'equipos.crearEquiposTrabajo' => 'Equipos',
            'equipos.eliminarEquipos' => 'Equipos',

            'calendario.consultarActividad' => 'Calendario',
            'calendario.GuardarEvento' => 'Evento',
            'calendario.consultarEvento' => 'Evento',
            'calendario.actualizarEvento' => 'Evento',
            'calendario.eliminarEvento' => 'Evento',

            'reportes.informeGasto' => 'Informe de gastos',
            'reportes.informeSeguimiento' => 'Informe de seguimiento'

        ];
        $nombreTabla = $nombresTablas[$request->route()->getName()] ?? '';
        return $nombreTabla;
    }

}
