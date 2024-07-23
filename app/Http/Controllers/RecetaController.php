<?php

namespace App\Http\Controllers;

use App\Models\Receta;
use App\Models\Restriccion;
use Illuminate\Http\Request;

class RecetaController extends Controller
{
    public function index(Request $request) {
        $data = Receta::latest()->with(['tipocomida','restricciones'])->get();
        return response()->json($data, 200);
    }
    public function show($id) {
        $data = Receta::with(['tipocomida','restricciones'])->find($id);
        return response()->json($data, 200);
    }
    public function store(Request $request) {
        $valid = Receta::where('nombre',$request->nombre)->first();
        if ($valid) {
            return response()->json('Nombre repetido', 409);
        }
        $model = new Receta;
        $model->nombre = $request->input('nombre');
        $model->calorias = $request->input('calorias');
        $model->proteinas = $request->input('proteinas');
        $model->carbohidratos = $request->input('carbohidratos');
        $model->grasas = $request->input('grasas');
        $model->ingredientes = $request->input('ingredientes');
        $model->instrucciones = $request->input('instrucciones');
        $model->habilitado = true;
        $model->tipo_comida_id = $request->input('tipo_comida_id');
        $model->save();

        foreach ($request->restricciones as $restriccion) {
            $rest = new Restriccion;
            $rest->nombre = $restriccion['nombre'];
            $rest->receta_id = $model->id;
            $rest->save();
        }

        $data = [
            'element' => $model,
            'success' => 'Registrado'
        ];
        return response()->json($data, 201);
    }
    public function update(Request $request, $id) {
        $valid = Receta::where('nombre',$request->nombre)
        ->where('id','!=',$id)->first();
        if ($valid) {
            return response()->json('Nombre repetido', 409);
        }
        $model = Receta::find($id);
        if (!$model) {
            return response()->json('Elemento no encontrado', 409);
        }
        $model->nombre = $request->input('nombre');
        $model->calorias = $request->input('calorias');
        $model->proteinas = $request->input('proteinas');
        $model->carbohidratos = $request->input('carbohidratos');
        $model->grasas = $request->input('grasas');
        $model->ingredientes = $request->input('ingredientes');
        $model->instrucciones = $request->input('instrucciones');
        $model->tipo_comida_id = $request->input('tipo_comida_id');
        $model->save();

        foreach ($model->restricciones as $key => $value) {
            $value->delete();
        }

        foreach ($request->restricciones as $restriccion) {
            $rest = new Restriccion;
            $rest->nombre = $restriccion['nombre'];
            $rest->receta_id = $model->id;
            $rest->save();
        }

        $data = [
            'element' => $model,
            'success' => 'Actualizado'
        ];
        return response()->json($data, 201);
    }
}
