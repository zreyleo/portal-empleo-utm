<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNewEmpresaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'cedula' => ['required', 'unique:nuevo_personal_externo,cedula', 'digits:10'], // regex para cedula
            'apellido_p' => 'required',
            'apellido_m' => 'required',
            'nombres' => 'required',
            'titulo' => 'required',
            'genero' => 'required',
            'ruc' => ['required', 'unique:nuevas_empresas,ruc', 'digits:13'], // regex para validar ruc
            'nombre_empresa' => 'required|unique:nuevas_empresas,nombre_empresa',
            'provincia' => 'required',
            'canton' => 'required',
            'parroquia' => 'required',
            'direccion' => 'required',
            'email' => ['required', 'unique:nuevas_empresas,email', 'email'],
            'telefono' => ['required', 'unique:nuevas_empresas,telefono'],
            'descripcion' => 'required',
            'area' => 'required',
            'tipo' => 'required',
        ];
    }
}
