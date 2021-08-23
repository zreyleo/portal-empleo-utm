<?php

namespace App\Policies;

use App\Practica;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PracticaPolicy
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

    public function pass(?User $user, Practica $practica)
    {
        $empresa = get_session_empresa();

        return $empresa['id_empresa'] == $practica->empresa_id;
    }
}
