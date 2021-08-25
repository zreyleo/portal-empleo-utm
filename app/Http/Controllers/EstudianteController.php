<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;

class EstudianteController extends Controller
{
    private const ROLE = 'ESTUDIANTE';

    public static function get_estudiante_data()
    {
        $estudiante = [
            'id_personal' => Session::get('id_personal'),
            'nombres' => Session::get('nombres'),
            'role' => Session::get('role'),
        ];

        return $estudiante;
    }

    public static function get_role()
    {
        return self::ROLE;
    }

    public function dashboard()
    {
        $estudiante = self::get_estudiante_data();
        return view('estudiantes.dashboard')
            ->with('estudiante', $estudiante);
    }
}
