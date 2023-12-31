<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDescripcionRutaToNotificacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notificacion', function (Blueprint $table) {
            $table->string('descripcion', 255)->nullable();
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
        Schema::table('notificacion', function (Blueprint $table) {
            $table->dropColumn(['descripcion','ruta']);
        });
    }
}
