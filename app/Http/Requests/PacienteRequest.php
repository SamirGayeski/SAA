<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PacienteRequest extends FormRequest
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
        $this->route('paciente');

        if ($this->method() == 'PUT') {
            return [
                'nome' => 'required|min:2|max:70',
                'dataNascimento' => 'required|date|before:'.\Carbon\Carbon::now().'',
                'email' => 'required|email|max:50',
                'telefoneCelular' => 'required',
                'endereco' => 'required|max:50',
                'bairro' => 'required|max:50',
                'numero' => 'required|max:10',
                'complemento'=>'max:50',
                'profissao'=>'max:50',
                'cidade_id' => 'required',
                'uf' => 'min:2|max:2',
                'cpf' => 'required|cpf|unique:pacientes,cpf,'.$this->id.',id',
                'rg' => 'required|max:10|unique:pacientes,rg,'.$this->id.',id',
                'estadoCivil' => 'required',
                'cns'=>'max:10',
                'numeroCarteirinha'=>'max:15',
                'acomodacao'=>'max:25'
            ];
        } else{
            return [
                'nome' => 'required|min:2|max:70',
                'dataNascimento' => 'required|date|before:'.\Carbon\Carbon::now().'',
                'email' => 'required|email|max:50',
                'telefoneCelular' => 'required',
                'endereco' => 'required|max:50',
                'bairro' => 'required|max:50',
                'numero' => 'required|max:10',
                'complemento'=>'max:50',
                'profissao'=>'max:50',
                'cidade_id' => 'required',
                'uf' => 'min:2|max:2',
                'cpf' => 'required|cpf|unique:pacientes',
                'rg' => 'required|unique:pacientes',
                'estadoCivil' => 'required',
                'cns'=>'max:10',
                'numeroCarteirinha'=>'max:15',
                'acomodacao'=>'max:25'
            ];
        }
    }
}
