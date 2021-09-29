<?php

namespace App\Http\Requests;

use App\Http\Controllers\ResponsableController;
use App\NewEmpresa;
use App\NewPersonalExterno;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class UpdateNewEmpresaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Session::get('role') == ResponsableController::get_role();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // dd($this->route('empresa'));

        $empresa = $this->route('empresa');

        // dd($empresa);

        return [
            // 'cedula' => ['required', 'unique:nuevo_personal_externo,cedula', 'digits:10'], // regex para cedula
            'cedula' => ['required', Rule::unique('nuevo_personal_externo', 'cedula')->ignore(
                $empresa->id_representante
            ), 'digits:10'], // regex para cedula

            'apellido_p' => 'required',
            'apellido_m' => 'required',
            'nombres' => 'required',
            'titulo' => 'required',
            'genero' => 'required',
            // 'ruc' => ['required', 'unique:nuevas_empresas,ruc', 'digits:13'], // regex para validar ruc

            'ruc' => ['required', Rule::unique('nuevas_empresas', 'ruc')->ignore(
                $empresa->id_empresa, 'id_empresa'
            ), 'digits:13'], // regex para validar ruc

            'nombre_empresa' => ['required', Rule::unique('nuevas_empresas', 'nombre_empresa')->ignore(
                $empresa->id_empresa, 'id_empresa'
            )],
            'provincia' => 'required',
            'canton' => 'required',
            'parroquia' => 'required',
            'direccion' => 'required',

            'email' => ['required', Rule::unique('nuevas_empresas', 'email')->ignore(
                $empresa->id_empresa, 'id_empresa'
            ), 'email'],

            'telefono' => ['required', Rule::unique('nuevas_empresas', 'telefono')->ignore(
                $empresa->id_empresa, 'id_empresa'
            )],

            'descripcion' => 'required',
            'area' => 'required',
            'tipo' => 'required',
        ];
    }
}
