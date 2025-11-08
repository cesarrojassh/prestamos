<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Perfiles;
use App\Models\Modulos;


class ModulosController extends Controller
{
    public function index(Request $request){
        if(!$request->session()->get('id')) {
            return redirect('/');
        }
        $modulos = Modulos::where('modulo_padre', '=', 0)->get();
        return view('modulos.index', compact('modulos'));
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

           $modulos = new Modulos();
           $modulos->modulo_nombre  = $request->nombre;
           $modulos->modulo_padre   = $request->parent_id;
           $modulos->ruta           = $request->ruta;
           $modulos->icono          = $request->icono;
           $modulos->orden          = $request->orden;
           $modulos->estado         = 1;
           $modulos->save();

           if($modulos){
                return response()->json([
                    'status' => true,
                    'msg'    => 'Modulo registrado exitosamente',
                    'type'   => 'success',
                    'icon'   => 'bi bi-check-circle',
                ]);
           }
           else{
                
                return response()->json([
                    'status' => false,
                    'msg'    => 'Error al registrar el Modulo',
                    'type'   => 'error',
                    'icon'   => 'bi bi-x-circle',
                ]);

            }

            }catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'msg'    => 'Error: ' . $e->getMessage(),
                'type'   => 'error',
                'icon'   => 'bi bi-bug',
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

        $modulos = Modulos::orderBy('id', 'desc')->get();
        return Datatables()
        ->of($modulos)
          ->addColumn('action', function($modulos) {
                $id = $modulos->id;

                if ($modulos->estado == 0) {
                    $btn = '
                        <button type="button" class="btn btn-sm btn-primary btn_detail" data-id="'.$id.'" 
                            style="padding: 3px 6px; font-size: 12px;">
                            <i class="bi bi-pencil-square"></i>
                        </button> 
                        <button type="button" class="btn btn-sm btn-success btn-activar" data-id="'.$id.'" 
                            style="padding: 3px 6px; font-size: 12px;">
                            <i class="bi bi-trash"></i>
                        </button>'
                        ;
                } else {
                    $btn = '
                        <button type="button" class="btn btn-sm btn-primary btn_detail" data-id="'.$id.'" 
                            style="padding: 3px 6px; font-size: 12px;">
                            <i class="bi bi-pencil-square"></i>
                        </button> 
                        <button type="button" class="btn btn-sm btn-danger btn-delete" data-id="'.$id.'" 
                            style="padding: 3px 6px; font-size: 12px;">
                            <i class="bi bi-trash"></i>

                        </button>'
                        ;
                }

                return $btn;
            })

         ->addColumn('estado', function ($modulos) {
            $estado = $modulos->estado;
            if ($estado == '1') { 
                return '<span class="badge bg-success">Activo</span>';
            } else {
                return '<span class="badge bg-warning">Desactivado</span>';
            }
        })
        ->addColumn('tipo', function ($modulos) {
            if ($modulos->modulo_padre == 0) {
                return '<span>Padre</span>';
            } else {
                return '<span>Hijo</span>';
            }
        })
        ->rawColumns(['action', 'estado', 'tipo'])
        ->make(true);


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
        $modulo = Modulos::find($id);
        $modulos  = Modulos::get();
        if(!$modulo){
            return response()->json([
                'status' => false,
                'msg' => 'Modulo no encontrado',
                'type' => 'warning',
                'icon' => 'bi bi-exclamation-triangle',
            ]);  
        }
        return response()->json([
            'status'    => true,
            'modulo'   => $modulo,
            'modulos'  => $modulos
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
        try{

            $nombre     = $request->editnombre;
            $idpadre    = $request->editparent_id;
            $ruta       = $request->editruta;
            $icono      = $request->editicono;
            $orden      = $request->editorden;
            $id         = $request->id;

            $modulo     = Modulos::find($id);
            $modulo->modulo_nombre  = $nombre;
            $modulo->modulo_padre   = $idpadre;
            $modulo->ruta           = $ruta;
            $modulo->icono          = $icono;
            $modulo->orden          = $orden;
            $modulo->estado         = 1;
            $modulo->save();

            if($modulo){
                 return response()->json([
                    'status' => true,
                    'msg'    => 'Modulos actualizado exitosamente',
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
            
        }catch (\Exception $e) {
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
            $modulos  = Modulos::find($id);
            $modulos->estado = 0;
            $modulos->save();

             if($modulos){
                 return response()->json([
                    'status' => true,
                    'msg'    => 'Modulo Desactivado exitosamente',
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
            $modulos  = Modulos::find($id);
            $modulos->estado = 1;
            $modulos->save();

             if($modulos){
                 return response()->json([
                    'status' => true,
                    'msg'    => 'Modulo Activado exitosamente',
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
