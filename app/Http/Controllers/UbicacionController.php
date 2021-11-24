<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UbicacionController extends Controller
{
    public function provincias()
    {
        $sql_provincias = '
            select idprovincia, nombre
            from view_provincia
            where idpais = 1
        ';

        $provincias = DB::connection('DB_ppp_sistema_SCHEMA_public')->select($sql_provincias);
        return $provincias;
    }

    public function cantones($provincia)
    {
        $sql_cantones = "
            select idcanton, nombre
            from view_canton
            where idprovincia = $provincia
        ";

        $cantones = DB::connection('DB_ppp_sistema_SCHEMA_public')->select($sql_cantones);
        return $cantones;
    }

    public function parroquias($provincia, $canton)
    {
        $sql_parroquias = "
            select idparroquia, nombre
            from view_parroquia
            where idcanton = $canton
        ";

        $parrquias = DB::connection('DB_ppp_sistema_SCHEMA_public')->select($sql_parroquias);
        return $parrquias;
    }
}
