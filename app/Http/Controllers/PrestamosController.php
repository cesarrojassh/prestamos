<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PrestamosController extends Controller
{
    public function index(Request $request)
    {
        if(!$request->session()->get('id')) {
            return redirect('/');
        }
        return view('prestamos.index');
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
        return response()->json(['data' => []]);
    }
}
