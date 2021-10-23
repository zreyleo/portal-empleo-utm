<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDepartamentoRequest extends FormRequest
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
            'cedula' => ['required', 'unique:DB_ppp_sistema_SCHEMA_public.tbl_personal_externo,cedula', 'digits:10'], // regex para cedula
            'apellido_p' => 'required',
            'apellido_m' => 'required',
            'nombres' => 'required',
            'titulo' => 'required',
            'genero' => 'required',
            'nombre_empresa' => 'required|unique:DB_ppp_sistema_SCHEMA_public.tbl_empresa,nombre_empresa',
            'nomenclatura' => 'unique:DB_ppp_sistema_SCHEMA_public.tbl_empresa,nomenclatura',
            'email' => ['required', 'unique:DB_ppp_sistema_SCHEMA_public.tbl_empresa,email', 'email'],
            'telefono' => ['unique:DB_ppp_sistema_SCHEMA_public.tbl_empresa,telefono'],
            'descripcion' => 'required',
        ];
    }

    public function messages(){

        return [
            'nombre_empresa.required' => 'El nombre de departamento es necesario',
            'nombre_empresa.unique' => 'El nombre de departamento ya esta en uso',
            'email.required' => 'El email del departamento es necesario',
        ];
    }
}
