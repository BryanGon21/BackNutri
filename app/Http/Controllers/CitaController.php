<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\Models\Cita;
use App\Models\Consulta;
use App\Models\Paciente;
use App\Models\Informacion;
use Illuminate\Http\Request;

class CitaController extends Controller
{
    public function index(Request $request)
    {
        $user_id = $request->get('user_id');
        $term = $request->get('term');
        $citas = Cita::from('citas as c')
        ->join('pacientes as p','p.id','c.paciente_id')
        ->sterm($term,'p.')
        ->suser($user_id,'c.')
        ->select('c.*')
        ->with(['paciente','medico'])
        ->get();
        if (Auth::user()->rol_id == 2) {
            $citas = Cita::from('citas as c')
            ->join('pacientes as p','p.id','c.paciente_id')
            ->sterm($term,'p.')
            ->suser(Auth::user()->id,'c.')
            ->select('c.*')
            ->with(['paciente','medico'])
            ->get();
        }
        if (Auth::user()->rol_id == 3) {
            // es un paciente
            $citas = Cita::from('citas as c')
            ->join('pacientes as p','p.id','c.paciente_id')
            ->where('c.paciente_id',Auth::user()->paciente_id)
            ->sterm($term,'p.')
            ->select('c.*')
            ->with(['paciente','medico'])
            ->get();
        }
        // foreach ($citas as $key => $value) {
        //     $value->titulo = $this->tituloCita($value->paciente_id);
        //     $value->save();
        // }
        return response()->json($citas);
    }
    public function medico(Request $request) {
        $citas = Cita::where('user_id',Auth::user()->id)
        ->whereDate('fecha_inicio',date('Y-m-d'))
        ->where('id',0)
        ->get();
        $proximas = Cita::where('user_id',Auth::user()->id)
        // ->whereDate('fecha_inicio','!=',date('Y-m-d'))
        ->where('estado','!=','CANCELADA')
        ->whereDate('fecha_inicio','>=',date('Y-m-d'))
        ->orderBy('fecha_inicio')
        ->with(['paciente'])
        ->get();
        $consultasmes = Cita::where('user_id',Auth::user()->id)
        ->whereYear('fecha_inicio',date('Y'))
        ->whereMonth('fecha_inicio',date('m'))
        ->count();
        $pacientes = Paciente::whereYear('created_at',date('Y'))
        ->whereMonth('created_at',date('m'))->count();
        $data = [
            'consultas' => $consultasmes,
            'nuevos' => $pacientes,
            'citas' => $citas,
            'proximas' => $proximas,
        ];
        return response()->json($data, 200);
    }
    public function store(Request $request)
    {
        $user_id = Auth::user()->id;
        if (Auth::user()->rol_id == 1) {
            $user_id = $request->user_id;
        }
        if ($this->verificarInicio($request->fecha_inicio)) {
            return response()->json('Seleccione una fecha válida', 409);
        }
        if ($this->verificarHoras($request->fecha_inicio,$request->fecha_fin)) {
            return response()->json('Revise las fechas', 409);
        };
        // ver horario disponible
        if ($this->verificarDisponibilidad($request->fecha_inicio,$request->fecha_fin,0)) {
            return response()->json('Horario no disponible', 409);
        };
        $cita = Cita::create([
            'titulo'=>$this->tituloCita($request->paciente_id),
            'fecha'=>$request->fecha,
            'fecha_inicio'=>$request->fecha_inicio,
            'fecha_fin'=>$request->fecha_fin,
            'observacion'=>$request->observacion,
            'estado'=> 'EN ESPERA',

            'paciente_id'=>$request->paciente_id,
            'user_id'=>$user_id
        ]);
        $data = [
            'cita' => $cita,
            'success' => 'Se ha realizado una nueva cita.'
        ];
        return response()->json($data, 201);
    }
    function verificarDisponibilidad($ini,$fin,$cita_id) {
        $fecha = date('Y-m-d',strtotime($ini));
        $f_ini = strtotime($ini);
        $f_fin = strtotime($fin);
        $citas = Cita::where('id','!=',$cita_id)
        ->whereDate('fecha_inicio',$fecha)
        ->where('estado','!=','cancelado')
        ->where('user_id',Auth::user()->id)
        ->get();
        foreach ($citas as $horario) {
            $aux_ini = strtotime($horario->fecha_inicio);
            $aux_fin = strtotime($horario->fecha_fin);
            // if ($f_ini >= $aux_ini && $f_ini < $aux_fin) {
            //     return true;
            // }
            // if ($f_fin > $aux_ini && $f_fin < $aux_fin) {
            //     return true;
            // }
            if (($f_ini >= $aux_ini && $f_ini < $aux_fin) || 
                ($f_fin > $aux_ini && $f_fin <= $aux_fin) ||
                ($f_ini <= $aux_ini && $f_fin >= $aux_fin)) {
                // Si hay solapamiento, retorna true (no disponible)
                return true;
            }
        }
        return false;
    }
    function verificarHoras($ini,$fin) {
        $f_ini = strtotime($ini);
        $f_fin = strtotime($fin);
        if ($f_fin <= $f_ini) {
            // La fecha fin no es mayor a la fecha inicio
            return true;
        } else {
            // En cualquier otro caso
            return false;
        }
    }
    function verificarInicio($ini) {
        $f_ini = strtotime($ini);
        $fecha = strtotime(date('Y-m-d H:i:s'));
        if ($f_ini < $fecha) {
            // La fecha inicio es anterior a la actual
            return true;
        } else {
            // En cualquier otro caso
            return false;
        }
    }
    function tituloCita($id) {
        $pac = Paciente::find($id);
        return $pac->nombres . ' ' . $pac->apellidos;
    }
    public function show($id)
    {
        $cita = Cita::with(['paciente','medico'])->find($id);
        if(!$cita){
            return response()->json(['message' => 'Cita no encontrada'], 409);
        }
        return response()->json($cita);
    }
    public function update(Request $request, $id)
    {
        $cita = Cita::find($id);
        if(!$cita){
            return response()->json(['message' => 'Cita no encontrada'], 409);
        }
        if ($cita->estado != 'EN ESPERA') {
            return response()->json('La cita no puede ser modificada', 409);
        }
        if ($this->verificarHoras($request->fecha_inicio,$request->fecha_fin)) {
            return response()->json('Revise las fechas', 409);
        };
        if ($this->verificarDisponibilidad($request->fecha_inicio,$request->fecha_fin,$cita->id)) {
            return response()->json('Horario no disponible', 409);
        };
        // $cita->update($request->all());
        $cita->update([
            'titulo'=>$this->tituloCita($request->paciente_id),
            'fecha'=>$request->fecha,
            'fecha_inicio'=>$request->fecha_inicio,
            'fecha_fin'=>$request->fecha_fin,
            'observacion'=>$request->observacion,
            'estado'=> 'EN ESPERA',

        ]);
        return response()->json($cita);
    }
    public function destroy($id)
    {
        $cita = Cita::find($id);
        if(!$cita){
            return response()->json(['message' => 'Cita no encontrada'], 409);
        }
        if ($cita->estado != 'EN ESPERA') {
            return response()->json('La cita no puede ser cancelada', 409);
        }
        $cita->estado = 'CANCELADA';
        $cita->save();
        return response()->json(['message' => 'Cita cancelada']);
    }
    public function encurso(Request $request) {
        $cita = Cita::find($request->cita_id);
        if (!$cita) {
            return response()->json('Registro no encontrado', 409);
        }
        if ($cita->estado != 'EN ESPERA') {
            return response()->json('La cita debe estar en espera para ser atendida', 409);
        }
        $valid_otra_cita = Cita::where('id','!=',$cita->id)
        ->where('user_id',Auth::user()->id)
        ->where('paciente_id',$cita->paciente_id)
        ->where('estado','EN CURSO')->first();
        if ($valid_otra_cita) {
            // hay una cita del paciente en curso
            return response()->json('Hay una cita en curso con: ' . $valid_otra_cita->paciente->nombres . ', debe terminarla para iniciar otra', 409);
        }
        
        $valid_dia = Cita::whereDate('fecha_inicio','!=',date('Y-m-d'))
        ->find($request->cita_id);
        if ($valid_dia) {
            // la cita no es para hoy
            return response()->json('La cita se programo para la fecha: ' . date('d/m/Y H:i',strtotime($cita->fecha_inicio)), 409);
        }

        try {
            DB::beginTransaction();
            $cita->estado = 'EN CURSO';
            $cita->save();


            $newData = new Consulta;
            $newData->fecha = date('Y-m-d H:i:s');
            $newData->activo = true;
            $newData->paciente_id = $cita->paciente_id;
            $newData->cita_id = $cita->id;
            $newData->user_id = Auth::user()->id;
            $newData->save();

            // $newInfo = new Informacion;
            // $newInfo->fecha = date('Y-m-d H:i:s');
            // $newInfo->paciente_id = $cita->paciente_id;
            // $newInfo->cita_id = $cita->id;
            // $newInfo->save();

            DB::commit();
            return response()->json(['success' => 'Cita en curso']);
        } catch (\Exception $th) {
            DB::rollback();
            //throw $th;
            return response()->json($th, 409);
        }
    }
    public function terminar(Request $request) {
        $cita = Cita::find($request->cita_id);
        if (!$cita) {
            return response()->json('Registro no encontrado', 409);
        }
        if ($cita->estado != 'EN CURSO') {
            return response()->json('La cita debe estar en curso para ser terminada', 409);
        }
        $cita->estado = 'TERMINADA';
        $cita->save();

        return response()->json(['success' => 'Cita terminada']);
    }
}