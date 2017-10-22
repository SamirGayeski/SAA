<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProfissionalSaude extends Model
{
    protected $fillable = [
        'conselho',
        'registroConselho',
        'especialidade',
        'flagNotificaPaciente',
        'usuario_id'];

    public function usuario(){
        return $this->belongsTo('App\Usuario');
    }
}
