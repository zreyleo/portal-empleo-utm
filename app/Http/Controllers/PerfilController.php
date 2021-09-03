<?php

namespace App\Http\Controllers;

use App\Perfil;
use Illuminate\Http\Request;

class PerfilController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \App\Perfil  $perfil
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $estudiante = get_session_estudiante();

        $perfil = Perfil::where('personal_id', $estudiante['id_personal'])->first();

        // dd($perfil);

        if (!$perfil) {
            $perfil = Perfil::create([
                'personal_id' => $estudiante['id_personal']
            ]);
        }

        return view('perfiles.show')
            ->with('estudiante', $estudiante)
            ->with('perfil', $perfil);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Perfil  $perfil
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $estudiante = get_session_estudiante();
        $perfil = current_session_estudiante_has_perfil();

        return view('perfiles.edit')
            ->with('estudiante', $estudiante)
            ->with('perfil', $perfil);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Perfil  $perfil
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $perfil = current_session_estudiante_has_perfil();
        $estudiante = get_session_estudiante();

        if ($perfil->personal_id != $estudiante['id_personal']) {
            return redirect()->route('logout');
        }

        $perfil->cv_link = $request->cv;
        $perfil->description = $request->description;

        $perfil->save();

        return redirect()->route('perfil.show');
    }
}
