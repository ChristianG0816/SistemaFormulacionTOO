<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

//spatie
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SeederTablaPermisos extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $roles = [
            Permission::create(['name' => 'ver-rol']),
            Permission::create(['name' => 'crear-rol']),
            Permission::create(['name' => 'editar-rol']),
            Permission::create(['name' => 'borrar-rol']),
        ];

        $proyectos = [
            Permission::create(['name' => 'ver-proyecto']),
            Permission::create(['name' => 'crear-proyecto']),
            Permission::create(['name' => 'exportar-proyecto']),
            Permission::create(['name' => 'editar-proyecto']),
            Permission::create(['name' => 'borrar-proyecto']),
            Permission::create(['name' => 'mostrar-proyecto']),
            Permission::create(['name' => 'backup-proyecto']),
            Permission::create(['name' => 'enviar-revision-proyecto']),
            Permission::create(['name' => 'aprobar-proyecto']),
            Permission::create(['name' => 'rechazar-proyecto']),
            Permission::create(['name' => 'iniciar-proyecto']),
            Permission::create(['name' => 'finalizar-proyecto']),
            Permission::create(['name' => 'ver-presupuesto-proyecto']),
        ];
        $documentos = [
            Permission::create(['name' => 'ver-documento']),
            Permission::create(['name' => 'crear-documento']),
            Permission::create(['name' => 'editar-documento']),
            Permission::create(['name' => 'borrar-documento']),
            Permission::create(['name' => 'ver-enlace-documento']),
        ];
        $clientes = [
            Permission::create(['name' => 'ver-cliente']),
            Permission::create(['name' => 'crear-cliente']),
            Permission::create(['name' => 'editar-cliente']),
            Permission::create(['name' => 'borrar-cliente']),
            Permission::create(['name' => 'exportar-cliente']),
        ];
        $contactos = [
            Permission::create(['name' => 'ver-contacto']),
            Permission::create(['name' => 'crear-contacto']),
            Permission::create(['name' => 'editar-contacto']),
            Permission::create(['name' => 'borrar-contacto']),
        ];
        $reportes = [
            Permission::create(['name' => 'ver-reporte']),
            Permission::create(['name' => 'exportar-reporte']),
            Permission::create(['name' => 'ver-informe-gastos-reporte']),
            Permission::create(['name' => 'ver-informe-seguimiento-reporte']),
        ];
        $miembros = [
            Permission::create(['name' => 'gestionar-miembro']),
            Permission::create(['name' => 'exportar-miembro']),
            Permission::create(['name' => 'ver-miembro']),
            Permission::create(['name' => 'crear-miembro']),
            Permission::create(['name' => 'editar-miembro']),
            Permission::create(['name' => 'borrar-miembro']),
        ];

        $actividades = [
            Permission::create(['name' => 'gestionar-actividad']),
            Permission::create(['name' => 'ver-actividad']),
            Permission::create(['name' => 'crear-actividad']),
            Permission::create(['name' => 'editar-actividad']),
            Permission::create(['name' => 'borrar-actividad']),
        ];

        $comentarios = [
            Permission::create(['name' => 'gestionar-comentario']),
            Permission::create(['name' => 'crear-comentario']),
            Permission::create(['name' => 'editar-comentario']),
            Permission::create(['name' => 'borrar-comentario']),
        ];

        $eventos = [
            Permission::create(['name' => 'crear-evento']),
            Permission::create(['name' => 'guardar-evento']),
            Permission::create(['name' => 'editar-evento']),
            Permission::create(['name' => 'borrar-evento']),
        ];

        $calendario = [
            Permission::create(['name' => 'ver-calendario']),
        ];
    
        $perfil = [
            Permission::create(['name' => 'ver-perfil']),
            Permission::create(['name' => 'editar-info-perfil']),
            Permission::create(['name' => 'cambiar-password-perfil']),
            Permission::create(['name' => 'habilitar-fa-perfil']),
            Permission::create(['name' => 'deshabilitar-fa-perfil']),
        ];

        $equipoTrabajo = [
            Permission::create(['name' => 'gestionar-equipo-trabajo']),
            Permission::create(['name' => 'crear-equipo-trabajo']),
            Permission::create(['name' => 'borrar-equipo-trabajo']),
        ];

        $recursos = [
            Permission::create(['name' => 'gestionar-recurso']),
            Permission::create(['name' => 'ver-recurso']),
            Permission::create(['name' => 'crear-recurso']),
            Permission::create(['name' => 'editar-recurso']),
            Permission::create(['name' => 'borrar-recurso']),
        ];

        $asignacionRecursos = [
            Permission::create(['name' => 'gestionar-asignacionRecurso']),
            Permission::create(['name' => 'ver-asignacionRecurso']),
            Permission::create(['name' => 'crear-asignacionRecurso']),
            Permission::create(['name' => 'editar-asignacionRecurso']),
            Permission::create(['name' => 'borrar-asignacionRecurso']),
        ];
        
      
        $roleAdministrador = Role::create(['name' => 'Administrador'])->givePermissionTo([
            $roles,
            $contactos,
            $clientes,
            $perfil,
            $recursos
        ]);

        $roleCliente = Role::create(['name' => 'Cliente'])->givePermissionTo([
            //Poyecto
            'ver-proyecto',
            'exportar-proyecto',
            'mostrar-proyecto',
            //Documento
            'ver-documento',
            'ver-enlace-documento',
            $calendario,
            $perfil
        ]);
        
        $roleSupervisor = Role::create(['name' => 'Supervisor'])->givePermissionTo([
            //Proyecto
            'ver-proyecto',
            'crear-proyecto',
            'exportar-proyecto',
            'editar-proyecto',
            'borrar-proyecto',
            'mostrar-proyecto',
            'backup-proyecto',
            'enviar-revision-proyecto',
            'iniciar-proyecto',
            'finalizar-proyecto',
            'ver-presupuesto-proyecto',
            //Documento
            'ver-documento',
            'crear-documento',
            'editar-documento',
            'borrar-documento',
            'ver-enlace-documento',
            $reportes,
            $clientes,
            $contactos,
            $comentarios,
            $actividades,
            $eventos,
            $calendario,
            $equipoTrabajo,
            $perfil,
            $asignacionRecursos
        ]);

        $roleGerente = Role::create(['name' => 'Gerente'])->givePermissionTo([
            //Proyecto
            'ver-proyecto',
            'exportar-proyecto',
            'mostrar-proyecto',
            'backup-proyecto',
            'aprobar-proyecto',
            'rechazar-proyecto',
            'ver-presupuesto-proyecto',
            //Documento
            'ver-documento',
            'ver-enlace-documento',
            $reportes,
            $clientes,
            $contactos,
            $miembros,
            $calendario,
            $perfil,
        ]);

        $roleColaborador = Role::create(['name' => 'Colaborador'])->givePermissionTo([
            //Proyecto
            'ver-proyecto',
            'mostrar-proyecto',
            $comentarios,
            $actividades,
            $calendario,
            $perfil

        ]);

    }
}
