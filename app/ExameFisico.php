<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExameFisico extends Model
{
    protected $fillable = [
        'altura',
        'peso',
        'frenquenciaCardiaca',
        'pressaoSistolica',
        'pressaoDiastolica',
        'observacoesGerais',
        'atendimento_id'];

    public function atendimento(){
        return $this->belongsTo('App\Atendimento');
    }
}
