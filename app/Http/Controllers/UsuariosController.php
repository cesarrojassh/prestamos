<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use App\Models\Perfiles;



class UsuariosController extends Controller
{
    public function index(Request $request){
       
        if(!$request->session()->get('id')) {
            return redirect('/');
        }
        $perfil = Perfiles::where('estado', 0)->get();
       
        return view('usuarios.index', compact('perfil'));
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

         $usuarios = Users::select('*', 'perfiles.nombre as perfilnombre')
        ->join('perfiles', 'perfiles.id', '=', 'user.idperfil')
        ->get();

        return Datatables()
        ->of($usuarios)
         ->addColumn('action', function($usuarios) {
                $id = $usuarios->id;

                if ($usuarios->estado == '1') {
                    $btn = '
                        <button type="button" class="btn btn-sm btn-primary btn_detail" data-id="'.$id.'" 
                            style="padding: 3px 6px; font-size: 12px;">
                            <i class="bi bi-pencil-square"></i>
                        </button> 
                        <button type="button" class="btn btn-sm btn-success btn-activar" data-id="'.$id.'" 
                            style="padding: 3px 6px; font-size: 12px;">
                            <i class="bi bi-trash"></i>
                        </button>';
                } else {
                    $btn = '
                        <button type="button" class="btn btn-sm btn-primary btn_detail" data-id="'.$id.'" 
                            style="padding: 3px 6px; font-size: 12px;">
                            <i class="bi bi-pencil-square"></i>
                        </button> 
                        <button type="button" class="btn btn-sm btn-danger btn-delete" data-id="'.$id.'" 
                            style="padding: 3px 6px; font-size: 12px;">
                            <i class="bi bi-trash"></i>
                        </button>';
                }

                return $btn;
            })

         ->addColumn('estado', function ($usuarios) {
            $estado = $usuarios->estado;
            if ($estado == '0') { 
                return '<span class="badge bg-success">Activo</span>';
            } else {
                return '<span class="badge bg-warning">Desactivado</span>';
            }
        })
        ->rawColumns(['action', 'estado'])
        ->make(true);
    }

    public function store(Request $request){
        if(!$request->ajax()){
            return response()->json([
                'status' => false,
                'msg'    => 'Error en la solicitud, intente nuevamente',
                'type'   => 'warning',
                'icon'   => 'bi bi-exclamation-triangle',
            ]);
        }
        $dni = Users::where('dni', $request->user_numdoc)->first();
        if($dni){
            return response()->json([
                'status' => false,
                'msg'    => 'El número de documento ingresado ya está registrado',
                'type'   => 'warning',
                'icon'   => 'bi bi-exclamation-triangle',
            ]);
            return;
        }

        try {

            $user = new Users();
            $user->dni        = $request->user_numdoc;
            $user->nombres    = $request->user_nom;
            $user->usuario    = $request->user_usuario;
            $user->password   = $request->cli_password;
            $user->idperfil   = $request->idperfil;
            $user->estado     = 0;
            $user->save();

            if($user){
                return response()->json([
                    'status' => true,
                    'msg'    => 'Usuario registrado exitosamente',
                    'type'   => 'success',
                    'icon'   => 'bi bi-check-circle',
                ]);
            }
            else{
                
                return response()->json([
                    'status' => false,
                    'msg'    => 'Error al registrar el Usuario',
                    'type'   => 'error',
                    'icon'   => 'bi bi-x-circle',
                ]);

            }

        }
        catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'msg'    => 'Error: ' . $e->getMessage(),
                'type'   => 'error',
                'icon'   => 'bi bi-bug',
            ]);
        }
    }

    public function details(Request $request){
        if(!$request->ajax()){
            return response()->json([
               'status' => false,
                'msg'    => 'Error en la solicitud, intente nuevamente',
                'type'   => 'warning',
                'icon'   => 'bi bi-exclamation-triangle', 
            ]);
        }

        $users = Users::select('*')
        ->join('perfiles', 'perfiles.id', '=', 'user.idperfil')
        ->where('user.id', $request->id)
        ->first();

        $perfiles = Perfiles::get();
        if(!$users){
            return response()->json([
                'status' => false,
                'msg' => 'Usuario no encontrado',
                'type' => 'warning',
                'icon' => 'bi bi-exclamation-triangle',
            ]);
        }
        return response()->json([
            'status'     => true,
            'data'       => $users,
            'perfiles'   => $perfiles
        ]);



    }

    public function update(Request $request){
       if(!$request->ajax()){
            return response()->json([
               'status' => false,
                'msg'    => 'Error en la solicitud, intente nuevamente',
                'type'   => 'warning',
                'icon'   => 'bi bi-exclamation-triangle', 
            ]);
        } 
        if(empty($request->edit_numdoc) || empty($request->edit_nom) || empty($request->editidperfil) || empty($request->edit_password)){
            return response()->json([
                'status' => false,
                'msg' => 'Todos los campos deben estar llenados',
                'type' => 'warning',
                'icon' => 'bi bi-exclamation-triangle',
            ]);
        }
      
        $users = Users::find($request->id);
        if(!$users){
           return response()->json([
                'status' => false,
                'msg' => 'Usuario no encontrado',
                'type' => 'warning',
                'icon' => 'bi bi-exclamation-triangle',
            ]);
        }

        try{

            $users->dni         = $request->edit_numdoc;
            $users->nombres     = $request->edit_nom;
            $users->idperfil    = $request->editidperfil;
            $users->password    = $request->edit_password;
            $users->save();
            if($users){
                 return response()->json([
                    'status' => true,
                    'msg'    => 'Usuario actualizado exitosamente',
                    'type'   => 'success',
                    'icon'   => 'bi bi-check-circle',
                ]);
            }
            else {
                return response()->json([
                    'status' => false,
                    'msg'    => 'Error al actualizar el usuario',
                    'type'   => 'error',
                    'icon'   => 'bi bi-x-circle',
                ]);
            }

        }
        catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'msg' => 'Error: ' . $e->getMessage(),
                'type' => 'error',
                'icon' => 'bi bi-bug',
            ]);
        }

    }

    public function delete(Request $request){
        if(!$request->ajax()){
            return response()->json([
               'status' => false,
                'msg'    => 'Error en la solicitud, intente nuevamente',
                'type'   => 'warning',
                'icon'   => 'bi bi-exclamation-triangle', 
            ]);
        } 
        $users = Users::find($request->id);
        if(!$users){
           return response()->json([
                'status' => false,
                'msg'    => 'Error, no existe el usuario',
                'type'   => 'warning',
                'icon'   => 'bi bi-exclamation-triangle',
            ]);
            return; 
        }
        $users->estado = 1;
        $users->save();
        if($users){
            return response()->json([
                'status' => true,
                'msg'    => 'Usuario Desactivado exitosamente',
                'type'   => 'success',
                'icon'   => 'bi bi-check-circle',
                ]);
            }
            else {
                return response()->json([
                    'status' => false,
                    'msg'    => 'Error al Desactivar el usuario',
                    'type'   => 'error',
                    'icon'   => 'bi bi-x-circle',
                ]);
            }

    }

    public function activar(Request $request){
        if(!$request->ajax()){
            return response()->json([
               'status' => false,
                'msg'    => 'Error en la solicitud, intente nuevamente',
                'type'   => 'warning',
                'icon'   => 'bi bi-exclamation-triangle', 
            ]);
        } 
        $users = Users::find($request->id);
        if(!$users){
           return response()->json([
                'status' => false,
                'msg'    => 'Error, no existe el usuario',
                'type'   => 'warning',
                'icon'   => 'bi bi-exclamation-triangle',
            ]);
            return; 
        }
        $users->estado = 0;
        $users->save();
        if($users){
            return response()->json([
                'status' => true,
                'msg'    => 'Usuario activado exitosamente',
                'type'   => 'success',
                'icon'   => 'bi bi-check-circle',
                ]);
            }
            else {
                return response()->json([
                    'status' => false,
                    'msg'    => 'Error al activar el usuario',
                    'type'   => 'error',
                    'icon'   => 'bi bi-x-circle',
                ]);
            }

    }
}
