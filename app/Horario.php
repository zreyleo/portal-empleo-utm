<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    public $timestamps = false;

    protected $connection = 'DB_ppp_sistema_SCHEMA_public';

    protected $table = 'tbl_horario';

    protected $primaryKey = 'id_horario';

    public function pasantia()
    {
        return $this->belongsTo(Pasantia::class, 'id_pasantia', 'id_pasantia');
    }
}
