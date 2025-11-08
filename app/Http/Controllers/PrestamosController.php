<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Formas;
use App\Models\Moneda;
use App\Models\Prestamo;
use App\Models\PrestamoDetalle;
use App\Models\Cliente;

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
        if(!$request->ajax()) {
            return response()->json([
                'status' => false,
                'message' => 'Solicitud inválida.'
            ]);
        }
        $clientes = Cliente::select('*')->get();
        return datatables()
        ->of($clientes)
        ->addColumn('estado_prestamos', function ($cliente) {
            $estado = $cliente->estado_prestamo;
            if ($estado == 0) {
                return '<span class="badge bg-success">DISPONIBLE</span>';
            } else {
                return '<span class="badge bg-danger">CON PRESTAMO</span>';
            }
            
        })
        
        ->rawColumns(['estado_prestamos'])
        ->make(true);
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
    if (!$request->ajax()) {
        return response()->json([
            'status' => 'error',
            'message' => 'Solicitud inválida.'
        ]);
    }

    $monto         = (float) $request->input('monto');
    $interes       = (float) $request->input('interes');
    $cuotas        = (int) $request->input('cuotas');
    $forma_pago    = $request->input('forma_pago');
    $fecha_emision = $request->input('fecha_emision');
    $page          = (int) $request->input('page', 1);
    $perPage       = 10;

    // Cálculos financieros
    $interes_total = $monto * ($interes / 100);
    $monto_total   = $monto + $interes_total;
    $valor_cuota   = round($monto_total / $cuotas, 2);

    // Generar todas las cuotas
    $fecha = \Carbon\Carbon::parse($fecha_emision);
    $cuotasArray = [];

    for ($i = 1; $i <= $cuotas; $i++) {
        switch ($forma_pago) {
            case '3': $fecha->addDay(); break;       
            case '4': $fecha->addWeek(); break;    
            case '5': $fecha->addDays(15); break;    
            case '6':
            default:  $fecha->addMonth(); break;     
        }

        $cuotasArray[] = [
            'nro' => $i,
            'fecha_vencimiento' => $fecha->format('d-m-Y'),
            'monto_cuota' => $valor_cuota
        ];
    }

   
    $total = count($cuotasArray);
    $totalPages = ceil($total / $perPage);
    $offset = ($page - 1) * $perPage;
    $cuotasPage = array_slice($cuotasArray, $offset, $perPage);

   
    $htmlCuotas = '';
    foreach ($cuotasPage as $cuota) {
        $htmlCuotas .= '<tr>';
        $htmlCuotas .= '<td class="text-center">' . $cuota['nro'] . '</td>';
        $htmlCuotas .= '<td class="text-center">' . str_replace('-', '/', $cuota['fecha_vencimiento']) . '</td>';
        $htmlCuotas .= '<td class="text-center">S/ ' . number_format($cuota['monto_cuota'], 2) . '</td>';
        $htmlCuotas .= '</tr>';
    }

   
    $htmlPaginacion = '<nav><ul class="pagination justify-content-center">';
    for ($i = 1; $i <= $totalPages; $i++) {
        $active = ($i == $page) ? 'active' : '';
        $htmlPaginacion .= "<li class='page-item {$active}'>
            <button class='page-link' onclick='cargarPaginaCuotas({$i})'>{$i}</button>
        </li>";
    }
    $htmlPaginacion .= '</ul></nav>';

    return response()->json([
        'status' => 'success',
        'data' => [
            'cuotasDetalle' => $htmlCuotas,
            'paginacion' => $htmlPaginacion,
            'valor_cuota' => $valor_cuota,
            'monto_total' => $monto_total,
            'interes_total' => $interes_total
        ]
    ]);
}

    public function guardar(Request $request)
    {
        if (!$request->ajax()) {
        return response()->json([
            'status' => 'error',
            'message' => 'Solicitud inválida.'
        ]);
      }
      
     
      $interes          = (float) $request->input('interes');
      $monto            = (float) $request->input('monto');
      $cuotas           = (int) $request->input('cuotas');
      $forma_pago       = $request->input('forma_pago');
      $moneda           = $request->input('moneda');
      $fecha_emision    = $request->input('fecha_emision');
      $idusuario        = (int) $request->session()->get('id');

      //Insertar en la tabla prestamo

      $prestamo = new Prestamo();
      $prestamo->cliente_id    = $request->input('cliente');
      $prestamo->idusuario     = $idusuario;
      $prestamo->monto         = $monto;
      $prestamo->interes       = $interes;
      $prestamo->cuotas        = $cuotas;
      $prestamo->forma_pago    = $forma_pago;
      $prestamo->moneda        = $moneda;
      $prestamo->fecha_emision = $fecha_emision;
      $prestamo->interes_total = $monto * ($interes / 100);
      $prestamo->monto_total   = $monto + $prestamo->interes_total;
      $prestamo->valor_cuota   = round($prestamo->monto_total / $cuotas, 2);
      $prestamo->save();





      $interesTotal     = $monto * ($interes / 100);
      $montoTotal       = $monto + $interesTotal;
      $valorCuota       = round($montoTotal / $cuotas, 2);
      $fecha            = \Carbon\Carbon::parse($fecha_emision);
      $cuotasArray      = [];
        for ($i = 1; $i <= $cuotas; $i++) {
            switch ($forma_pago) {
                case '3': $fecha->addDay(); break;       
                case '4': $fecha->addWeek(); break;    
                case '5': $fecha->addDays(15); break;    
                case '6':
                default:  $fecha->addMonth(); break;     
            }

            $cuota = new PrestamoDetalle();
            $cuota->prestamo_id = $prestamo->id;
            $cuota->nro_cuota = $i;
            $cuota->fecha_vencimiento = $fecha->format('Y-m-d');
            $cuota->monto_cuota = $valorCuota;
            $cuota->save();
        }
        // Actualizando a Cliente Con Prestamo
        
        Cliente::where('id', $request->input('cliente'))->update([
            'estado_prestamo' => 1
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Préstamo guardado con éxito.'
        ]);
    }

  

}

