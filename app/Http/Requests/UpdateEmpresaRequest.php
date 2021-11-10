<?php

namespace App\Http\Requests;

use App\Empresa;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEmpresaRequest extends FormRequest
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
        $empresa = Empresa::find(get_session_empresa()['id_empresa']);

        return [
            'apellido_p' => 'required',
            'apellido_m' => 'required',
            'nombres' => 'required',
            'titulo' => 'required',
            'genero' => 'required',
            'direccion' => 'required',
            'telefono' => ['required', Rule::unique('DB_ppp_sistema_SCHEMA_public.tbl_empresa', 'telefono')->ignore(
                $empresa->id_empresa, 'id_empresa'
            )],
            'descripcion' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'apellido_p.required' => 'El apellido paterno es necesario',
            'apellido_m.required' => 'El apellido materno es necesario',
        ];
    }
}
