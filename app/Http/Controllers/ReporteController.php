<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReporteController extends Controller
{
    public function datos() {
        $data = [
            'consultas' => 1,
            'pacientes' => 1,
        ];
        return response()->json($data, 200);
    }
}
