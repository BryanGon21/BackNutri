<?php

namespace App\Http\Controllers;

use App\Models\Alimento;
use App\Models\InfoAlimento;
use Illuminate\Http\Request;

class InfoAlimentoController extends Controller
{
    public function index(Request $request) {
        $data = InfoAlimento::latest()->with(['unidad'])->get();
        return response()->json($data, 200);
    }
    public function show($id) {
        $data = InfoAlimento::with(['unidad'])->find($id);
        return response()->json($data, 200);
    }
    public function store(Request $request) {
        $valid = InfoAlimento::where('nombre',$request->nombre)->first();
        if ($valid) {
            return response()->json('Nombre repetido', 409);
        }
        $model = new InfoAlimento;
        $model->nombre = $request->input('nombre');
        $model->cantidad = $request->input('cantidad');
        $model->calorias = $request->input('calorias');
        $model->proteinas = $request->input('proteinas');
        $model->carbohidratos = $request->input('carbohidratos');
        $model->grasas = $request->input('grasas');
        $model->unidad_id = $request->input('unidad_id');
        $model->habilitado = true;
        $model->save();

        $data = [
            'element' => $model,
            'success' => 'Registrado'
        ];
        return response()->json($data, 201);
    }
    public function update(Request $request, $id) {
        $valid = InfoAlimento::where('nombre',$request->nombre)
        ->where('id','!=',$id)->first();
        if ($valid) {
            return response()->json('Nombre repetido', 409);
        }
        // Recuperar todos los registros del modelo asociado con el controlador actual
        $model = InfoAlimento::find($id);
        if (!$model) {
            return response()->json('Elemento no encontrado', 409);
        }
        $model->nombre = $request->input('nombre');
        $model->cantidad = $request->input('cantidad');
        $model->calorias = $request->input('calorias');
        $model->proteinas = $request->input('proteinas');
        $model->carbohidratos = $request->input('carbohidratos');
        $model->grasas = $request->input('grasas');
        $model->unidad_id = $request->input('unidad_id');
        $model->save();

        $data = ['success' => 'Actualizado'];
        // Retornar respuesta
        return response()->json($data, 200);
    }
    public function destroy($id) {
        $model = InfoAlimento::find($id);
        if (!$model) {
            return response()->json('Elemento no encontrado', 409);
        }
        $query = Alimento::where('info_id',$id)->first();
        if ($query) {
            return response()->json('No puede ser eliminado', 409);
        }
        $model->delete();

        $data = ['success' => 'Eliminado'];
        return response()->json($data, 200);
    }
}
