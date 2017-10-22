<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RecepcionistaAtende extends Model
{
    protected $fillable = [
        'recepcionista_id',
        'profissionalsaude_id'];

    public function usuario(){
        return $this->belongsTo('App\Usuario');
    }
}
