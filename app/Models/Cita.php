<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    use HasFactory;
    protected $fillable = ['titulo', 'fecha_inicio', 'fecha_fin', 'observacion', 'estado', 'paciente_id', 'user_id'];

    public function scopeSterm($query, $value, $prefijo) {
        $columns = ['nombres','apellidos'];
        $words_search = explode(' ', $value);
        if ($value) {
            return $query->where(function ($query) use ($columns, $prefijo, $words_search) {
                foreach ($words_search as $word) {
                    $query = $query->where(function ($query) use ($columns, $prefijo, $word) {
                        foreach ($columns as $column) {
                            $query->orWhere($prefijo.$column,'LIKE','%'.$word.'%');
                        }
                    });
                }
            });
        }
        return $query;
    }
    public function scopeSuser($query, $value, $prefijo) {
        if ($value) {
            return $query->where($prefijo.'user_id',$value);
        }
        return $query;
    }

    public function paciente() {
        return $this->belongsTo(Paciente::class, 'paciente_id');
    }
    public function medico() {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function consulta() {
        return $this->hasOne(Consulta::class, 'cita_id')->activo();
    }
}
