<?php

namespace App\Http\Controllers;

use App\Agendamento;
use Illuminate\Http\Request;

class dashboardsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){

        $particular = Agendamento::where('convenio', '=', 'Particular')->count('*');
        $convenio = Agendamento::where('convenio', '!=', 'Particular')->count('*');

        return view('dashboard.index', ['particular'=>$particular, 'convenio'=>$convenio]);
    }
}
