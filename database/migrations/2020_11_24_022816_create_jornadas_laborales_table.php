<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJornadasLaboralesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jornadas_laborales', function (Blueprint $table) {
            $table->increments('id');
            $table->date('fecha');
            //08:00,12:00,14:00,17:00
            $table->string('horasTrabajos');
            
            $table->unsignedBigInteger('empleado_id')->nullable();
            $table->foreign('empleado_id')->references('id')->on('empleados');

            $table->unsignedBigInteger('solicitudInacistencia_id')->nullable();
            $table->foreign('solicitudInacistencia_id')->references('id')->on('solicitudes_inacistencias');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jornadas_laborales');
    }
}
