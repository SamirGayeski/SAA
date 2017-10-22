<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfissionalSaudeRequest extends FormRequest
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
        if($this->tipoUsuario == 'Recepcionista'){
            return [
                'conselho' => 'max:30',
                'especialidade' => 'max:30'
            ];
        } else{
            return [
                'conselho' => 'required|max:30',
                'especialidade' => 'required|max:30'
            ];
        }

    }
}
