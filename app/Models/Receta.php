<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receta extends Model
{
    use HasFactory;

    public function tipocomida() {
        return $this->belongsTo(TipoComida::class, 'tipo_comida_id');
    }

    public function restricciones() {
        return $this->hasMany(Restriccion::class, 'receta_id');
    }
}
