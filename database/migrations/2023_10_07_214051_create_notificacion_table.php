<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notificacion', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('leida'); // boolean not null
            $table->foreignId('id_tipo_notificacion')->constrained('tipo_notificacion')->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('id_proyecto')->nullable()->constrained('proyecto')->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('id_evento')->nullable()->constrained('evento')->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('id_paquete_actividades')->nullable()->constrained('paquete_actividades')->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('id_usuario')->constrained('users')->onDelete('restrict')->onUpdate('cascade');
            $table->timestamps(); // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notificacion'); // Elimina la tabla si existe
    }
}
