<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Perfiles;

class PerfilesController extends Controller
{
    public function index(Request $request){
        if(!$request->session()->get('id')) {
            return redirect('/');
        }
        return view('perfiles.index');
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

        $perfiles = Perfiles::orderBy('id', 'desc')->get();
        return Datatables()
        ->of($perfiles)
          ->addColumn('action', function($perfiles) {
                $id = $perfiles->id;

                if ($perfiles->estado == '1') {
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

         ->addColumn('estado', function ($perfiles) {
            $estado = $perfiles->estado;
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

        try{

            $perfiles = new Perfiles();
            $perfiles->nombre = $request->nombre;
            $perfiles->estado = 0;
            $perfiles->save();

            if($perfiles){
                return response()->json([
                    'status' => true,
                    'msg'    => 'Perfil registrado exitosamente',
                    'type'   => 'success',
                    'icon'   => 'bi bi-check-circle',
                ]);

            }
            else{
                
                return response()->json([
                    'status' => false,
                    'msg'    => 'Error al registrar el Perfil',
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

        $id = $request->id;
        $perfil = Perfiles::where('id', $id)->first();
        if(!$perfil){
           return response()->json([
                'status' => false,
                'msg' => 'Perfil no encontrado',
                'type' => 'warning',
                'icon' => 'bi bi-exclamation-triangle',
            ]); 
        }
        return response()->json([
            'status' => true,
            'data'   => $perfil,
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

        $id         = $request->id;
        $nombre     = $request->nombre;

        try{

            $perfil = Perfiles::find($id);
            $perfil->nombre = $nombre;
            $perfil->save();

            if($perfil){
                 return response()->json([
                    'status' => true,
                    'msg'    => 'Perfil actualizado exitosamente',
                    'type'   => 'success',
                    'icon'   => 'bi bi-check-circle',
                ]);
            }
            return response()->json([
                'status' => false,
                'msg' => 'Algo ocurrio, intente nuevamente',
                'type' => 'warning',
                'icon' => 'bi bi-exclamation-triangle',
            ]); 
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

    public function delete(Request $request){

         if(!$request->ajax()){
            return response()->json([
                'status' => false,
                'msg'    => 'Error en la solicitud, intente nuevamente',
                'type'   => 'warning',
                'icon'   => 'bi bi-exclamation-triangle',
            ]);
        }

        try{
            $id       = $request->id;
            $perfiles = Perfiles::find($id);
            $perfiles->estado = 1;
            $perfiles->save();

             if($perfiles){
                 return response()->json([
                    'status' => true,
                    'msg'    => 'Perfil Desactivado exitosamente',
                    'type'   => 'success',
                    'icon'   => 'bi bi-check-circle',
                ]);
            }
             return response()->json([
                'status' => false,
                'msg' => 'Algo ocurrio, intente nuevamente',
                'type' => 'warning',
                'icon' => 'bi bi-exclamation-triangle',
            ]); 
       
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


    public function activar(Request $request){

        if(!$request->ajax()){
            return response()->json([
                'status' => false,
                'msg'    => 'Error en la solicitud, intente nuevamente',
                'type'   => 'warning',
                'icon'   => 'bi bi-exclamation-triangle',
            ]);
        }

        try{
            $id       = $request->id;
            $perfiles = Perfiles::find($id);
            $perfiles->estado = 0;
            $perfiles->save();

             if($perfiles){
                 return response()->json([
                    'status' => true,
                    'msg'    => 'Perfil activado exitosamente',
                    'type'   => 'success',
                    'icon'   => 'bi bi-check-circle',
                ]);
            }
             return response()->json([
                'status' => false,
                'msg' => 'Algo ocurrio, intente nuevamente',
                'type' => 'warning',
                'icon' => 'bi bi-exclamation-triangle',
            ]); 
       
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
}
