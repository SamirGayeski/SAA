<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Procedimento extends Model
{
    protected $fillable = [
        'nome',
        'duracao',
        'descricao'];

    public function agendamentos(){
        return $this->hasMany('App\Agendamento');
    }
}
