<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        return Datatable()
        ->addColumn('action', function($monedas){
            $btn = '<button class="btn btn-sm btn-primary me-1" onclick="edit('.$monedas->id.')" title="Editar"><i class="bi bi-pencil-square"></i></button>';
            $btn .= '<button class="btn btn-sm btn-danger" onclick="eliminar('.$monedas->id.')" title="Eliminar"><i class="bi bi-trash"></i></button>';
            return $btn;
        })
        ->rawColumns(['action'])
        ->make(true);


    }
}
