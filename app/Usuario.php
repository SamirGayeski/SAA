<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nome',
        'password',
        'email',
        'telefone',
        'sexo',
        'dataCriacao',
        'situacao',
        'flagAdmin',
        'tipoUsuario'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
        ];

    public function agendamentos(){
        return $this->hasMany('App\Agendamento');
    }

    public function confProntuario(){
        return $this->hasOne('App\ConfProntuario');
    }

    public function confNotificacaoPaciente(){
        return $this->hasOne('App\ConfNotificacaoPaciente');
    }

    public function recepcionistaAtende(){
        return $this->hasMany('App\RecepcionistaAtende');
    }

    public function profissionalSaude(){
        return $this->hasOne('App\ProfissionalSaude');
    }

    public function setPasswordAttribute($password){
        $this->attributes['password'] = bcrypt($password);
    }
}
