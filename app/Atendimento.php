<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Atendimento extends Model
{
    protected $fillable = [
        'descricaoPrincipal',
        'evolucao',
        'duracaoAtendimento',
        'agendamento_id'];

    public function agendamento(){
        return $this->belongsTo('App\Agendamento');
    }

    public function hipoteseDiagnostica(){
        return $this->hasOne('App\HipoteseDiagnostica');
    }

    public function exameFisico(){
        return $this->hasOne('App\ExameFisico');
    }

    public function anamnese(){
        return $this->hasOne('App\Anamnese');
    }
}
