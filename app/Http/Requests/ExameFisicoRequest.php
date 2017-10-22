<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExameFisicoRequest extends FormRequest
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
            'altura'=>'required|numeric',
            'peso'=>'required|numeric',
            'frenquenciaCardiaca'=>'required|numeric',
            'pressaoSistolica'=>'required|numeric',
            'pressaoDiastolica'=>'required|numeric',
            'observacoesGerais'=>'max:100'
        ];
    }
}
