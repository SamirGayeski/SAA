<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPJasper\PHPJasper;
use App\Agendamento;

class ReportController extends Controller{

    public function getDatabaseConfig()
    {
        return [
            'driver'   => 'postgres',
            'host'     => env('DB_HOST'),
            'port'     => env('DB_PORT'),
            'username' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
            'database' => env('DB_DATABASE')
        ];
    }

    public function index()
    {
        $input = public_path() . '/reports/Pacientes.jasper';
        $output = public_path() . '/reports/Pacientes';
        $options = [
            'format' => ['pdf'],
            'locale' => 'pt_BR',
            'params' => [],
            'db_connection' => $this->getDatabaseConfig()
        ];

        $jasper = new PHPJasper;

        $jasper->process($input, $output, $options)->execute();
        $file = $output . '.pdf';
        $path = $file;

        $file = file_get_contents($file);
        unlink($path);
        return response($file, 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="Pacientes.pdf"');
    }
}