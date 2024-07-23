<?php
namespace App\Http\Controllers;

use PDF;
use App\Models\Paciente;
use Dompdf\Dompdf;
use App\Models\Datos;
use Illuminate\Http\Request;
use ConsoleTVs\Charts\Classes\Chartjs\Chart;
use Barryvdh\Snappy\Facades\SnappyPdf;
// use Barryvdh\DomPDF\Facade as PDF;


class PdfController extends Controller
{
    public function verPerfil(Request $request, $id) {
        $paciente = Paciente::find($id);
    
        if (!$paciente) {
            return response()->json(['error' => 'Paciente no encontrado'], 404);
        }
    
        $data = [
            'i' => 0,
            'title' => 'información del paciente',
            'datos' => $paciente,
        ];
    
        $pdf = PDF::loadView('reportes.inf_paciente', $data);
        return $pdf->stream('reporte.pdf');
    }
    // public function generateReport(Request $request)
    // {
    //     // $tamanioImage = $request->input('tamanioImage');
    //     // $pesoImage = $request->input('pesoImage');

    //     // $tamanioImagePath = 'img/tamanioImage.png';
    //     // $pesoImagePath = 'img/pesoImage.png';

    //     // file_put_contents($tamanioImagePath, base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $tamanioImage)));
    //     // file_put_contents($pesoImagePath, base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $pesoImage)));
        


    //     // $datos = Datos::all();
    //     // $pdfContent = view('reportes.datos', compact('datos'))->render();
    //     // $pdf = SnappyPdf::loadHTML($pdfContent);
    //     // return $pdf->download('datos.pdf');




    //     $datos = Datos::all();
    //     $tamanioChart = new Chart;
    //     $tamanioChart->labels($datos->pluck('fecha')->toArray());
    //     $tamanioChart->dataset('Tamaño', 'line', $datos->pluck('tamanio')->toArray());

    //     $pesoChart = new Chart;
    //     $pesoChart->labels($datos->pluck('fecha')->toArray());
    //     $pesoChart->dataset('Peso', 'line', $datos->pluck('peso')->toArray());

    //     $pdf = new Dompdf();
    //     $pdf->loadHtml(view('reportes.datos', compact('tamanioChart', 'pesoChart'))->render());
    //     // $pdf->setPaper('A4', 'landscape');
    //     $pdf->render();
    //     // return view('reportes.datos', compact('tamanioChart', 'pesoChart'))->with('pdf', $pdf->stream());
    //     // $pdf->output()
    //     $pdfContent = $pdf->output(DOMPDF_OUTPUT_STRING); // Output as string
    //     $pdfBase64 = base64_encode($pdfContent); // Encode to Base64

    //     return view('reportes.datos', compact('tamanioChart', 'pesoChart', 'pdfBase64'));
    //     // return $pdf->stream('datos.pdf');

    //     // $pdf = PDF::loadView('reportes.datos', compact('tamanioChart', 'pesoChart'));
    //     // return $pdf->download('datos.pdf');
    //     // return $pdf->download('datos.pdf');
    //     // return view('reportes.datos', compact('tamanioChart', 'pesoChart'));

        
    //     // $datos = Datos::all();
    //     // $tamanioChart = new Chart;
    //     // $tamanioChart->labels($datos->pluck('fecha')->toArray());
    //     // $tamanioChart->dataset('Tamaño', 'line', $datos->pluck('tamanio')->toArray());

    //     // $pesoChart = new Chart;
    //     // $pesoChart->labels($datos->pluck('fecha')->toArray());
    //     // $pesoChart->dataset('Peso', 'line', $datos->pluck('peso')->toArray());

    //     // $pdfContent = view('reportes.datos', compact('tamanioChart', 'pesoChart'));
    //     // $pdf = SnappyPdf::loadHTML($pdfContent);
    //     // return $pdf->download('datos.pdf');
    // }
    public function generateReport(Request $request){
//         $image = imagecreatetruecolor(700, 230);

// // Definir los colores
//         $white = imagecolorallocate($image, 255, 255, 255);
//         $black = imagecolorallocate($image, 0, 0, 0);

//         // Llenar la imagen con blanco
//         imagefill($image, 0, 0, $white);

//         // Dibujar el gráfico aquí (este es un ejemplo básico, necesitarás ajustarlo según tus necesidades)
//         // Por ejemplo, dibujar una línea simple para representar el peso
//         imageline($image, 10, 10, 200, 200, $black);

//         // Guardar la imagen
//         imagepng($image, 'img/grafico.png');

//         // Liberar la memoria
//         imagedestroy($image);

//         $datos = Datos::orderBy('fecha', 'asc')->get();

        // Cargar la vista y pasar los datos
        // $view = view('reportes.datos')->render();

    // // Generar el PDF
    // $pdf = PDF::loadHTML($view);

    // // Descargar el PDF
    // return $pdf->download('reporte.pdf');

    $data = $request->chartData;
    $pdf = PDF::loadView('reportes.pdf', compact('data'));
    return $pdf->download('reporte.pdf');
    }


}
