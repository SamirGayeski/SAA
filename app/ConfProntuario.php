<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConfProntuario extends Model
{
    protected $fillable = [
        'anamnese',
        'exameFisico',
        'hipoteseDiagnostica',
        'usuario_id'];

    public function usuario(){
        return $this->belongsTo('App\Usuario');
    }
}
