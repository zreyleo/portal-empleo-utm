<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewPersonalExternosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nuevo_personal_externo', function (Blueprint $table) {
            $table->id();
            $table->string('cedula')->unique();
            $table->string('apellido_p');
            $table->string('apellido_m');
            $table->string('nombres');
            $table->string('titulo');
            $table->enum('genero', ['M', 'F']); // 0 = no disponible, 1 = disponible
            $table->enum('estado', [0, 1])->default(1); // 0 = no disponible, 1 = disponible
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
        Schema::dropIfExists('new_personal_externos');
    }
}
