<?php

namespace App\Http\Controllers;

use App\Exports\VentasExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportExcelController extends Controller
{
    public function exportExcelVentasAll()
    {
        return Excel::download(new VentasExport, 'ventas.xlsx');
    }
}
