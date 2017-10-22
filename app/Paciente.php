<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    protected $fillable = [
        'nome',
        'dataNascimento',
        'sexo',
        'email',
        'telefoneCelular',
        // 'aceitasms',
        'telefoneResidencial',
        'endereco',
        'bairro',
        'numero',
        'complemento',
        'cidade_id',
        'cpf',
        'rg',
        'estadoCivil',
        'profissao',
        'situacao',
        'cns',
        'convenio_id',
        'plano_id',
        'numeroCarteirinha',
        'validade',
        'acomodacao'];

    public function convenio(){
        return $this->belongsTo('App\Convenio');
    }

    public function cidade(){
        return $this->belongsTo('App\Cidade');
    }

    public function plano(){
        return $this->belongsTo('App\Plano');
    }

    public function agendamentos(){
        return $this->hasMany('App\Agendamento');
    }

    public function dadosFamiliars(){
        return $this->hasMany('App\DadosFamiliar');
    }

}
