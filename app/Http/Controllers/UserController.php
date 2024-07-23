<?php

namespace App\Http\Controllers;

use DB;
use Validator;
use App\Models\Role;
use App\Models\User;
use App\Models\Paciente;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request) {
        $term = $request->input('term');
        $rol = $request->input('rol');

        $query = User::sterm($term,'')
        ->srol($rol,'')
        ->with(['rol'])
        ->latest()
        ->get();
        return response()->json($query, 200);
    }
    public function show($id) {
        $data = User::with('rol')->find($id);
        return response()->json($data, 200);
    }
    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            // 'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Algunos campos son requeridos.'], 409);
        }
        
        $valUserName = User::where('username',$request->username)->first();
        if ($valUserName) {
            return response()->json('El nombre de usuario ya esta en uso.', 409);
        }

        // $valEmail = User::where('email',$request->email)->first();
        // if ($valEmail) {
        //     return response()->json('El email ya esta en uso.', 409);
        // }
        $fullname = null;
        if ($request->nombres) {
            if ($request->apellidos) {
                $fullname = $request->nombres.' '.$request->apellidos;
            } else {
                $fullname = $request->nombres;
            }
        } else {
            if ($request->apellidos) {
                $fullname = $request->apellidos;
            }
        }

        try {
            DB::beginTransaction();
            $newItem = new User;
            $newItem->nombres = $request->nombres;
            $newItem->apellidos = $request->apellidos;
            $newItem->nombre_completo = $fullname;
            $newItem->especialidad = $request->especialidad;
            $newItem->ci = $request->ci;
            $newItem->celular = $request->celular;
            $newItem->color = $request->color;
            $newItem->username = $request->username;
            $newItem->password = bcrypt($request->password);
            $newItem->email = $request->email;
            $newItem->habilitado = true;
            $newItem->rol_id = $request->rol_id;
            $newItem->save();

            DB::commit();
            return response()->json(['success' => 'Operación realizada exitosamente.'], 201);
        } catch (\Exception $th) {
            DB::rollback();
            //throw $th;
            return response()->json($th, 409);
        }
    }
    public function update(Request $request, $id) {
        $valUserName = User::where('username',$request->username)
        ->where('id','!=',$id)->first();
        if ($valUserName) {
            return response()->json('El nombre de usuario ya esta en uso.', 409);
        }

        // $valEmail = User::where('email',$request->email)
        // ->where('id','!=',$id)->first();
        // if ($valEmail) {
        //     return response()->json('El email ya esta en uso.', 409);
        // }
        $editItem = User::find($id);
        if (!$editItem) {
            return response()->json('No se encuentra el usuario en el sistema, COD-ID: '.$id, 409);
        }
        $fullname = null;
        if ($request->nombres) {
            if ($request->apellidos) {
                $fullname = $request->nombres.' '.$request->apellidos;
            } else {
                $fullname = $request->nombres;
            }
        } else {
            if ($request->apellidos) {
                $fullname = $request->apellidos;
            }
        }
        $editItem->nombres = $request->nombres;
        $editItem->apellidos = $request->apellidos;
        $editItem->nombre_completo = $fullname;
        $editItem->especialidad = $request->especialidad;
        $editItem->ci = $request->ci;
        $editItem->celular = $request->celular;
        $editItem->color = $request->color;
        $editItem->save();
        
        $editItem->username = $request->username;
        $editItem->email = $request->email;
        if ($request->password) {
            $editItem->password = bcrypt($request->password);
        }
        $editItem->rol_id = $request->rol_id;
        $editItem->save();
        
        return response()->json(['success' => 'Operación realizada exitosamente.'], 200);
    }
    
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            // 'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Algunos campos son requeridos.'], 409);
        }
        
        $valUserName = User::where('username',$request->username)->first();
        if ($valUserName) {
            return response()->json('El nombre de usuario ya esta en uso.', 409);
        }

        // $valEmail = User::where('email',$request->email)->first();
        // if ($valEmail) {
        //     return response()->json('El email ya esta en uso.', 409);
        // }
        $fullname = null;
        if ($request->nombres) {
            if ($request->apellidos) {
                $fullname = $request->nombres.' '.$request->apellidos;
            } else {
                $fullname = $request->nombres;
            }
        } else {
            if ($request->apellidos) {
                $fullname = $request->apellidos;
            }
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

        try {
            DB::beginTransaction();
            
            $paciente = new Paciente;
            $paciente->nombres = $request->nombres;
            $paciente->apellidos = $request->apellidos;
            $paciente->genero = $request->genero;
            $paciente->fecha_nacimiento = date('Y-m-d',strtotime($request->fecha_nacimiento));
            $paciente->ocupacion = $request->ocupacion!='null'?$request->ocupacion:null;
            $paciente->celular = $request->celular;
            $paciente->email = $request->email;
            $paciente->residencia = $request->residencia!='null'?$request->residencia:null;
            // $paciente->user_id = Auth::user()->id;
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

            DB::commit();
            return response()->json(['success' => 'Operación realizada exitosamente.'], 201);
        } catch (\Exception $th) {
            DB::rollback();
            //throw $th;
            return response()->json($th, 409);
        }
    }

    public function destroy($id) {
        $item = User::find($id);
        if(!$item) {
            return response()->json($item, 409);
        }
        // $valid = Ingreso::where('user_id',$id)->first();
        // if ($valid) {
        //     return response()->json('No puede ser eliminado.', 409);
        // }
        $item->delete();

        return response()->json($item, 200);
    }
    public function habilitar($id) {
        $item = User::find($id);
        $text = 'habilitado.';
        if ($item->habilitado) {
            $item->habilitado = false;
            $text = 'deshabilitado.';
        } else {
            $item->habilitado = true;
        }
        $item->save();
        return response()->json(['success' => 'Operación realizada correctamente. '.$text], 200);
    }
    public function roles() {
        return response()->json(Role::get(), 200);
    }
    public function medicos() {
        $data = User::where('rol_id',2)->get();
        return response()->json($data, 200);
    }
}
