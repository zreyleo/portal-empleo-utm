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
            $table->string('email')->unique();
            $table->string('telefono')->unique();
            $table->text('descripcion');
            $table->string('area');
            $table->enum('tipo', [0, 1]); // 1 = publica; 0 = privada
            $table->enum('estado', [0, 1])->default(1); // 1 = disponible; 0 = no disponible
            $table->foreignId('id_representante')->references('id')->on('nuevo_personal_externo');
            $table->unsignedBigInteger('actulizacion_por')->default(null)->nullable(); // id del docente responsable que actualiza la informacion
            $table->text('comentario')->default(null)->nullable(); // podria ser alguna observacion
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
