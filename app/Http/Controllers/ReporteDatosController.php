<?php
namespace App\Http\Controllers;

use PDF;
use Dompdf\Dompdf;
use App\Models\Datos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\Snappy\Facades\SnappyPdf;
use ConsoleTVs\Charts\Classes\Chartjs\Chart;

class ReporteDatosController extends Controller
{
    public function verReporte(Request $request)
    {
        $datos = DB::table('datos')
                ->select(DB::raw("DATE_FORMAT(fecha, '%M') as mes, peso, altura"))
                ->orderBy('fecha', 'asc')
                ->get();

    // Convierte los datos a un formato que puedas pasar a tu gráfico
        $altura = [];
        $peso = [];
        foreach ($datos as $dato) {
            $altura[] = [$dato->mes, $dato->altura];
            $peso[] = [$dato->mes, $dato->peso];
        }

        return view('reportes.datos', compact('altura', 'peso'));
    }

    // public function generateReport(Request $request){


    // $datos = DB::table('datos')
    //             ->select(DB::raw("DATE_FORMAT(fecha, '%M') as mes, peso, altura"))
    //             ->orderBy('fecha', 'asc')
    //             ->get();

    // // Convierte los datos a un formato que puedas pasar a tu gráfico
    // $altura = [];
    // $peso = [];
    // foreach ($datos as $dato) {
    //     $altura[] = [$dato->mes, $dato->altura];
    //     $peso[] = [$dato->mes, $dato->peso];
    // }


    


}
