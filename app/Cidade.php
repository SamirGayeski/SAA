<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cidade extends Model
{
    protected $fillable = [
        'nome',
        'uf'];

    public function pacientes(){
        return $this->hasMany('App\Paciente');
    }
}
