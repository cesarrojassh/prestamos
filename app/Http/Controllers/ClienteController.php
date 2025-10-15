<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;

class ClienteController extends Controller
{
    public function index(Request $request)
    {
        if(!$request->session()->get('id')) {
            return redirect('/');
        }
        return view('clientes.index');
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

        $cliente = Cliente::select('*')->orderBy('id', 'DESC')
        ->get();

        return Datatables()
        ->of($cliente)
      ->addColumn('acciones', function ($cliente) {
        $id = $cliente->id;

    
        $btn = '<button type="button" class="btn btn-sm btn-primary btn-detail" data-id="'.$id.'" 
                    style="padding: 3px 6px; font-size: 12px;">
                    <i class="bi bi-pencil-square"></i>
                </button> ';
        if ($cliente->estado == 1) {
        
            $btn .= '<button type="button" class="btn btn-sm btn-warning btn-desactivar" data-id="'.$id.'" 
                        style="padding: 3px 6px; font-size: 12px;">
                        <i class="bi bi-person-dash"></i>
                    </button>';
        } else {
        
            $btn .= '<button type="button" class="btn btn-sm btn-success btn-activar" data-id="'.$id.'" 
                        style="padding: 3px 6px; font-size: 12px;">
                        <i class="bi bi-person-check"></i>
                    </button>';
        }

        return $btn;
    })
    ->addColumn('estado', function ($cliente) {
        $estado = $cliente->estado;

        if ($estado == 1) {
            return '<span class="badge bg-success">Activo</span>';
        } else {
            return '<span class="badge bg-danger">Inactivo</span>';
        }
    
    })
        
        ->rawColumns(['acciones', 'estado'])
        ->make(true);

    }

 
    public function store(Request $request)
    {
       if(!$request->ajax()) {
           return response()->json([
                'status' => false,
                'msg' => 'Intente de nuevo',
                'type' => 'warning'
           ]);
        }

        $dni = Cliente::where('numdoc', $request->cli_numdoc)->first();
        if($dni){
            return response()->json([
                'status' => false,
                'msg'    => 'El número de documento ya está registrado',
                'type'   => 'warning',
                'icon'   => 'bi bi-exclamation-triangle',
            ]);
        }
     
       try{
         

          $cliente = new Cliente();
          $cliente->numdoc     = $request->cli_numdoc;
          $cliente->tipodoc    = $request->cli_tipodoc;
          $cliente->nom        = $request->cli_nom;
          $cliente->direcion   = $request->cli_direcion;
          $cliente->telefono   = $request->cli_telefono;
          $cliente->estado_prestamo = '0';
          $cliente->save();
          if ($cliente) {
                return response()->json([
                    'status' => true,
                    'msg'    => 'Cliente registrado exitosamente',
                    'type'   => 'success',
                    'icon'   => 'bi bi-check-circle',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'msg'    => 'Error al registrar el cliente',
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

     public function reniec(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'status' => false,
                'msg' => 'Intente de nuevo',
                'type' => 'warning'
            ]);
        }
    
        $dni_ruc = $request->post('dni');
    
        if (strlen($dni_ruc) !== 8 && strlen($dni_ruc) !== 11) {
            return response()->json([
                'status' => false,
                'msg' => 'Documento inválido',
                'type' => 'error'
            ]);
        }
    
        $client = $this->buscar_reniec($dni_ruc);
      
    
        if (!isset($client->data) || $client->status == 404) {
            return response()->json([
                'status' => false,
                'msg' => 'No se encontró el documento',
                'type' => 'error',
                'icon' => 'bi bi-info-circle'
            ]);
        }
    
        $data = $client->data;
        
    
        if (strlen($dni_ruc) == 8) {
            // Es DNI
            return response()->json([
                'status' => true,
                'nombres' => $data->nombres ?? '',
                'apellidos' => trim(($data->apellido_paterno ?? '') . ' ' . ($data->apellido_materno ?? '')),
                'direccion' => $data->direccion ?? '',
                'departamento' => $data->departamento ?? '',
                'provincia' => $data->provincia ?? '',
                'distrito' => $data->distrito ?? '',
                'ubigeo' => $data->ubigeo_sunat ?? ''
            ]);
        } else {
            // Es RUC
            return response()->json([
                'status' => true,
                'nombres' => $data->nombre_o_razon_social ?? '',
                'apellidos' => '',
                'direccion' => $data->direccion ?? '',
                'departamento' => $data->departamento ?? '',
                'provincia' => $data->provincia ?? '',
                'distrito' => $data->distrito ?? '',
                'ubigeo' => $data->ubigeo_sunat ?? ''
            ]);
        }
    }

    public function delete(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'status' => false,
                'msg'    => 'Intente de nuevo',
                'type'   => 'warning'
            ]);
        }

        $cliente = Cliente::find($request->id);

        if (!$cliente) {
            return response()->json([
                'status' => false,
                'msg'    => 'Cliente no encontrado',
                'type'   => 'warning',
                'icon'   => 'bi bi-exclamation-triangle',
            ]);
        }

        try {
            
            $cliente->estado = '0'; 
            $cliente->save();

            return response()->json([
                'status' => true,
                'msg'    => 'Cliente desactivado exitosamente',
                'type'   => 'success',
                'icon'   => 'bi bi-check-circle',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'msg'    => 'Error: ' . $e->getMessage(),
                'type'   => 'error',
                'icon'   => 'bi bi-bug',
            ]);
        }
    }

    public function activar(Request $request)
    {
        $cliente = Cliente::find($request->id);
        if (!$cliente) {
            return response()->json(['status' => false, 'msg' => 'Cliente no encontrado']);
        }

        $cliente->estado = 1;
        $cliente->save();

        return response()->json(['status' => true, 'msg' => 'Cliente activado correctamente']);
    }

    public function edit(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'status' => false,
                'msg' => 'Intente de nuevo',
                'type' => 'warning'
            ]);
        }

        $cliente = Cliente::find($request->id);
      
        if (!$cliente) {
            return response()->json([
                'status' => false,
                'msg' => 'Cliente no encontrado',
                'type' => 'warning',
                'icon' => 'bi bi-exclamation-triangle',
            ]);
        }

        return response()->json([
            'status' => true,
            'data' => $cliente
        ]);
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'status' => false,
                'msg' => 'Intente de nuevo',
                'type' => 'warning'
            ]);
        }

        $cliente = Cliente::find($request->id);
        if (!$cliente) {
            return response()->json([
                'status' => false,
                'msg' => 'Cliente no encontrado',
                'type' => 'warning',
                'icon' => 'bi bi-exclamation-triangle',
            ]);
        }

        $dni = Cliente::where('numdoc', $request->cli_numdoc)
            ->where('id', '<>', $request->id)
            ->first();
        if ($dni) {
            return response()->json([
                'status' => false,
                'msg' => 'El número de documento ya está registrado',
                'type' => 'warning',
                'icon' => 'bi bi-exclamation-triangle',
            ]);
        }

        try {
            $cliente->numdoc = $request->cli_numdoc;
            $cliente->tipodoc = $request->cli_tipodoc;
            $cliente->nom = $request->cli_nom;
            $cliente->direcion = $request->cli_direcion;
            $cliente->telefono = $request->cli_telefono;
            $cliente->save();

            return response()->json([
                'status' => true,
                'msg' => 'Cliente actualizado exitosamente',
                'type' => 'success',
                'icon' => 'bi bi-check-circle',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'msg' => 'Error: ' . $e->getMessage(),
                'type' => 'error',
                'icon' => 'bi bi-bug',
            ]);
        }
    }

}
