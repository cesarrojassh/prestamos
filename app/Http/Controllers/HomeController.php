<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home(Request $request){
        if(!$request->session()->get('id')){
            return view('login.login');
        }

        return view('tablero.index');
    }
}
