<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Anamnese extends Model
{
    protected $fillable = [
        'queixaPrincipal',
        'historia',
        'problemasRenais',
        'problemasArticulares',
        'problemasCardiacos',
        'problemasRespiratorios',
        'problemasGastricos',
        'alergias',
        'hepatite',
        'gravidez',
        'diabetes',
        'usoMedicamento',
        'atendimento_id'];

    public function atendimento(){
        return $this->belongsTo('App\Atendimento');
    }
}
