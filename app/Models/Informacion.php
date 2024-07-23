<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Informacion extends Model
{
    use HasFactory;
    protected $fillable = [
      'peso',
      'altura',
      'imc',
      'circunferencia_cintura',
      'circunferencia_caderas',
      'presion_arterial',
      'nivel_actividad',
      // 'glucosa_ayunas',
      // 'colesterol_total',
      // 'colesterol_hdl',
      // 'colesterol_ldl',
      // 'trigliceridos',
      // 'hemoglobina',
      'fecha_registro',
      'observacion',
      'fecha',
      'paciente_id',
      'cita_id',
    ];
    public function paciente()
    {
      return $this->belongsTo(Paciente::class,'id');
    }
}
