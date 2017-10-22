<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AnamneseRequest extends FormRequest
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
            'queixaPrincipal'=>'required|max:80',
            'historia'=>'required|max:50',
            'problemasRenais'=>'required|max:50',
            'problemasArticulares'=>'required|max:50',
            'problemasCardiacos'=>'required|max:50',
            'problemasRespiratorios'=>'required|max:50',
            'problemasGastricos'=>'required|max:50',
            'alergias'=>'required',
            'hepatite'=>'required',
            'diabetes'=>'required',
            'usoMedicamento'=>'required|max:100',
        ];
    }
}
