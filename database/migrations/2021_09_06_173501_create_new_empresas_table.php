<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewEmpresasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nuevas_empresas', function (Blueprint $table) {
            $table->id('id_empresa');
            $table->string('ruc')->unique();
            $table->string('nombre_empresa')->unique();
            $table->unsignedBigInteger('id_provincia');
            $table->unsignedBigInteger('id_canton');
            $table->unsignedBigInteger('id_parroquia');
            $table->string('direccion');
            $table->text('descripcion');
            $table->enum('tipo', [0, 1]); // 1 = publica; 0 = privada
            $table->string('telefono')->unique();
            $table->string('email')->unique();
            $table->foreignId('id_representante')->references('id')->on('nuevo_personal_externo');
            $table->enum('estado', [0, 1])->default(1); // 1 = disponible; 0 = no disponible
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
        Schema::dropIfExists('new_empresas');
    }
}
