<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\Models\Cita;
use App\Models\Resultado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ResultadoController extends Controller
{
    
    public function index(Request $request)
    {
        $infoMedica = Resultado::get();
        return response()->json($infoMedica);
    }
    public function store(Request $request)
    {   
        $validator = Validator::make($request->all(),[
            'nivel_actividad' => 'nullable',
            'fecha' => 'required',
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
        
        $newData = new Resultado;
        $newData->fecha = date('Y-m-d',strtotime($request->fecha));
        $newData->fecha_registro = date('Y-m-d H:m:i');
        $newData->glucosa_ayunas = $request->glucosa_ayunas;
        $newData->colesterol_total = $request->colesterol_total;
        $newData->colesterol_hdl = $request->colesterol_hdl;
        $newData->colesterol_ldl = $request->colesterol_ldl;
        $newData->trigliceridos = $request->trigliceridos;
        $newData->hemoglobina = $request->hemoglobina;
        $newData->paciente_id = $request->paciente_id;
        $newData->cita_id = $valid_otra_cita->id;
        $newData->save();
        return response()->json($newData);
    }
    public function show($id)
    {
        $infoMedica = Resultado::find($id);
        if(!$infoMedica){
            return response()->json('Información no encontrada', 409);
        }
        return response()->json($infoMedica);
    }
    public function update(Request $request, $id)
    {
        $infoMedica = Resultado::find($id);
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
        // $infoMedica->update($request->all());
        $infoMedica->glucosa_ayunas = $request->glucosa_ayunas;
        $infoMedica->colesterol_total = $request->colesterol_total;
        $infoMedica->colesterol_hdl = $request->colesterol_hdl;
        $infoMedica->colesterol_ldl = $request->colesterol_ldl;
        $infoMedica->trigliceridos = $request->trigliceridos;
        $infoMedica->hemoglobina = $request->hemoglobina;
        $infoMedica->save();
        return response()->json($infoMedica);
    }
    public function destroy($id)
    {
        $infoMedica = Resultado::find($id);
        if(!$infoMedica){
            return response()->json('Información no encontrada', 409);
        }
        $infoMedica->delete();
        return response()->json(['message' => 'Información eliminada'], 200);
    }

    public function mostrarInfoPacientes()
    {
        $mostrar = Resultado::with('paciente')->get();
        return response()->json($mostrar);
    }
}
