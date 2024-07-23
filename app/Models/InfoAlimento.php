<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfoAlimento extends Model
{
    use HasFactory;
    
    protected function nombre():Attribute {
        return new Attribute(
            set: fn($value) => mb_strtoupper($value)
        );
    }
    
    public function unidad() {
        return $this->belongsTo(Unidad::class, 'unidad_id');
    }
}
