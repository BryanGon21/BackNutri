<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanDia extends Model
{
    use HasFactory;
    
    public function plan_dietas() {
        return $this->hasMany(PlanDieta::class, 'plan_dia_id')->with(['tipocomida']);
    }
}
