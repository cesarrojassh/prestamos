<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Formas;

class FormapagoController extends Controller
{
    public function index(Request $request)
    {
        if(!$request->session()->get('id')) {
            return redirect('/');
        }
        return view('formapago.index');
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

        try {
            $formapago = new Formas();
            $formapago->nombre = strtoupper($request->forma_pago_nombre);
            $formapago->save();

            return response()->json([
                'status' => true,
                'msg'    => 'Forma de pago registrada con éxito',
                'type'   => 'success',
                'icon'   => 'bi bi-check-circle',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'msg'    => 'Error al registrar la forma de pago, intente nuevamente',
                'type'   => 'error',
                'icon'   => 'bi bi-x-circle',
            ]);
        }
    }

    public function lista(Request $request){
        if(!$request->ajax()){
            return response()->json([
                'status' => false,
                'msg'    => 'Error en la solicitud, intente nuevamente',
                'type'   => 'warning',
                'icon'   => 'bi bi-exclamation-triangle',
            ]);
        }
        $formaspago = Formas::select('*')->orderBy('id', 'desc')->get();
        return Datatables()
        ->of($formaspago)
        ->addColumn('action', function($formaspago){
            $id = $formaspago->id;
                 $btn = '<button type="button" class="btn btn-sm btn-primary btn_detail" data-id="'.$id.'" 
                    style="padding: 3px 6px; font-size: 12px;">
                    <i class="bi bi-pencil-square"></i>
                </button> 
                <button type="button" class="btn btn-sm btn-danger btn-delete" data-id="'.$id.'" 
                    style="padding: 3px 6px; font-size: 12px;">
                    <i class="bi bi-trash"></i>
                </button> ';
            return $btn;
        })

        ->rawColumns(['action'])
        ->make(true);
    }

    public function delete(Request $request)
    {
        if(!$request->ajax()){
            return response()->json([
                'status' => false,
                'msg'    => 'Error en la solicitud, intente nuevamente',
                'type'   => 'warning',
                'icon'   => 'bi bi-exclamation-triangle',
            ]);
        }

        try {
            $id = $request->id;
            $formapago = Formas::find($id);
            if (!$formapago) {
                return response()->json([
                    'status' => false,
                    'msg'    => 'Forma de pago no encontrada',
                    'type'   => 'error',
                    'icon'   => 'bi bi-x-circle',
                ]);
            }
            $formapago->delete();

            return response()->json([
                'status' => true,
                'msg'    => 'Forma de pago eliminada con éxito',
                'type'   => 'success',
                'icon'   => 'bi bi-check-circle',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'msg'    => 'Error al eliminar la forma de pago, intente nuevamente',
                'type'   => 'error',
                'icon'   => 'bi bi-x-circle',
            ]);
        }
    }

    public function edit(Request $request)
    {
      if(!$request->ajax()){
            return response()->json([
                'status' => false,
                'msg'    => 'Error en la solicitud, intente nuevamente',
                'type'   => 'warning',
                'icon'   => 'bi bi-exclamation-triangle',
            ]);
        }
        $id = $request->id;
        $formapago = Formas::find($id);
        
        if(!$formapago){
            return response()->json([
                'status' => false,
                'msg'    => 'Forma de pago no encontrada, intente nuevamente',
                'type'   => 'error',
                'icon'   => 'bi bi-x-circle',
            ]);
        }
        return response()->json([
            'status' => true,
            'data'   => $formapago,
        ]);
    }

    public function update(Request $request)
    {
      if(!$request->ajax()){
            return response()->json([
                'status' => false,
                'msg'    => 'Error en la solicitud, intente nuevamente',
                'type'   => 'warning',
                'icon'   => 'bi bi-exclamation-triangle',
            ]);
        }
        $id = $request->id;
        $formapago = Formas::find($id);

        if(!$formapago){
            return response()->json([
                'status' => false,
                'msg'    => 'Forma de pago no encontrada, intente nuevamente',
                'type'   => 'error',
                'icon'   => 'bi bi-x-circle',
            ]);
        }

        try {
            $formapago->nombre = strtoupper($request->editar_nombre_forma);
            $formapago->save();

            return response()->json([
                'status' => true,
                'msg'    => 'Forma de pago actualizada con éxito',
                'type'   => 'success',
                'icon'   => 'bi bi-check-circle',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'msg'    => 'Error al actualizar la forma de pago, intente nuevamente',
                'type'   => 'error',
                'icon'   => 'bi bi-x-circle',
            ]);
        }
    }
}
