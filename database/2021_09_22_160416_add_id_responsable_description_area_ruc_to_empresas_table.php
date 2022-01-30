<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdResponsableDescriptionAreaRucToEmpresasTable extends Migration
{
    public function up()
    {
        // Schema::connection('DB_ppp_sistema_SCHEMA_public')->table('tbl_empresa', function (Blueprint $table) {
        //     $table->dropColumn(['password', 'ruc', 'nomenclatura', 'descripcion', 'area', 'registrado_por']);
        // });
        Schema::connection('DB_ppp_sistema_SCHEMA_public')->table('tbl_empresa', function (Blueprint $table) {
            $table->string('password')->nullable();
            $table->string('ruc')->unique()->nullable();
            $table->boolean('departamento_interno')->default(false);
            $table->text('descripcion')->nullable();
            $table->unsignedBigInteger('area')->nullable();
            $table->unsignedBigInteger('registrado_por')->nullable();
        });
    }

    public function down()
    {
        Schema::connection('DB_ppp_sistema_SCHEMA_public')->table('tbl_empresa', function (Blueprint $table) {
            $table->dropColumn(['password', 'ruc', 'departamento_interno', 'descripcion', 'area', 'registrado_por']);
        });
    }
}
