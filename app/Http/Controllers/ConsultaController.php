<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Cita;
use App\Models\Consulta;
use Illuminate\Http\Request;

class ConsultaController extends Controller
{
    public function index(Request $request) {
        $data = Consulta::activo()->latest()
        ->with(['medico'])->get();
        return response()->json($data, 200);
    }
    public function show($id) {
        $data = Consulta::latest()
        ->with(['medico'])->find($id);
        return response()->json($data, 200);
    }
    public function destroy($id) {
        $query = Consulta::find($id);
        if (!$query) {
            return response()->json('No encontrado', 409);
        }
        if ($query->cita->estado == 'EN CURSO') {
            return response()->json('No se puede eliminar, está en curso', 409);
        }
        $query->activo = false;
        $query->save();
        
        $data = [
            'success' => 'Eliminado'
        ];
        return response()->json($data, 200);
    }
    public function consultas($id) {
        $data = Consulta::where('paciente_id',$id)
        ->latest()
        ->with(['medico'])->get();
        return response()->json($data, 200);
    }
    public function store(Request $request) {
        $newData = new Consulta;
        $newData->fecha = date('Y-m-d H:i:s');
        $newData->motivo = $request->motivo;
        $newData->expectativas = $request->expectativas;
        $newData->examen_fisico = $request->examen_fisico;
        $newData->diagnostico = $request->diagnostico;
        $newData->tratamiento = $request->tratamiento;
        $newData->observacion = $request->observacion;
        $newData->paciente_id = $request->paciente_id;
        $newData->user_id = Auth::user()->id;
        $newData->save();
        $data = [
            'success' => 'Registrado'
        ];
        return response()->json($data, 200);
    }
    public function update(Request $request, $id) {
        $newData = Consulta::find($id);
        if (!$newData) {
            return response()->json('No encontrado', 409);
        }
        $valid_otra_cita = Cita::where('paciente_id',$newData->paciente_id)
        ->where('user_id',Auth::user()->id)
        ->where('estado','EN CURSO')->first();
        if (!$valid_otra_cita) {
            return response()->json('No hay una consulta en curso en este momento', 409);
        }
        
        $newData->motivo = $request->motivo;
        $newData->expectativas = $request->expectativas;
        $newData->examen_fisico = $request->examen_fisico;
        $newData->diagnostico = $request->diagnostico;
        $newData->tratamiento = $request->tratamiento;
        $newData->observacion = $request->observacion;
        $newData->save();
        $data = [
            'success' => 'Actualizado'
        ];
        return response()->json($data, 200);
    }
}
