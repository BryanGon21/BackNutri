<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Cita;
use App\Models\Informacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InfoMedicaController extends Controller
{
    
    public function index(Request $request)
    {
        $infoMedica = Informacion::get();
        return response()->json($infoMedica);
    }
    public function store(Request $request)
    {   
        $validator = Validator::make($request->all(),[
            'peso' => 'nullable',
            'altura' => 'nullable',
            'imc' => 'nullable',
            'circunferencia_cintura' => 'nullable',
            'presion_arterial' => 'nullable',
            'nivel_actividad' => 'nullable',
            'fecha' => 'required',
            'observacion' => 'nullable',
            'paciente_id' => 'required'
        ],$messages =[
            'required' => 'El campo :attribute es requerido.',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        
        $valid_otra_cita = Cita::where('paciente_id',$request->paciente_id)
        ->where('user_id',Auth::user()->id)
        ->where('estado','EN CURSO')->first();
        if (!$valid_otra_cita) {
            return response()->json('No hay una consulta en curso en este momento', 409);
        }
        $imc = $this->calcularImc($request->altura,$request->peso);
        
        $infoMedica = Informacion::create([
            'peso' => $request->peso,
            'altura' => $request->altura,
            'imc' => $imc,
            'fecha' => date('Y-m-d',strtotime($request->fecha)),
            'fecha_registro' => date('Y-m-d H:m:i'),
            'circunferencia_cintura' => $request->circunferencia_cintura,
            'circunferencia_caderas' => $request->circunferencia_caderas,
            // 'glucosa_ayunas' => $request->glucosa_ayunas,
            // 'colesterol_total' => $request->colesterol_total,
            // 'colesterol_hdl' => $request->colesterol_hdl,
            // 'colesterol_ldl' => $request->colesterol_ldl,
            // 'trigliceridos' => $request->trigliceridos,
            // 'hemoglobina' => $request->hemoglobina,
            'presion_arterial' => $request->presion_arterial,
            'nivel_actividad' => $request->nivel_actividad,
            'observacion' => $request->observacion,
            'paciente_id' => $request->paciente_id,
            'cita_id' => $valid_otra_cita->id,
        ]);
        return response()->json($infoMedica);
    }
    function calcularImc($altura,$peso) {
        $imc = null;
        if ($altura && $peso) {
            $imc = $peso/($altura*$altura);
        }
        return $imc;
    }
    public function show($id)
    {
        $infoMedica = Informacion::find($id);
        if(!$infoMedica){
            return response()->json('Información no encontrada', 409);
        }
        return response()->json($infoMedica);
    }
    public function update(Request $request, $id)
    {
        $infoMedica = Informacion::find($id);
        if(!$infoMedica){
            return response()->json('Información no encontrada', 409);
        }
        $validator = Validator::make($request->all(),[
            // 'peso' => 'required',
            // 'altura' => 'required',
            // 'circunferencia_cintura' => 'required',
            // 'presion_arterial' => 'required',
            // 'nivel_actividad' => 'required',
            // 'observacion' => 'required',
            // 'paciente_id' => 'required'
        ],$messages =[
            'required' => 'El campo :attribute es requerido.',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $imc = $this->calcularImc($request->altura,$request->peso);
        // $infoMedica->update($request->all());
        $infoMedica->peso = $request->peso;
        $infoMedica->altura = $request->altura;
        $infoMedica->imc = $imc;
        $infoMedica->circunferencia_cintura = $request->circunferencia_cintura;
        $infoMedica->circunferencia_caderas = $request->circunferencia_caderas;
        $infoMedica->presion_arterial = $request->presion_arterial;
        // $infoMedica->glucosa_ayunas = $request->glucosa_ayunas;
        // $infoMedica->colesterol_total = $request->colesterol_total;
        // $infoMedica->colesterol_hdl = $request->colesterol_hdl;
        // $infoMedica->colesterol_ldl = $request->colesterol_ldl;
        // $infoMedica->trigliceridos = $request->trigliceridos;
        // $infoMedica->hemoglobina = $request->hemoglobina;
        $infoMedica->nivel_actividad = $request->nivel_actividad;
        $infoMedica->observacion = $request->observacion;
        $infoMedica->save();
        return response()->json($infoMedica);
    }
    public function destroy($id)
    {
        $infoMedica = Informacion::find($id);
        if(!$infoMedica){
            return response()->json('Información no encontrada', 409);
        }
        $infoMedica->delete();
        return response()->json(['message' => 'Información eliminada'], 200);
    }

    public function mostrarInfoPacientes()
    {
        $mostrar = Informacion::with('paciente')->get();
        return response()->json($mostrar);
    }

    public function verProgreso(Request $request, $id)
    {
        $id = Auth::user()->paciente_id;
        if (!$id) {
            return response()->json('No se encuentra el paciente', 409);
        }
        $columna = $request->get('medida');
        // Validar que la columna exista en la tabla medidas
        $columnas_validas = [
            'peso', 'altura', 'imc', 'circunferencia_cintura', 'circunferencia_caderas', 'presion_arterial', 'nivel_actividad', 
            // 'glucosa_ayunas', 'colesterol_total', 'colesterol_hdl', 'colesterol_ldl', 'trigliceridos', 'hemoglobina'
        ];

        if (!in_array($columna, $columnas_validas)) {
            return response()->json('Parámetro medida inválida', 409);
        }
        // Obtener las medidas del paciente ordenadas por fecha
        $medidas = Informacion::where('paciente_id', $id)
                         ->orderBy('fecha', 'asc')
                         ->get(['fecha', $columna]);

        // Preparar los datos para la gráfica
        $fechas = $medidas->pluck('fecha')->toArray();
        $value = $medidas->pluck($columna)->toArray();

        $data = [
            'labels' => $fechas,
            'data' => $value,
        ];
        return response()->json($data, 200);
        return view('paciente.progreso_peso', compact('fechas', 'pesos'));
    }
}
