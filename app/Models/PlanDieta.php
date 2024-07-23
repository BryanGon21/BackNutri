<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanDieta extends Model
{
    use HasFactory;
    
    public function tipocomida() {
        return $this->belongsTo(TipoComida::class, 'tipo_comida_id');
    }
}
