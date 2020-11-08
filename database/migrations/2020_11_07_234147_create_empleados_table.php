<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpleadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empleados', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->string('apellido');
            $table->string('cuil');
            $table->date('fechaNacimiento');
            $table->date('fechaAlta');
            $table->date('fechaBaja');
            $table->string('direccion');

            $table->unsignedBigInteger('puesto_id');
            $table->foreign('puesto_id')->references('id')->on('puestos');
            $table->unsignedBigInteger('convenio_id');
            $table->foreign('convenio_id')->references('id')->on('convenios');
            

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
        Schema::dropIfExists('empleados');
    }
}
