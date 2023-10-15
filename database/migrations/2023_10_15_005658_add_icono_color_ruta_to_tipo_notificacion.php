<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIconoColorRutaToTipoNotificacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tipo_notificacion', function (Blueprint $table) {
            $table->string('icono', 255)->nullable();
            $table->string('color', 255)->nullable();
            $table->string('ruta', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tipo_notificacion', function (Blueprint $table) {
            $table->dropColumn(['icono', 'color', 'ruta']);
        });
    }
}
