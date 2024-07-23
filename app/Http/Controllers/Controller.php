<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected $modelName;

    public function __construct() {
        // Determinar el nombre del modelo asociado con el controlador actual
        $this->modelName = str_replace('Controller', '', class_basename(static::class));
        $this->modelName = 'App\\Models\\' . $this->modelName;
    }

    public function index(Request $request) {
        // Recuperar todos los registros del modelo asociado con el controlador actual
        $model = new $this->modelName;
        $data = $model::latest()->get();

        // Retornar los registros como respuesta
        return response()->json($data);
    }
    
    public function habilitados(Request $request) {
        // Recuperar todos los registros del modelo asociado con el controlador actual
        $model = new $this->modelName;
        $data = $model::habilitado()->get();

        // Retornar los registros como respuesta
        return response()->json($data);
    }
    
    public function show($id) {
        // Recuperar todos los registros del modelo asociado con el controlador actual
        $model = new $this->modelName;
        $data = $model::find($id);

        // Retornar los registros como respuesta
        return response()->json($data);
    }
    
    public function habilitar($id) {
        // Recuperar todos los registros del modelo asociado con el controlador actual
        $model = new $this->modelName;
        $item = $model::find($id);
        if (!$item) {
            return response()->json('Elemento no encontrado', 409);
        }
        $text = 'habilitado.';
        if ($item->habilitado) {
            $item->habilitado = false;
            $text = 'deshabilitado.';
        } else {
            $item->habilitado = true;
        }
        $item->save();
        $data = ['success' => 'Elemento ' . $text];
        return response()->json($data, 200);

        // Retornar los registros como respuesta
        return response()->json($data);
    }
    
    public function store(Request $request) {
        $valid = $this->modelName::where('nombre',$request->input('nombre'))->first();
        if ($valid) {
            return response()->json('Nombre repetido', 409);
        }
        // Recuperar todos los registros del modelo asociado con el controlador actual
        $model = new $this->modelName;
        $model->nombre = $request->input('nombre');
        $model->habilitado = true;
        $model->save();

        $data = [
            'element' => $model,
            'success' => 'Registrado'
        ];
        // Retornar respuesta
        return response()->json($data, 201);
    }
    
    public function update(Request $request, $id) {
        $valid = $this->modelName::where('nombre',$request->input('nombre'))
        ->where('id','!=',$id)->first();
        if ($valid) {
            return response()->json('Nombre repetido', 409);
        }
        // Recuperar todos los registros del modelo asociado con el controlador actual
        $model = $this->modelName::find($id);
        if (!$model) {
            return response()->json('Elemento no encontrado', 409);
        }
        $model->nombre = $request->input('nombre');
        $model->save();

        $data = ['success' => 'Actualizado'];
        // Retornar respuesta
        return response()->json($data, 200);
    }
    
    public function destroy($id) {
        // Recuperar todos los registros del modelo asociado con el controlador actual
        $model = $this->modelName::find($id);
        if (!$model) {
            return response()->json('Elemento no encontrado', 409);
        }
        $model->delete();

        $data = ['success' => 'Eliminado'];
        // Retornar respuesta
        return response()->json($data, 200);
    }
}
