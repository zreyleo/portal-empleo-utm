<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonalRol extends Model
{
    protected $connection = 'DB_db_sga_actual';

    protected $table = 'esq_roles.tbl_personal_rol';

    // protected $primaryKey = null;

    public function escuela()
    {
        return $this->belongsTo(Escuela::class, 'id_escuela', 'idescuela');
    }
}
