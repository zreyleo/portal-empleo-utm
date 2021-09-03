<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    protected $connection = 'DB_ppp_sistema_SCHEMA_esq_portal_empleos';

    protected $table = 'perfiles';

    protected $fillable = [
        'personal_id', 'cv_link', 'description'
    ];

    public function personal()
    {
        return $this->belongsTo(Personal::class, 'personal_id', 'idpersonal');
    }
}
