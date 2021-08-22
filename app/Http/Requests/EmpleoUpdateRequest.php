<?php

namespace App\Http\Requests;

use App\Http\Controllers\EmpresaController;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Support\Facades\Session;

class EmpleoUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Session::get('role') == EmpresaController::get_role();;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'titulo' => 'required|min:8',
            'requerimientos' => 'required',
            'carrera_id' => 'required',
        ];
    }
}
