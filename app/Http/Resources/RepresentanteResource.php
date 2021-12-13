<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RepresentanteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id_personal_externo' => (int) $this->id_personal_externo,
            'cedula' => (int) $this->cedula,
            'nombres' => (string) $this->nombres,
            'apellido1' => (string) $this->apellido1,
            'apellido2' => (string) $this->apellido2,
            'titulo' => (string) $this->titulo,
            'genero' => (string) $this->genero,
        ];
    }
}
