<?php

namespace App\Policies;

use App\EstudianteEmpleo;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EstudianteEmpleoPolicy
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

    public function pass(?User $user, EstudianteEmpleo $estudiante_empleo)
    {
        $estudiante = get_session_estudiante();

        return $estudiante_empleo->estudiante_id == $estudiante['id_personal'];
    }
}
