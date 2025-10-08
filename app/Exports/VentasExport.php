<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMapping;
use App\Models\Venta;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class VentasExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize,  WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Venta::all();
    }

    /**
     * @param Invoice $invoice
     */
    public function map($venta): array
    {
        return [
            $venta->cliente->persona->razon_social,
            $venta->comprobante->tipo_comprobante ?? 'N/A',
            $venta->numero_comprobante,
            Carbon::parse($venta->fecha_hora)->format('d/m/Y'),
            Carbon::parse($venta->fecha_hora)->format('h:i A'),
            number_format($venta->impuesto, 3, ',', '.'),
            number_format($venta->total, 3, ',', '.')
        ];
    }
    public function headings(): array
    {
        return [
            'Cliente',
            'Comprobante',
            'Numero de comprobante',
            'Fecha',
            'Hora',
            'Impuesto',
            'Total',
        ];
    }
    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],


        ];
    }
}
