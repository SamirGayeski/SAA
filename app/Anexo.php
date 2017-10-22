<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Anexo extends Model
{
    protected $fillable = [
        'nomeArquivo',
        'agendamento_id'];

    public function agendamento(){
        return $this->belongsTo('App\Agendamento');
    }
}
