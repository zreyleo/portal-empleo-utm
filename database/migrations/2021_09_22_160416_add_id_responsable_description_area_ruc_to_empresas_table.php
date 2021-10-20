<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdResponsableDescriptionAreaRucToEmpresasTable extends Migration
{
    // protected $connection = 'DB_ppp_sistema_SCHEMA_portal_empleo';
    // protected $connection = 'DB_ppp_sistema_SCHEMA_public';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('DB_ppp_sistema_SCHEMA_public')->table('tbl_empresa', function (Blueprint $table) {
            $table->dropColumn(['ruc', 'nomenclatura', 'descripcion', 'area', 'registrado_por']);
        });

        Schema::connection('DB_ppp_sistema_SCHEMA_public')->table('tbl_empresa', function (Blueprint $table) {
            $table->string('ruc')->unique()->nullable();
            $table->string('nomenclatura')->unique()->nullable();
            $table->text('descripcion')->nullable();
            $table->unsignedBigInteger('area')->nullable();
            $table->unsignedBigInteger('registrado_por')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('tbl_empresa');
        Schema::connection('DB_ppp_sistema_SCHEMA_public')->table('tbl_empresa', function (Blueprint $table) {
            $table->dropColumn(['ruc', 'nomenclatura', 'descripcion', 'area', 'registrado_por']);
        });
    }
}
