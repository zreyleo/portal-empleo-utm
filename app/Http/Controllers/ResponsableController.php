<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ResponsableController extends Controller
{
    private const ROLE = 'RESPONSABLE';

    public static function get_role()
    {
        return self::ROLE;
    }

    public static function get_docente_data()
    {
        $docente = [
            'id_personal' => Session::get('id_personal'),
            'nombres' => Session::get('nombres'),
            'id_escuela' => Session::get('id_escuela'),
            'id_facultad' => Session::get('id_facultad'),
            'role' => Session::get('role'),
        ];

        return $docente;
    }

    public function dashboard()
    {
        return view('responsables.dashboard')
            ->with('docente', self::get_docente_data());
    }
}
