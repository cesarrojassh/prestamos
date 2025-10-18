<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Comprobante de Pago - Cuota {{ $cuota->id }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            margin: 25px;
            color: #333;
        }
        h2, h3 {
            text-align: center;
            margin-bottom: 5px;
        }
        .section {
            margin-bottom: 15px;
        }
        .line {
            border-top: 1px solid #888;
            margin: 10px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        td {
            padding: 3px 0;
        }
        .footer {
            text-align: center;
            margin-top: 25px;
            font-size: 11px;
            color: #666;
        }
    </style>
</head>
<body>
    <h2>Comprobante de Pago</h2>
    <h3>Préstamo N° {{ $nro_prestamo}}</h3>

    <div class="section">
        <table>
            <tr><td><strong>Cliente:</strong></td><td>{{ $prestamo->cliente }}</td></tr>
            <tr><td><strong>DNI:</strong></td><td>{{ $prestamo->dni ?? '----' }}</td></tr>
            <tr><td><strong>Fecha de emisión:</strong></td><td>{{ now()->format('d/m/Y') }}</td></tr>
        </table>
    </div>

    <div class="line"></div>

    <div class="section">
        <table>
            <tr><td><strong>Monto Prestado:</strong></td><td>S/ {{ number_format($prestamo->monto, 2) }}</td></tr>
            <tr><td><strong>Tasa de interés:</strong></td><td>{{ $prestamo->interes }}%</td></tr>
            <tr><td><strong>Total a pagar:</strong></td><td>S/ {{ number_format($prestamo->monto_total, 2) }}</td></tr>
        </table>
    </div>

    <div class="line"></div>

    <div class="section">
        <table>
            <tr><td><strong>Cuota N°:</strong></td><td>{{ $cuota->nro_cuota }} de {{ $prestamo->cuotas }}</td></tr>
            <tr><td><strong>Fecha de vencimiento:</strong></td><td>{{ \Carbon\Carbon::parse($cuota->fecha_vencimiento)->format('d/m/Y') }}</td></tr>
            <tr><td><strong>Monto cuota:</strong></td><td>S/ {{ number_format($cuota->monto_cuota, 2) }}</td></tr>
            <tr><td><strong>Estado:</strong></td><td>{{ $cuota->estado == 1 ? 'Pagada' : 'Pendiente' }}</td></tr>
            <tr><td><strong>Fecha de pago:</strong></td><td>{{ \Carbon\Carbon::parse($cuota->updated_at)->format('d/m/Y') }}</td></tr>
        </table>
    </div>

    <div class="line"></div>

    <div class="section">
        <table>
            <tr><td><strong>Total pagado:</strong></td><td>S/ {{ number_format($total_pagado ?? 0, 2) }}</td></tr>
            <tr><td><strong>Saldo restante:</strong></td><td>S/ {{ number_format($saldo_restante ?? 0, 2) }}</td></tr>
        </table>
    </div>

    <div class="footer">
        <p>Gracias por su pago puntual.</p>
        <p>Comprobante generado automáticamente el {{ now()->format('d/m/Y H:i') }}</p>
    </div>
</body>
</html>
