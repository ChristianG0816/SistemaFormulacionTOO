<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipoDocumento;

class SeederTablaTipoDocumento extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tiposDocumentos = [
            TipoDocumento::create(['nombre' => 'Acta de Constitución del Proyecto']),
            TipoDocumento::create(['nombre' => 'Plan de Proyecto']),
            TipoDocumento::create(['nombre' => 'Matriz de Asignación de Responsabilidades (RAM)']),
            TipoDocumento::create(['nombre' => 'Cronograma de Proyecto']),
            TipoDocumento::create(['nombre' => 'Presupuesto del Proyecto']),
            TipoDocumento::create(['nombre' => 'Informe de Avance']),
            TipoDocumento::create(['nombre' => 'Plan de Gestión de Cambios']),
            TipoDocumento::create(['nombre' => 'Matriz de Comunicaciones']),
            TipoDocumento::create(['nombre' => 'Plan de Gestión de Riesgos']),
            TipoDocumento::create(['nombre' => 'Acta de Reunión']),
            TipoDocumento::create(['nombre' => 'Especificaciones del Producto']),
            TipoDocumento::create(['nombre' => 'Plan de Calidad del Proyecto']),
            TipoDocumento::create(['nombre' => 'Informe de Lecciones Aprendidas']),
            TipoDocumento::create(['nombre' => 'Matriz de Interesados']),
            TipoDocumento::create(['nombre' => 'Diagrama de Gantt']),
            TipoDocumento::create(['nombre' => 'Plan de Adquisiciones']),
            TipoDocumento::create(['nombre' => 'Plan de Recursos Humanos']),
            TipoDocumento::create(['nombre' => 'Evaluación de Impacto Ambiental']),
            TipoDocumento::create(['nombre' => 'Evaluación de Impacto Social']),
            TipoDocumento::create(['nombre' => 'Informe de Costos']),
            TipoDocumento::create(['nombre' => 'Plan de Entregables']),
            TipoDocumento::create(['nombre' => 'Diagrama de Flujo de Trabajo']),
            TipoDocumento::create(['nombre' => 'Memoria Técnica']),
            TipoDocumento::create(['nombre' => 'Manual de Usuario']),
            TipoDocumento::create(['nombre' => 'Acuerdo de Niveles de Servicio (SLA)']),
            TipoDocumento::create(['nombre' => 'Informe de Evaluación de Proveedores']),
            TipoDocumento::create(['nombre' => 'Informe de Gestión de Problemas']),
            TipoDocumento::create(['nombre' => 'Plan de Mantenimiento del Proyecto']),
            TipoDocumento::create(['nombre' => 'Diagrama de Casos de Uso']),
            TipoDocumento::create(['nombre' => 'Contrato de Proveedor']),
            TipoDocumento::create(['nombre' => 'Informe de Progreso']),
            TipoDocumento::create(['nombre' => 'Plan de Ejecución']),
            TipoDocumento::create(['nombre' => 'Informe de Evaluación de Riesgos']),
            TipoDocumento::create(['nombre' => 'Informe de Finalización']),
            TipoDocumento::create(['nombre' => 'Matriz de Roles y Responsabilidades']),
            TipoDocumento::create(['nombre' => 'Informe de Resultados']),
            TipoDocumento::create(['nombre' => 'Análisis de Factibilidad']),
            TipoDocumento::create(['nombre' => 'Informe de Impacto Económico']),
            TipoDocumento::create(['nombre' => 'Matriz de Seguimiento de Decisiones']),
            TipoDocumento::create(['nombre' => 'Informe de Viabilidad']),
            TipoDocumento::create(['nombre' => 'Plan de Seguridad y Salud en el Trabajo']),
            TipoDocumento::create(['nombre' => 'Informe de Evaluación Ambiental']),
            TipoDocumento::create(['nombre' => 'Matriz de Evaluación de Riesgos y Oportunidades']),
            TipoDocumento::create(['nombre' => 'Informe de Calidad']),
            TipoDocumento::create(['nombre' => 'Plan de Seguridad de la Información']),
            TipoDocumento::create(['nombre' => 'Informe de Impacto Social y Comunitario']),
            TipoDocumento::create(['nombre' => 'Matriz de Análisis de Interesados']),
            TipoDocumento::create(['nombre' => 'Informe de Conformidad y No Conformidad']),
            TipoDocumento::create(['nombre' => 'Plan de Capacitación']),
            TipoDocumento::create(['nombre' => 'Informe de Evaluación de Desempeño']),
            TipoDocumento::create(['nombre' => 'Matriz de Cumplimiento Normativo']),
            TipoDocumento::create(['nombre' => 'Informe de Seguimiento de Objetivos']),
            TipoDocumento::create(['nombre' => 'Informe de Costo-Beneficio']),
            TipoDocumento::create(['nombre' => 'Plan de Sostenibilidad']),
            TipoDocumento::create(['nombre' => 'Informe de Revisión por la Dirección']),
            TipoDocumento::create(['nombre' => 'Matriz de Evaluación de Proveedores']),
            TipoDocumento::create(['nombre' => 'Informe de Proyecciones Financieras']),
            TipoDocumento::create(['nombre' => 'Matriz de Evaluación de Impacto Ambiental']),
            TipoDocumento::create(['nombre' => 'Informe de Satisfacción del Cliente']),
            TipoDocumento::create(['nombre' => 'Plan de Resolución de Problemas']),
        ];
        
    }
}