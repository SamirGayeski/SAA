<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsuarioRequest extends FormRequest
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
        $this->route('usuario');

        if ($this->method() == 'PUT') {
            if($this->password != null) {
                return [
                    'nome' => 'required|min:2|max:50|unique:usuarios,nome,' . $this->id . ',id',
                    'password' => 'required|min:8|max:30|same:password_confirmed',
                    'password_confirmed' => '',
                    'email' => 'required|email|max:50|unique:usuarios,email,' . $this->id . ',id',
                    'telefone' => 'required',
                    'sexo' => 'required',
                    'tipoUsuario' => 'required'
                ];
            } else {
                return [
                    'nome' => 'required|min:2|max:50|unique:usuarios,nome,' . $this->id . ',id',
                    'password' => '',
                    'password_confirmed' => '',
                    'email' => 'required|email|max:50|unique:usuarios,email,' . $this->id . ',id',
                    'telefone' => 'required',
                    'sexo' => 'required',
                    'tipoUsuario' => 'required'
                ];
            }
        } else{
            return [
                'nome' => 'required|min:2|max:50|unique:usuarios',
                'password' => 'required|min:8|max:30|same:password_confirmed',
                'password_confirmed' => '',
                'email' => 'required|email|max:50|unique:usuarios',
                'telefone' => 'required',
                'sexo' => 'required',
                'tipoUsuario' => 'required'
            ];
        }
    }
}
