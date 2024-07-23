<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\PlanDia;
use App\Models\PlanDieta;
use App\Models\PlanPaciente;
use Illuminate\Http\Request;

class PlanDietaController extends Controller
{
    public function index(Request $request) {
        $code = $request->get('code');
        $data = PlanPaciente::with(['paciente','usuario'])->latest()->get();
        if ($code) {
            $data = PlanPaciente::where('paciente_id',$code)
            ->with(['paciente','usuario'])->latest()->get();
        }
        if (Auth::user()->rol_id == 3) {
            $data = PlanPaciente::where('paciente_id',Auth::user()->paciente_id)
            ->with(['paciente','usuario'])->latest()->get();
        }
        return response()->json($data, 200);
    }
    
    public function show($id) {
        $data = PlanPaciente::with(['paciente','usuario','dietas'])->latest()->find($id);
        return response()->json($data, 200);
    }
    public function store(Request $request) {
        // $valid = Receta::where('nombre',$request->nombre)->first();
        // if ($valid) {
        //     return response()->json('Nombre repetido', 409);
        // }
        $model = new PlanPaciente;
        // $model->fecha = date('Y-m-d H');
        $model->nombre = $request->input('nombre');
        $model->edad = $request->input('edad');
        $model->peso = $request->input('peso');
        $model->altura = $request->input('altura');
        $model->nivel_actividad = $request->input('nivel_actividad');
        $model->circunferencia_cintura = $request->input('circunferencia_cintura');
        $model->circunferencia_caderas = $request->input('circunferencia_caderas');
        $model->glucosa_ayunas = $request->input('glucosa_ayunas');
        $model->colesterol_total = $request->input('colesterol_total');
        $model->colesterol_hdl = $request->input('colesterol_hdl');
        $model->colesterol_ldl = $request->input('colesterol_ldl');
        $model->trigliceridos = $request->input('trigliceridos');
        $model->hemoglobina = $request->input('hemoglobina');
        $model->dias = $request->input('dias');
        $model->paciente_id = $request->input('paciente_id');
        $model->user_id = Auth::user()->id;
        $model->save();

        foreach ($request->dietas as $dia) {
            $pldia = new PlanDia;
            // $pldia->fecha = $dia['fecha'];
            $pldia->calorias_totales = $dia['calorias_totales'];
            $pldia->carbohidratos_totales = $dia['carbohidratos_totales'];
            $pldia->grasas_totales = $dia['grasas_totales'];
            $pldia->dia = $dia['dia'];
            $pldia->plan_paciente_id = $model->id;
            $pldia->save();
            foreach ($dia['plan_dietas'] as $comida) {
                $cdia = new PlanDieta;
                $cdia->tipo_comida_id = $comida['tipo_comida_id'];
                $cdia->nombre = $comida['nombre'];
                $cdia->calorias = $comida['calorias'];
                $cdia->proteinas = $comida['proteinas'];
                $cdia->carbohidratos = $comida['carbohidratos'];
                $cdia->grasas = $comida['grasas'];
                $cdia->habilitado = true;
                $cdia->ingredientes = $comida['ingredientes'];
                $cdia->instrucciones = $comida['instrucciones'];
                $cdia->plan_dia_id = $pldia->id;
                $cdia->save();
            }
        }

        $data = [
            'element' => $model,
            'success' => 'Registrado'
        ];
        return response()->json($data, 201);
    }
    
    public function update(Request $request, $id) {
        // $valid = Receta::where('nombre',$request->nombre)->first();
        // if ($valid) {
        //     return response()->json('Nombre repetido', 409);
        // }
        $model = PlanPaciente::find($id);
        if (!$model) {
            return response()->json('Elemento no encontrado', 409);
        }
        // $model->fecha = date('Y-m-d H');
        $model->nombre = $request->input('nombre');
        $model->edad = $request->input('edad');
        $model->peso = $request->input('peso');
        $model->altura = $request->input('altura');
        $model->nivel_actividad = $request->input('nivel_actividad');
        $model->circunferencia_cintura = $request->input('circunferencia_cintura');
        $model->circunferencia_caderas = $request->input('circunferencia_caderas');
        $model->glucosa_ayunas = $request->input('glucosa_ayunas');
        $model->colesterol_total = $request->input('colesterol_total');
        $model->colesterol_hdl = $request->input('colesterol_hdl');
        $model->colesterol_ldl = $request->input('colesterol_ldl');
        $model->trigliceridos = $request->input('trigliceridos');
        $model->hemoglobina = $request->input('hemoglobina');
        $model->dias = $request->input('dias');
        // $model->paciente_id = $request->input('paciente_id');
        $model->user_id = Auth::user()->id;
        $model->save();

        foreach ($model->dietas as $key => $value) {
            $value->delete();
        }

        foreach ($request->dietas as $dia) {
            $pldia = new PlanDia;
            // $pldia->fecha = $dia['fecha'];
            $pldia->calorias_totales = $dia['calorias_totales'];
            $pldia->carbohidratos_totales = $dia['carbohidratos_totales'];
            $pldia->grasas_totales = $dia['grasas_totales'];
            $pldia->dia = $dia['dia'];
            $pldia->plan_paciente_id = $model->id;
            $pldia->save();
            foreach ($dia['plan_dietas'] as $comida) {
                $cdia = new PlanDieta;
                $cdia->tipo_comida_id = $comida['tipo_comida_id'];
                $cdia->nombre = $comida['nombre'];
                $cdia->calorias = $comida['calorias'];
                $cdia->proteinas = $comida['proteinas'];
                $cdia->carbohidratos = $comida['carbohidratos'];
                $cdia->grasas = $comida['grasas'];
                $cdia->habilitado = true;
                $cdia->ingredientes = $comida['ingredientes'];
                $cdia->instrucciones = $comida['instrucciones'];
                $cdia->plan_dia_id = $pldia->id;
                $cdia->save();
            }
        }

        $data = [
            'element' => $model,
            'success' => 'Actualizado'
        ];
        return response()->json($data, 200);
    }
    
    public function destroy($id) {
        // Recuperar todos los registros del modelo asociado con el controlador actual
        $model = PlanPaciente::find($id);
        if (!$model) {
            return response()->json('Elemento no encontrado', 409);
        }
        $model->delete();

        $data = ['success' => 'Eliminado'];
        // Retornar respuesta
        return response()->json($data, 200);
    }
}
