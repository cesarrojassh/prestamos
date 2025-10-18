<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prestamo;
use App\Models\PrestamoDetalle;
use App\Models\Cliente;
use App\Models\Moneda;
use App\Models\Formapago;
use PDF;

class PrestamoDetalleController extends Controller
{
    public function detalle(Request $request)
    {
        if(!$request->session()->get('id')) {
            return redirect('/');
        }

        return view('prestamoDetalle.index');
    }

    public function listar(Request $request)
    {
        if(!$request->ajax()){
            return response()->json([
                'status' => false,
                'msg'    => 'Error en la solicitud, intente nuevamente',
                'type'   => 'warning',
                'icon'   => 'bi bi-exclamation-triangle',
            ]);
        }

        $prestamos = Prestamo::select('prestamo.*', 'prestamo.id as idprestamo', 'cliente.nom as cliente', 'monedas.nombre as moneda', 'formas.nombre as forma_pago', 'user.usuario as usuario')
        ->join('cliente', 'cliente.id', '=', 'prestamo.cliente_id')
        ->join('monedas', 'monedas.id',   '=', 'prestamo.moneda')
        ->join('formas', 'formas.id',   '=', 'prestamo.forma_pago')
        ->join('user', 'user.id',     '=', 'prestamo.idusuario')
        ->get();

       
        return datatables()
        ->of($prestamos)
        ->addColumn('acciones', function ($prestamo) {
            return '<a class="text-warning" onclick="verDetalle('.$prestamo->id.')"><i class="bi bi-cash-stack me-1 fs-6"></i></a>';
        })
        ->addColumn('nro_prestamos', function ($prestamo) {
            $nro = str_pad($prestamo->idprestamo, 6, "0", STR_PAD_LEFT);
            return $nro;
        })
        ->addColumn('monto', function ($prestamo) {
            return 'S/' .number_format($prestamo->monto, 2);
        })
        ->addColumn('interes', function ($prestamo) {
            return number_format($prestamo->interes).'%';
        })
        ->addColumn('total', function ($prestamo) {
            return number_format($prestamo->total, 2);
        })
        ->addColumn('cuotas', function ($prestamo) {
            return $prestamo->cuotas;
        })
        ->addColumn('moneda', function ($prestamo) {
            return $prestamo->moneda;
        })
        ->addColumn('forma_pago', function ($prestamo) {
            return $prestamo->forma_pago;
        })
        ->addColumn('usuario', function ($prestamo) {
            return $prestamo->usuario;
        })
        ->addColumn('fecha_emision', function ($prestamo) {
            $fecha = date('d/m/Y', strtotime($prestamo->fecha_emision));
            return $fecha;
        })
        ->addColumn('estado', function ($prestamo) {
            $estado = $prestamo->estado;
            if ($estado == 'activo') { 
                return '<span class="badge bg-warning">Pendiente</span>';
            } else {
                return '<span class="badge bg-danger">Cancelado</span>';
            }
        })
        ->rawColumns(['acciones', 'nro_prestamos', 'monto', 'interes', 'total', 'cuotas', 'moneda', 'forma_pago', 'usuario', 'estado', 'fecha_emision'])
        ->make(true);

    }

    public function pagarCuotas(Request $request){
        if(!$request->ajax()){
            return response()->json([
                'status' => false,
                'msg'    => 'Error en la solicitud, intente nuevamente',
                'type'   => 'warning',
                'icon'   => 'bi bi-exclamation-triangle',
            ]);
        }
        
        $id         = $request->id;
        $cuotas = PrestamoDetalle::where('prestamo_id', $id)->get();
        return datatables()
        ->of($cuotas)
        ->addColumn('nro_cuota', function ($cuota) {
            return $cuota->nro_cuota;
        })
        ->addColumn('fecha', function ($cuota) {
            $fecha = date('d/m/Y', strtotime($cuota->fecha_vencimiento));
            return $fecha;
        })
        ->addColumn('monto', function ($cuota) {
            return 'S/' .number_format($cuota->monto_cuota, 2);
        })
        ->addColumn('estado', function ($cuota) {
            $estado = $cuota->estado;                 
            if ($estado == 0) { 
                return '<span class="badge bg-warning">Pendiente</span>';
            } else {
                return '<span class="badge bg-success">Pagado</span>';
            }
        })
        ->addColumn('acciones', function ($cuota) {
            if ($cuota->estado == 0) {
              return '<a class="text-warning" onclick="pagarCuota('.$cuota->id.', '.$cuota->prestamo_id.')"><i class="bi bi-cash-stack me-1 fs-7"></i></a>
               <a class="text-primary" title="Ver comprobante PDF" 
                    href="'.route('prestamos.pdf', ['prestamo' => $cuota->prestamo_id, 'cuota' => $cuota->id]).'" 
                    target="_blank">
                    <i class="bi bi-file-earmark-pdf me-1 fs-7"></i>
               </a>';  
            } else {
                return '<a class="text-warning" onclick="pagado()"><i class="bi bi-cash-stack me-1 fs-7"></i></a>
                 <a class="text-primary" title="Ver comprobante PDF" 
                    href="'.route('prestamos.pdf', ['prestamo' => $cuota->prestamo_id, 'cuota' => $cuota->id]).'" 
                    target="_blank">
                    <i class="bi bi-file-earmark-pdf me-1 fs-7"></i>
               </a>';   
            }
        })
        ->rawColumns(['nro_cuota', 'fecha', 'monto', 'estado', 'acciones'])
        ->make(true);
        
    }

    public function datos(Request $request){
        if(!$request->ajax()){
            return response()->json([
                'status' => false,
                'msg'    => 'Error en la solicitud, intente nuevamente',
                'type'   => 'warning',
                'icon'   => 'bi bi-exclamation-triangle',
            ]);
        }

         $id = $request->id;
         $prestamos = Prestamo::select('prestamo.*', 'prestamo.id as idprestamo', 'cliente.nom as cliente', 'monedas.nombre as moneda', 'formas.nombre as forma_pago', 'user.usuario as usuario')
        ->join('cliente', 'cliente.id', '=', 'prestamo.cliente_id')
        ->join('monedas', 'monedas.id',   '=', 'prestamo.moneda')
        ->join('formas', 'formas.id',   '=', 'prestamo.forma_pago')
        ->join('user', 'user.id',     '=', 'prestamo.idusuario')
        ->where('prestamo.id', $id)
        ->first();

        $C_pagadas      = PrestamoDetalle::where('prestamo_id', $id)->first();
        $cuotas_pagadas = PrestamoDetalle::where('prestamo_id', $id)->where('estado', 1)->count();



        $nro = str_pad($prestamos->idprestamo, 6, "0", STR_PAD_LEFT);
        if (!$prestamos) {
            return response()->json([
                'status' => false,
                'msg'    => 'Préstamo no encontrado',
                'type'   => 'warning',
                'icon'   => 'bi bi-exclamation-triangle',
            ]);
        }
        
        

        return response()->json([
            'status'        => true,
            'data'          => $prestamos,
            'nro'           => $nro,
            'cuota'         => $C_pagadas,
            'cuotas_pagadas'=> $cuotas_pagadas
        ]);
    }

    public function pagar(Request $request){
        if(!$request->ajax()){
            return response()->json([
                'status' => false,
                'msg'    => 'Error en la solicitud, intente nuevamente',
                'type'   => 'warning',
                'icon'   => 'bi bi-exclamation-triangle',
            ]);
        }

      
        $id = $request->id;
        $cuota = PrestamoDetalle::find($id);
        if (!$cuota) {
            return response()->json([
                'status' => false,
                'msg'    => 'Cuota no encontrada',
                'type'   => 'warning',
                'icon'   => 'bi bi-exclamation-triangle',
            ]);
        }

        if ($cuota->estado == 1) {
            return response()->json([
                'status' => false,
                'msg'    => 'La cuota ya ha sido pagada',
                'type'   => 'warning',
                'icon'   => 'bi bi-exclamation-triangle',
            ]);
        }

        $cuota->estado = 1;
        $cuota->save();

     
        $prestamo_id    = $cuota->prestamo_id;
        $total_cuotas   = PrestamoDetalle::where('prestamo_id', $prestamo_id)->count();
        $cuotas_pagadas = PrestamoDetalle::where('prestamo_id', $prestamo_id)->where('estado', 1)->count();
        if ($total_cuotas == $cuotas_pagadas) {
            $prestamo = Prestamo::find($prestamo_id);
            if ($prestamo) {
                $prestamo->estado = 'cancelado';
                $prestamo->save();
                
               
            }
        }
        

        return response()->json([
            'status' => true,
            'msg'    => 'Cuota pagada correctamente',
            'type'   => 'success',
            'icon'   => 'bi bi-check-circle',
        ]);
    }

    public function pdf($prestamo, $cuota)
    {
        $prestamos = Prestamo::select('prestamo.*', 'prestamo.id as idprestamo', 'cliente.nom as cliente', 'monedas.nombre as moneda', 'formas.nombre as forma_pago', 'user.usuario as usuario')
        ->join('cliente', 'cliente.id', '=', 'prestamo.cliente_id')
        ->join('monedas', 'monedas.id',   '=', 'prestamo.moneda')
        ->join('formas', 'formas.id',   '=', 'prestamo.forma_pago')
        ->join('user', 'user.id',     '=', 'prestamo.idusuario')
        ->where('prestamo.id', $prestamo)
        ->first();

        $nro_prestamo = str_pad($prestamos->idprestamo, 6, "0", STR_PAD_LEFT);

        $C_pagadas = PrestamoDetalle::where('id', $cuota)
        ->where('prestamo_id', $prestamo)
        ->firstOrFail();

        $total_pagado = PrestamoDetalle::where('prestamo_id', $prestamo)->where('estado', 1)->sum('monto_cuota');
        $saldo_restante = $prestamos->monto_total - $total_pagado;
        

         $pdf = PDF::loadView('prestamoDetalle.pdf', [
            'prestamo'      => $prestamos,
            'cuota'         => $C_pagadas,
            'total_pagado'  => $total_pagado,
            'saldo_restante'=> $saldo_restante,
            'nro_prestamo'  => $nro_prestamo
        ]);

        return $pdf->stream("Comprobante_Cuota_{$cuota}.pdf");

          
    }



}
