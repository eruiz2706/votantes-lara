<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCensoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('censo', function (Blueprint $table) {
            $table->increments('id');
            $table->varchar('nuid',30);
            $table->string('departamento',300)->nullable();
            $table->string('municipio',300)->nullable();
            $table->string('puesto',300)->nullable();
            $table->string('direccion',300)->nullable();
            $table->string('mesa',300)->nullable();
            $table->string('fecha_inscripcion',300)->nullable();
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
        Schema::dropIfExists('censo');
    }
}
