<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquipoTrabajoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipo_trabajo', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('id_proyecto')->constrained('proyecto')->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('id_mano_obra')->constrained('mano_obra')->onDelete('restrict')->onUpdate('cascade');
            $table->timestamps(); // created_at, updated_at
            $table->unique(['id_proyecto', 'id_mano_obra']); // Para que no se repitan los registros
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('equipo_trabajo'); // Elimina la tabla si existe
    }
}

