<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConfNotificacaoPaciente extends Model
{
    protected $fillable = [
        'horarioEnvio',
        'antecedeAtendimento',
        'reenviaDiaAtendimento',
        'usuario_id'];

    public function usuario(){
        return $this->belongsTo('App\Usuario');
    }
}
