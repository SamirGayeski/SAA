<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Convenio extends Model
{
    protected $fillable = [
        'nome',
        'numeroRegistro'];

    public function pacientes(){
        return $this->hasMany('App\paciente');
    }
}
