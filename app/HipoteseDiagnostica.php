<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HipoteseDiagnostica extends Model
{
    protected $fillable = [
        'diagnostico',
        'observacoes',
        'atendimento_id'];

    public function atendimento(){
        return $this->belongsTo('App\Atendimento');
    }
}
