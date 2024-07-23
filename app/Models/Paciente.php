<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Paciente extends Model
{
    use HasFactory;
    
    protected function nombres():Attribute {
        return new Attribute(
            set: fn($value) => mb_strtoupper($value)
        );
    }
    protected function apellidos():Attribute {
        return new Attribute(
            set: fn($value) => mb_strtoupper($value)
        );
    }
    
    protected $fillable = ['nombres', 'apellidos','fecha_nacimiento', 'celular', 'residencia', 'email', 'genero', 'ocupacion', 'img_url', 'user_id'];
    
    public function informacion() {
        return $this->hasOne(Consulta::class, 'paciente_id')->activo()->latest()->with(['cita']);
    }
    public function h_informacion() {
        return $this->hasMany(Consulta::class, 'paciente_id')->activo()->latest();
    }
    public function medicion() {
        return $this->hasOne(Informacion::class, 'paciente_id')->latest();
    }
    public function h_medicion() {
        return $this->hasMany(Informacion::class, 'paciente_id')->latest();
    }
    public function resultado() {
        return $this->hasOne(Resultado::class, 'paciente_id')->latest();
    }
    public function h_resultados() {
        return $this->hasMany(Resultado::class, 'paciente_id')->latest();
    }
    public function medico() {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function citas() {
        return $this->hasMany(Cita::class, 'paciente_id')->orderBy('fecha_inicio');
    }
}
