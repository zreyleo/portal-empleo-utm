<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstudiantePracticasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estudiantes_practicas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('estudiante_id');
            $table->unsignedBigInteger('practica_id');
            $table->unsignedBigInteger('pasantia_id')->nullable();
            $table->timestamps();
            $table->foreign('practica_id')->references('id')->on('practicas')->onDelete('cascade');
            $table->unique(['estudiante_id', 'practica_id']);
            $table->foreign('pasantia_id')->references('id_pasantia')->on('public.tbl_pasantia');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('estudiantes_practicas');
    }
}
