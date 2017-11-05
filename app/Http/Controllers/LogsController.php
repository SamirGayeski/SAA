<?php

namespace App\Http\Controllers;

use App\Log;
use Illuminate\Http\Request;

class LogsController extends Controller
{
    public function index(){
        $logs = Log::orderBy('created_at', 'desc')->paginate(15);
        return view('logs.index', ['logs'=>$logs]);
    }
}
