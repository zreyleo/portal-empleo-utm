<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class EmpresaController extends Controller
{
    private const ROLE = 'EMPRESA';

    public static function get_empresa_data()
    {
        $empresa = [
            'id_empresa' => Session::get('id_empresa'),
            'nombre_empresa' => Session::get('nombre_empresa'),
        ];

        return $empresa;
    }
    public static function get_role()
    {
        return self::ROLE;
    }
}
