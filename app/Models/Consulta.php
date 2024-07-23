<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consulta extends Model
{
    use HasFactory;

    public function scopeActivo($query) {
        return $query->where('activo',true);
    }
    public function medico() {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function cita() {
        return $this->belongsTo(Cita::class, 'cita_id');
    }
}
