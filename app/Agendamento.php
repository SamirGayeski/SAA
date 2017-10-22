<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agendamento extends Model
{
    protected $fillable = [
        'usuario_id',
        'procedimento_id',
        'paciente_id',
        'convenio',
        'data',
        'horario',
        'status',
        'observacoes'];

    public function paciente(){
        return $this->belongsTo('App\Paciente');
    }

    public function anexos(){
        return $this->hasMany('App\Anexo');
    }

    public function usuario(){
        return $this->belongsTo('App\Usuario');
    }

    public function procedimento(){
        return $this->belongsTo('App\Procedimento');
    }

    public function atendimento(){
        return $this->hasOne('App\Atendimento');
    }
}
