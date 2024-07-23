<?php

namespace App\Http\Controllers;

use App\Models\Unidad;
use App\Models\InfoAlimento;
use Illuminate\Http\Request;

class UnidadController extends Controller
{
    public function store(Request $request) {
        $valid = Unidad::where('nombre',$request->nombre)->first();
        if ($valid) {
            return response()->json('Nombre repetido', 409);
        }
        $model = new Unidad;
        $model->nombre = $request->input('nombre');
        $model->sigla = $request->input('sigla');
        $model->habilitado = true;
        $model->save();

        $data = [
            'element' => $model,
            'success' => 'Registrado'
        ];
        return response()->json($data, 201);
    }
    public function update(Request $request, $id) {
        $valid = Unidad::where('nombre',$request->nombre)
        ->where('id','!=',$id)->first();
        if ($valid) {
            return response()->json('Nombre repetido', 409);
        }
        // Recuperar todos los registros del modelo asociado con el controlador actual
        $model = Unidad::find($id);
        if (!$model) {
            return response()->json('Elemento no encontrado', 409);
        }
        $model->nombre = $request->input('nombre');
        $model->sigla = $request->input('sigla');
        $model->save();

        $data = ['success' => 'Actualizado'];
        // Retornar respuesta
        return response()->json($data, 200);
    }
    public function destroy($id) {
        $model = Unidad::find($id);
        if (!$model) {
            return response()->json('Elemento no encontrado', 409);
        }
        $query = InfoAlimento::where('unidad_id',$id)->first();
        if ($query) {
            return response()->json('No puede ser eliminado', 409);
        }
        $model->delete();

        $data = ['success' => 'Eliminado'];
        return response()->json($data, 200);
    }
}
