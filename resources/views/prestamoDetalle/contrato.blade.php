<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Contrato de Préstamo</title>
<style>
    body {
        font-family: DejaVu Sans, sans-serif;
        font-size: 12px;
        color: #222;
        margin: 35px;
        line-height: 1.6;
        text-align: justify;
    }
    h2 {
        text-align: center;
        margin-bottom: 5px;
    }
    .subtitulo {
        text-align: center;
        font-size: 12px;
        margin-bottom: 25px;
    }
    .datos {
        margin-bottom: 20px;
        border: 1px solid #000;
        padding: 10px;
        font-size: 12px;
    }
    ol {
        margin: 0;
        padding-left: 18px;
    }
    .firma {
        margin-top: 60px;
        text-align: center;
    }
    .firma div {
        display: inline-block;
        width: 40%;
        margin: 0 5%;
    }
    .firma hr {
        border: 0;
        border-top: 1px solid #000;
        width: 100%;
        margin-bottom: 5px;
    }
</style>
</head>
<body>

<h2>CONTRATO DE PRÉSTAMO DE DINERO</h2>
<p class="subtitulo">N° {{ $nro_prestamo }}</p>

<div class="datos">
    <strong>PRESTAMISTA:</strong> {{ $prestamo->usuario }}<br>
    <strong>PRESTATARIO:</strong> {{ $prestamo->cliente }}<br>
    <strong>MONEDA:</strong> {{ $prestamo->moneda }}<br>
    <strong>MONTO DEL PRÉSTAMO:</strong> S/ {{ number_format($prestamo->monto_total, 2) }}<br>
    <strong>NÚMERO DE CUOTAS:</strong> {{ $prestamo->cuotas }}<br>
    <strong>INTERÉS:</strong> {{ number_format($prestamo->interes, 2) }} %<br>
    <strong>FORMA DE PAGO:</strong> {{ $prestamo->forma_pago }}<br>
    <strong>FECHA DE EMISIÓN:</strong> {{ \Carbon\Carbon::parse($prestamo->fecha)->format('d/m/Y') }}
</div>

<p>
Por el presente documento privado, el <strong>PRESTAMISTA</strong> identificado como {{ $prestamo->usuario }},
y el <strong>PRESTATARIO</strong> {{ $prestamo->cliente }}, convienen celebrar el presente
<strong>CONTRATO DE PRÉSTAMO DE DINERO</strong> de acuerdo con las siguientes cláusulas:
</p>

<ol>
    <li><strong>OBJETO DEL CONTRATO:</strong><br>
    El PRESTAMISTA entrega al PRESTATARIO la suma de 
    <strong>S/ {{ number_format($prestamo->monto_total, 2) }}</strong> ({{ $prestamo->moneda }}),
    quien declara haber recibido dicho monto a su entera satisfacción, comprometiéndose a devolverlo
    en las condiciones pactadas.</li>

    <li><strong>PLAZO Y FORMA DE PAGO:</strong><br>
    El PRESTATARIO se obliga a devolver el monto total del préstamo en 
    <strong>{{ ($prestamo->cuotas) }} cuotas</strong> iguales y consecutivas,
    conforme al cronograma de pagos adjunto, en la forma de pago 
    <strong>{{ $prestamo->forma_pago }}</strong>.
    
   
    </li>

    <li><strong>INTERÉS APLICABLE:</strong><br>
    El préstamo generará un interés del 
    <strong>{{ number_format($prestamo->interes, 2) }}%</strong> sobre el monto total otorgado,
    calculado proporcionalmente según el número de cuotas.
    </li>

    <li><strong>GARANTÍA:</strong><br>
    El presente préstamo se otorga sin garantía específica, quedando el PRESTATARIO
    obligado con todos sus bienes presentes y futuros hasta la cancelación total del préstamo.
    </li>

    <li><strong>INCUMPLIMIENTO:</strong><br>
    En caso de falta de pago de una o más cuotas en la fecha establecida,
    el PRESTAMISTA podrá dar por vencido el plazo del préstamo y exigir el pago inmediato
    del total adeudado, incluidos intereses y gastos adicionales que correspondan.</li>

    <li><strong>CRONOGRAMA DE PAGOS:</strong><br>
    El cronograma detallado de cuotas, fechas de vencimiento, capital, intereses y montos totales
    forma parte integrante de este contrato y se entrega junto con el presente documento.</li>

    <li><strong>DOMICILIO CONTRACTUAL:</strong><br>
    Ambas partes fijan como domicilio contractual las direcciones registradas en el sistema del PRESTAMISTA,
    donde se considerarán válidas todas las notificaciones que se realicen.</li>

    <li><strong>JURISDICCIÓN Y LEY APLICABLE:</strong><br>
    Para la interpretación y cumplimiento de este contrato, ambas partes se someten a la jurisdicción
    de los tribunales competentes de la ciudad de ______________________, renunciando expresamente
    a cualquier otro fuero o jurisdicción.</li>
</ol>

<p>
En constancia de conformidad, ambas partes firman el presente contrato en dos ejemplares del mismo tenor,
en la ciudad de ______________________, a los {{ now()->format('d') }} días del mes de 
{{ now()->translatedFormat('F') }} del {{ now()->year }}.
</p>

<div class="firma">
    <div>
        <hr>
        <strong>PRESTAMISTA</strong><br>
        {{ $prestamo->usuario }}
    </div>
    <div>
        <hr>
        <strong>PRESTATARIO</strong><br>
        {{ $prestamo->cliente }}
    </div>
</div>

</body>
</html>
