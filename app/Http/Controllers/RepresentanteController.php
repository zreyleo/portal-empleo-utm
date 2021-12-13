<?php

namespace App\Http\Controllers;

use App\Http\Resources\RepresentanteResource;
use App\PersonalExterno;
use Illuminate\Http\Request;

class RepresentanteController extends Controller
{
    public function index()
    {

    }

    public function buscar($cedula)
    {
        $personalExterno = PersonalExterno::where('cedula', $cedula)->get()->first();

        $representante = new RepresentanteResource($personalExterno);

        return $representante;
    }
}
