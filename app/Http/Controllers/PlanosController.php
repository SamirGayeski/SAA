<?php

namespace App\Http\Controllers;

use App\Plano;
use App\Http\Requests\PlanoRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class PlanosController extends Controller
{


    public function search (){
        $options = Plano::option(Input::get('convenio_id'));
        $planos = '<option></option>';
    }
}
