<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProcedimentoRequest extends FormRequest
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
        $this->route('procedimento');

        if ($this->method() == 'PUT') {
            return [
                'nome' => 'required|min:2|max:30|unique:procedimentos,nome,'.$this->id.',id',
                'duracao' => 'required',
                'descricao' => 'required|max:30'
            ];
        } else{
            return [
                'nome' => 'required|min:2|max:30|unique:procedimentos',
                'duracao' => 'required',
                'descricao' => 'required|max:30'
            ];
        }
    }
}

