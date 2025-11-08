<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Perfiles;
use App\Models\Modulos;
use App\Models\PerfilModulos;
use DB;


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
                $urlDestino = route('perfiles.modulos', $id);
                if ($perfiles->estado == '1') {
                    $btn = '
                        <button type="button" class="btn btn-sm btn-primary btn_detail" data-id="'.$id.'" 
                            style="padding: 3px 6px; font-size: 12px;">
                            <i class="bi bi-pencil-square"></i>
                        </button> 
                        <button type="button" class="btn btn-sm btn-success btn-activar" data-id="'.$id.'" 
                            style="padding: 3px 6px; font-size: 12px;">
                            <i class="bi bi-trash"></i>
                        </button>

                       <a href="' . $urlDestino . '" role="button" class="btn btn-sm btn-success" 
                        style="padding: 3px 6px; font-size: 12px;">
                            <i class="bi bi-send-fill"></i>
                        </a>'
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

                        </button>
                        
                        <a href="' . $urlDestino . '" role="button" class="btn btn-sm btn-success" 
                        style="padding: 3px 6px; font-size: 12px;">
                            <i class="bi bi-send-fill"></i>
                        </a>'
                        ;
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
            $perfiles->nombre = strtoupper($request->nombre);
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
            $perfil->nombre = strtoupper($nombre);
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

   public function activar_modulos($id)
    {
        
        $perfil = Perfiles::with('modulos')->find($id);
        $modulos_padre = Modulos::where('modulo_padre', 0) 
        ->with('hijos')
        ->orderBy('orden', 'asc')
        ->get();

        $modulos_asignados = $perfil->modulos->pluck('id')->toArray();

        
        return view('perfil_modulos.index', [
            'perfil'            => $perfil,
            'modulos_padre'     => $modulos_padre, 
            'modulos_asignados' => $modulos_asignados 
        ]);
    }



    public function asignar(Request $request){
        if(!$request->ajax()){
            return response()->json([
                'status' => false,
                'msg'    => 'Error en la solicitud, intente nuevamente',
                'type'   => 'warning',
                'icon'   => 'bi bi-exclamation-triangle',
            ]);
        }

        $modulos   = $request->modulos ?? []; 
        $idperfil  = $request->idperfil;

        if(empty($idperfil)){
            return response()->json([
                'status' => false,
                'msg'    => 'Debe seleccionar un perfil',
                'type'   => 'info',
                'icon'   => 'bi bi-info-circle',
            ]);
        }

        DB::transaction(function() use ($idperfil, $modulos) {
           PerfilModulos::where('perfil_id', $idperfil)->delete();
            foreach($modulos as $modulo){
                PerfilModulos::create([
                    'perfil_id' => $idperfil,
                    'modulo_id' => $modulo,
                ]);
            }
        });
        

        return response()->json([
            'status' => true,
            'msg'    => 'Módulos actualizados correctamente',
            'type'   => 'success',
            'icon'   => 'bi bi-check-circle',
        ]);
    }
}
