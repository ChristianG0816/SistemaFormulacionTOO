<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProyectoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proyecto', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre', 255);
            $table->string('objetivo', 255);
            $table->text('descripcion');
            $table->string('entregable', 250);
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->float('presupuesto', 8, 2);
            $table->integer('prioridad');
            $table->timestamps(); // created_at, updated_at
            $table->foreignId('id_estado_proyecto')->constrained('estado_proyecto')->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('id_dueno')->constrained('users')->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('id_cliente')->constrained('users')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proyecto'); // Elimina la tabla si existe
    }
}
