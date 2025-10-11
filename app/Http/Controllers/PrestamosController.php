<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Formas;
use App\Models\Moneda;

class PrestamosController extends Controller
{
    public function index(Request $request)
    {
        if(!$request->session()->get('id')) {
            return redirect('/');
        }

        $monedas = Moneda::all();
        $formas = Formas::all();
        return view('prestamos.index', compact('monedas', 'formas'));
    }

    public function listar(Request $request)
    {
        if(!$request->session()->get('id')) {
            return redirect('/');
        }
        return response()->json(['data' => []]);
    }

    public function simular(Request $request)
    {
        if(!$request->session()->get('id')) {
            return redirect('/');
        }
        
         $cliente = $request->input('cliente');
         $monto = (float) $request->input('monto');
         $interes = (float) $request->input('interes');
         $cuotas = (int) $request->input('cuotas');
         $forma_pago = $request->input('forma_pago');
         $moneda = $request->input('moneda');
         $fecha_emision = $request->input('fecha_emision');

         $interesTotal = $monto * ($interes / 100);
         $montoTotal = $monto + $interesTotal;
         $valorCuota = $montoTotal / $cuotas;
        
        return response()->json([
            
            'interesTotal' => round($interesTotal, 2),
            'montoTotal' => round($montoTotal, 2),
            'valorCuota' => round($valorCuota, 2),
           
        ]);

    }

   public function store(Request $request)
{
    if(!$request->ajax()){
        return response()->json([
            'status' => false,
            'msg'    => 'Error en la solicitud, intente nuevamente',
            'type'   => 'warning',
            'icon'   => 'bi bi-exclamation-triangle',
        ]);
    }

    $cliente       = $request->input('cliente');
    $monto         = (float) $request->input('monto');
    $interes       = (float) $request->input('interes');
    $cuotas        = (int) $request->input('cuotas');
    $forma_pago    = $request->input('forma_pago');
    $moneda        = $request->input('moneda');
    $fecha_emision = $request->input('fecha_emision');
    $idusuario     = $request->session()->get('id');

    // ⚙️ Validación básica
    if (!$cliente || $monto <= 0 || $interes < 0 || $cuotas <= 0) {
        return response()->json([
            'status' => false,
            'msg'    => 'Por favor complete todos los campos correctamente.',
            'type'   => 'error',
            'icon'   => 'bi bi-x-circle',
        ]);
    }

    // 💰 Calcular valores financieros
    $interesTotal = $monto * ($interes / 100);
    $montoTotal   = $monto + $interesTotal;
    $valorCuota   = $montoTotal / $cuotas;

    // 📅 Calcular fechas según forma de pago
    $fecha = new \DateTime($fecha_emision);
    $cuotasDetalle = [];

    for ($i = 1; $i <= $cuotas; $i++) {
        // Aumentar la fecha según el tipo de forma de pago
        switch (strtolower($forma_pago)) {
            case '3':
                $fecha->modify('+1 day');
                break;
            case '4':
                $fecha->modify('+7 days');
                break;
            case '5':
                $fecha->modify('+15 days');
                break;
            case '6':
            default:
                $fecha->modify('+1 month');
                break;
        }

        $cuotasDetalle[] = [
            'nro' => $i,
            'fecha_vencimiento' => $fecha->format('Y-m-d'),
            'monto_cuota' => round($valorCuota, 2)
        ];
    }
    $htmlCuotas = '';
    foreach ($cuotasDetalle as $cuota) {
        $htmlCuotas .= '<tr>';
        $htmlCuotas .= '<td>' . $cuota['nro'] . '</td>';
        $htmlCuotas .= '<td>' . $cuota['fecha_vencimiento'] . '</td>';
        $htmlCuotas .= '<td>S/ ' . number_format($cuota['monto_cuota'], 2)  . '</td>';
        $htmlCuotas .= '</tr>';
    }
   
    return response()->json([
        'status' => true,
        'msg'    => 'Cálculo realizado correctamente.',
        'type'   => 'success',
        'icon'   => 'bi bi-check-circle',
        'data'   => [
            'interesTotal' => round($interesTotal, 2),
            'montoTotal'   => round($montoTotal, 2),
            'valorCuota'   => round($valorCuota, 2),
            'cuotasDetalle' => $htmlCuotas
        ]
    ]);
}

}

