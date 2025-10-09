<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;


class LoginController extends Controller
{
    public function login(Request $request){
       $users = $request->input('users');
       $contra = $request->input('contra');
       if(empty($contra) || empty($users)){
           return response()->json([
            'status' => false,
            'msg'    => 'Por favor complete todos los campos',
            'type'   => 'info',
            'icon'   => 'fadeInanimated bx bx-info-circle',
        ]);
        
       }
       $usuario = Users::where('usuario', $users)->where('password', $contra)->first();
       if(empty($usuario)){
        return response()->json([
            'status' => false,
            'msg'    => 'Estas credenciales no coinciden en nuestros registros',
            'type'   => 'error',
            'icon'   => 'fadeInanimated bx bx-error',
        ]);
       }
       $request->session()->put([
            'id'        => $usuario->id,
            'nombre'    => $usuario->nombres,
            'usuario'   => $usuario->usuario,
            'idperfil'  => $usuario->idperfil,
        ]);
      
        return response()->json([
            'status' => true,
            'type'   => 'success',
            'icon'   => 'fadeIn animated bx bx-info-circle',
            'msg'    => 'Usuario logueado',
    
    
        ]);

      
    }

    public function logout(Request $request){
        $request->session()->flush();
        return redirect('/');
    }
}
