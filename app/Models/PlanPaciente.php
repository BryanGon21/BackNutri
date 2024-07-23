<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanPaciente extends Model
{
    use HasFactory;

    public function paciente() {
        return $this->belongsTo(Paciente::class, 'paciente_id');
    }
    public function usuario() {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function dietas() {
        return $this->hasMany(PlanDia::class, 'plan_paciente_id')->with(['plan_dietas']);
    }
}
