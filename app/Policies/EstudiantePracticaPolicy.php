<?php

namespace App\Policies;

use App\EstudiantePractica;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EstudiantePracticaPolicy
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

    public function pass(?User $user, EstudiantePractica $estudiante_practica)
    {
        $estudiante = get_session_estudiante();

        return $estudiante['id_personal'] == $estudiante_practica->estudiante_id;
    }
}
