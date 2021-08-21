<?php

namespace App\Policies;

use App\Empleo;
use App\Empresa;
use App\User;

use Illuminate\Auth\Access\HandlesAuthorization;

class EmpleoPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    // public function pass(User $user, Empleo $empleo)
    // {
    //     $empresa = get_session_empresa();
    //     // dd($empresa);

    //     return $empresa['id_empresa'] == $empleo->empresa_id;
    // }

    public function show(?User $user, Empleo $empleo)
    {
        $empresa_data = get_session_empresa();
        // $empresa = Empresa::find($empresa_data['id_empresa']);
        // dd($empresa);

        return $empresa_data['id_empresa'] == $empleo->empresa_id;
    }
}
