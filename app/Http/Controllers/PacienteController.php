<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Paciente;
use App\Models\Informacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PacienteController extends Controller
{
    public function index(Request $request)
    {
        // $pacientes = Paciente::where('user_id',Auth::user()->id)
        $pacientes = Paciente::latest()->get();
        return response()->json($pacientes);
    }
    public function store(Request $request) {   
        $validator = Validator::make($request->all(),[
            'nombres' => 'required',
            'fecha_nacimiento' => 'required',
            'celular' => 'required',
            'email' => 'required|email',
            'genero' => 'required'
        ],$messages =[
            'required' => 'El campo :attribute es requerido.',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $name = null;
        $dir_folder = 'images/pacientes';
        if($request->hasFile('file')){
            if (!is_dir(public_path().'/'.$dir_folder)) {
                $crearDir = mkdir(public_path().'/'.$dir_folder, 0777, true);
            }
            $file = $request->file('file');
            //concatena la hora y el nombre del archivo
            $name = $file->getClientOriginalName();
            $file->move(public_path().'/'.$dir_folder, $name);
            $ruta = public_path().'/'.$dir_folder.'/'. $name;
        }
        $dir_file = null;
        if ($name) {
            $dir_file = $dir_folder.'/'.$name;
        }

        $paciente = new Paciente;
        $paciente->nombres = $request->nombres;
        $paciente->apellidos = $request->apellidos;
        $paciente->genero = $request->genero;
        $paciente->fecha_nacimiento = date('Y-m-d',strtotime($request->fecha_nacimiento));
        $paciente->ocupacion = $request->ocupacion!='null'?$request->ocupacion:null;
        $paciente->celular = $request->celular;
        $paciente->email = $request->email;
        $paciente->residencia = $request->residencia!='null'?$request->residencia:null;
        $paciente->img_url = $dir_file;
        $paciente->save();
        
        $newItem = new User;
        $newItem->nombres = $request->nombres;
        $newItem->apellidos = $request->apellidos;
        $newItem->nombre_completo = $fullname;
        // $newItem->especialidad = $request->especialidad;
        // $newItem->ci = $request->ci;
        $newItem->celular = $request->celular;
        // $newItem->color = $request->color;
        $newItem->username = $request->username;
        $newItem->password = bcrypt($request->password);
        $newItem->email = $request->email;
        $newItem->habilitado = true;
        $newItem->rol_id = 3;
        $newItem->paciente_id = $paciente->id;
        $newItem->save();
        
        $data = [
            'paciente' => $paciente,
            'success' => 'Se ha realizado un nuevo registro.'
        ];
        return response()->json($data, 201);
    }
    public function show($id)
    {
        $paciente = Paciente::with(['informacion','h_informacion','medicion','h_medicion','resultado','h_resultados'])->find($id);
        if(!$paciente){
            return response()->json('Paciente no encontrado', 409);
        }
        $paciente->edad = Carbon::parse($paciente->fecha_nacimiento)->age;
        // $cita = Cita::where('paciente_id',$id)
        // ->where(function($query) {
        //     $query->where('estado','EN ESPERA');
        //     $query->orWhere('estado','EN CURSO');
        // })
        // ->latest()->first();
        // $paciente->cita = $cita;
        return response()->json($paciente);
    }
    public function update(Request $request, $id)
    {
        $paciente = Paciente::find($id);
        if(!$paciente){
            return response()->json('Paciente no encontrado', 409);
        }
        $validator = Validator::make($request->all(),[
            'nombres' => 'required',
            'fecha_nacimiento' => 'required',
            'celular' => 'required',
            'email' => 'required|email',
            'genero' => 'required'
        ],$messages =[
            'required' => 'El campo :attribute es requerido.',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $name = null;
        $dir_folder = 'images/pacientes';
        if($request->hasFile('file')){
            if (!is_dir(public_path().'/'.$dir_folder)) {
                $crearDir = mkdir(public_path().'/'.$dir_folder, 0777, true);
            }
            $file = $request->file('file');
            //concatena la hora y el nombre del archivo
            $name = $file->getClientOriginalName();
            $file->move(public_path().'/'.$dir_folder, $name);
            $ruta = public_path().'/'.$dir_folder.'/'. $name;
        }
        $dir_file = null;
        if ($name) {
            $dir_file = $dir_folder.'/'.$name;
        }
        // $dataUpdate = array_merge($request->all(), [
        //     'img_url' => $dir_file,
        // ]);
        // $paciente->update($dataUpdate);
        $paciente->update([
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'genero' => $request->genero,
            'fecha_nacimiento' => date('Y-m-d',strtotime($request->fecha_nacimiento)),
            'ocupacion' => $request->ocupacion!='null'?$request->ocupacion:null,
            'celular' => $request->celular,
            'email' => $request->email,
            'residencia' => $request->residencia!='null'?$request->residencia:null,
            'img_url' => $dir_file,
        ]);
        return response()->json($paciente);
    }

    public function destroy($id)
    {
        $paciente = Paciente::find($id);
        if(!$paciente){
            return response()->json('Paciente no encontrado', 409);
        }
        $paciente->delete();
        return response()->json(['message' => 'Paciente eliminado']);
    }
    public function mostrarInfo(){
        $mostrar = Paciente::with('informacion')->get();
        return response()->json($mostrar);
    }
    

}
