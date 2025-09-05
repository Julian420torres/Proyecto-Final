<?php

namespace App\Http\Controllers;


use App\Models\Venta;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Crypt;

class ExportPDFController extends Controller
{
    /**
     * Exportar en formato PDF el comprobante de venta
     */
    public function exportPdfComprobanteVenta(Request $request)
    {


        $venta = Venta::findOrfail($request->id);


        $pdf = Pdf::loadView('pdf.comprobante-venta', [
            'venta' => $venta,

        ]);

        return $pdf->stream('venta-' . $venta->id);
    }
}
