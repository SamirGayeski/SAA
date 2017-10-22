<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DadosFamiliar extends Model
{
    protected $fillable = [
        'nome',
        'parentesco',
        'telefone',
        'paciente_id'];

    public function paciente(){
        return $this->belongsTo('App\Paciente');
    }
}
