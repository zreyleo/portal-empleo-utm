<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstudiantePractica extends Model
{
    protected $connection = 'DB_ppp_sistema_SCHEMA_esq_portal_empleos';

    protected $table = 'estudiantes_practicas';

    protected $fillable = [
        'estudiante_id', 'practica_id'
    ];

    public function practica()
    {
        return $this->belongsTo(Practica::class);
    }

    public function pasantia()
    {
        return $this->belongsTo(Pasantia::class, 'pasantia_id', 'id_pasantia');
    }
}
