<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprobante de venta</title>
</head>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;
    }

    .boleta {
        max-width: 600px;
        margin: 20px auto;
        padding: 20px;
        background: #fff;
        border: 1px solid #ddd;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .header {
        margin-bottom: 15px;
    }

    .header .column .column {
        text-align: center;
        margin-bottom: 10px;
    }

    .header .column h1 {
        font-size: 14px;
        margin-bottom: 5px;
    }

    .header .column div {
        font-size: 12px;
        margin-bottom: 5px;
    }

    .header .bordered {
        border: 1px solid #000;
        padding: 10px;
        font-size: 12px;
        text-align: center;
    }

    .datos {
        margin-bottom: 20px;
    }

    .datos div {
        font-size: 12px;
        margin-bottom: 5px;
    }

    .tabla {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    .tabla th,
    .tabla td {
        border: 1px solid #ddd;
        text-align: left;
        padding: 8px;
        font-size: 14px;
    }

    .tabla th {
        background-color: #f4f4f4;
        font-weight: bold;
    }

    .footer {
        text-align: center;
        font-size: 12px;
        margin-top: 20px;
    }

    .footer .stamp {
        display: inline-block;
        margin-top: 10px;
        font-size: 14px;
        font-weight: bold;
        color: red;
    }

    .totales strong {
        font-size: 14px;
    }
</style>

<body>
    <div class="boleta">
        <div class="header">
            <div class="column">
                <div class="column bordered">
                    <div><strong>{{ strtoupper($venta->comprobante->nombre) }} COMPROBANTE DE VENTA</strong></div>
                    <div><strong>{{ $venta->numero_comprobante }}</strong></div>
                </div>
            </div>
        </div>

        <div class="datos">
            <div><strong>Nombre:</strong> {{ strtoupper($venta->cliente->persona->razon_social) }}</div>
            <div><strong>Dirección:</strong> {{ strtoupper($venta->cliente->persona->direccion) }}</div>
            <div>
                <strong>{{ strtoupper($venta->cliente->persona->documento->tipo_documento ?? 'DOCUMENTO') }}:</strong>
                {{ $venta->cliente->persona->numero_documento }}
            </div>
            <div><strong>Fecha:</strong> {{ date('d/m/Y', strtotime($venta->fecha_hora)) }}</div>
            <div><strong>Hora:</strong> {{ date('H:i', strtotime($venta->fecha_hora)) }}</div>
        </div>

        <table class="tabla">
            <thead>
                <tr>
                    <th>Cant.</th>
                    <th>Unidad</th>
                    <th>Descripción</th>
                    <th>Precio unitario</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($venta->productos as $detalle)
                    <tr>
                        <td>{{ $detalle->pivot->cantidad }}</td>
                        <td>{{ $detalle->nombre }}</td>
                        <td>{{ $detalle->descripcion ?? $detalle->nombre }}</td>
                        <td>{{ number_format($detalle->pivot->precio_venta, 2, ',', '.') }}</td>
                        <td>{{ number_format($detalle->pivot->cantidad * $detalle->pivot->precio_venta, 2, ',', '.') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="datos totales">
            <div><strong>Impuesto:</strong> {{ number_format($venta->impuesto, 2, ',', '.') }}</div>
            <div><strong>Total:</strong> {{ number_format($venta->total, 2, ',', '.') }}</div>
            <div><strong>Cajero:</strong> {{ $venta->user->empleado->razon_social ?? $venta->user->name }}</div>
        </div>

        <div class="footer">
            NO SE ACEPTAN CAMBIOS NI DEVOLUCIONES
        </div>
    </div>
</body>

</html>
