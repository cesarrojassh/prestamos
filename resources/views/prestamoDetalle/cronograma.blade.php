<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Cronograma de Cuotas</title>
<style>
    body {
        font-family: DejaVu Sans, sans-serif;
        font-size: 12px;
        color: #333;
        margin: 25px;
    }
    h2, h4 {
        text-align: center;
        margin: 0;
    }
    .info {
        margin-top: 15px;
        border: 1px solid #000;
        padding: 10px;
        width: 100%;
    }
    .info td {
        padding: 4px 8px;
        vertical-align: top;
    }
    table.cronograma {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
    }
    table.cronograma th, table.cronograma td {
        border: 1px solid #000;
        padding: 6px;
        text-align: center;
    }
    table.cronograma th {
        background-color: #f2f2f2;
        font-weight: bold;
    }
    .total {
        background-color: #e6f3ff;
        font-weight: bold;
    }
</style>
</head>
<body>

<h2>CRONOGRAMA DE CUOTAS</h2>
<h4>Préstamo N° {{ $nro_prestamo }}</h4>

<table class="info">
    <tr>
        <td><strong>Cliente:</strong> {{ $prestamo->cliente }}</td>
        <td><strong>Moneda:</strong> {{ $prestamo->moneda }}</td>
    </tr>
    <tr>
        <td><strong>Forma de Pago:</strong> {{ $prestamo->forma_pago }}</td>
        <td><strong>Usuario:</strong> {{ $prestamo->usuario }}</td>
    </tr>
    <tr>
        <td><strong>Monto Total:</strong> S/ {{ number_format($prestamo->monto_total, 2) }}</td>
        <td><strong>Total Pagado:</strong> S/ {{ number_format($total_pagado, 2) }}</td>
    </tr>
    <tr>
        <td colspan="2"><strong>Saldo Restante:</strong> S/ {{ number_format($saldo_restante, 2) }}</td>
    </tr>
</table>

<table class="cronograma">
    <thead>
        <tr>
            <th>N° Cuota</th>
            <th>Fecha de Pago</th>
            <th>Monto</th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody>
        @foreach($cuota as $i => $item)
            <tr>
                <td>{{ $item->nro_cuota }}</td>
                <td>{{ \Carbon\Carbon::parse($item->fecha_vencimiento)->format('d/m/Y') }}</td>
                <td>S/ {{ number_format($item->monto_cuota, 2) }}</td>
                <td>
                    @if($item->estado == 1)
                        Pagada
                    @else
                        Pendiente
                    @endif
                </td>
            </tr>
        @endforeach
        <tr class="total">
            <td colspan="2">Total</td>
            <td>S/ {{ number_format($cuota->sum('monto_cuota'), 2) }}</td>
            <td></td>
        </tr>
    </tbody>
</table>

<br>
<p style="text-align:right; font-size:11px;">
    <em>Generado el {{ now()->format('d/m/Y H:i') }}</em>
</p>

</body>
</html>
