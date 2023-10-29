<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdResponsableToActividad extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('actividad', function (Blueprint $table) {
            $table->foreignId('id_responsable')->constrained('equipo_trabajo')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('actividad', function (Blueprint $table) {
            $table->dropColumn(['id_responsable']);
        });
    }
}
