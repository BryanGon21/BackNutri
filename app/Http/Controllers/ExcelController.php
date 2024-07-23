<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\InformacionImport;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls'
        ]);

        Excel::import(new InformacionImport, $request->file('excel_file'));

        return response()->json(['message' => 'Archivo Excel importado exitosamente.']);
    }
}