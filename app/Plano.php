<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plano extends Model
{
    protected $fillable = [
        'descricao',
        'convenio_id'];

    public function convenio(){
        return $this->belongsTo('App\Convenio');
    }

    public function pacientes(){
        return $this->hasMany('App\paciente');
    }
}
