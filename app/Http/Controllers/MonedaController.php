<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Moneda;

class MonedaController extends Controller
{
    public function index(Request $request)
    {
      if(!$request->session()->get('id')) {
            return redirect('/');
        }
        return view('moneda.index');
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
        $monedas = Moneda::select('*')->orderBy('id', 'desc')->get();
        return Datatables()
        ->of($monedas)
        ->addColumn('action', function($monedas){
            $id = $monedas->id;
                 $btn = '<button type="button" class="btn btn-sm btn-primary btn_detail" data-id="'.$id.'" 
                    style="padding: 3px 6px; font-size: 12px;">
                    <i class="bi bi-pencil-square"></i>
                </button> <button type="button" class="btn btn-sm btn-danger btn-danger" data-id="'.$id.'" 
                    style="padding: 3px 6px; font-size: 12px;">
                    <i class="bi bi-trash"></i>
                </button> ';
            return $btn;
        })
        ->rawColumns(['action'])
        ->make(true);
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
       
        $moneda = new Moneda();
        $moneda->nombre = strtoupper($request->moneda_nombre);
        $moneda->save();
        return response()->json([
            'status' => true,
            'msg'    => 'Moneda registrada con éxito',
            'type'   => 'success',
            'icon'   => 'bi bi-check-circle',
        ]);
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
        $moneda = Moneda::find($id);
        
        if(!$moneda){
            return response()->json([
                'status' => false,
                'msg'    => 'Moneda no encontrada, intente nuevamente',
                'type'   => 'warning',
                'icon'   => 'bi bi-exclamation-triangle',
            ]);
        }
        return response()->json([
            'status' => true,
            'data'   => $moneda,
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
        $moneda = Moneda::find($id);
        
        if(!$moneda){
            return response()->json([
                'status' => false,
                'msg'    => 'Moneda no encontrada, intente nuevamente',
                'type'   => 'warning',
                'icon'   => 'bi bi-exclamation-triangle',
            ]);
        }
        $moneda->nombre = strtoupper($request->editar_nombre);
        $moneda->save();
        return response()->json([
            'status' => true,
            'msg'    => 'Moneda actualizada con éxito',
            'type'   => 'success',
            'icon'   => 'bi bi-check-circle',
        ]);
    }

    public function destroy(Request $request)
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
        $moneda = Moneda::find($id);
        
        if(!$moneda){
            return response()->json([
                'status' => false,
                'msg'    => 'Moneda no encontrada, intente nuevamente',
                'type'   => 'warning',
                'icon'   => 'bi bi-exclamation-triangle',
            ]);
        }
        $moneda->delete();
        return response()->json([
            'status' => true,
            'msg'    => 'Moneda eliminada con éxito',
            'type'   => 'success',
            'icon'   => 'bi bi-check-circle',
        ]);
    }
}
