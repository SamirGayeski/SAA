<?php

namespace App\Http\Controllers;

use App\Http\Requests\LogsRequest;
use App\Log;
use Faker\Provider\DateTime;
use Illuminate\Http\Request;

class LogsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){

        $datainicial = new \DateTime('-1 month');
        $datainicial->format('Y-m-d');
        $datafinal = new \DateTime('+1 day');
        $datafinal->format('Y-m-d');

        $datafinalview = new \DateTime();
        $datafinalview->format('Y-m-d');

        $logs = Log::whereBetween('created_at', array($datainicial, $datafinal))->orderBy('created_at', 'desc')->paginate(15);
        return view('logs.index', ['logs'=>$logs, 'datainicial'=>$datainicial, 'datafinal'=>$datafinalview]);
    }

    public function search(LogsRequest $request){
        return redirect()->route('logs.result', ['datainicial'=>$request->datainicial, 'datafinal'=>$request->datafinal]);
    }

    public function result($datainicial, $datafinal){
        $logs = Log::whereBetween('created_at', array($datainicial, $datafinal))->orderBy('created_at', 'desc')->paginate(15);
        return view('logs.index', ['logs'=>$logs, 'datainicial'=>$datainicial, 'datafinal'=>$datafinal]);
    }
}
