<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TipoComida extends Model
{
    use HasFactory;
    
    protected function nombre():Attribute {
        return new Attribute(
            set: fn($value) => mb_strtoupper($value)
        );
    }

    public function scopeHabilitado($query) {
        return $query->where('habilitado',true);
    }
}
