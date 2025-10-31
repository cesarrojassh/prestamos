@extends('layouts.layout')
@section('title_content_ol', 'ASIGNAR MODULOS A PERFIL')
@section('content')

<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            Perfil: <strong>{{ $perfil->nombre }}</strong>
           <input id="idperfil" type="hidden" value="{{$perfil->id}}">
        </h3>
    </div>
    <div class="card-body">
        
        {{-- Asumo que tendrás una ruta para guardar --}}
        <form id="modulos">
            @csrf

            <div class="form-group">
                <h4>Lista de Módulos</h4>
                
                {{-- 
                  Recorremos SOLO los módulos padre y llamamos a la vista parcial
                  (Crea una carpeta 'partials' dentro de 'perfil_modulos')
                --}}
                @foreach($modulos_padre as $modulo)
                    @include('perfil_modulos._modulo_item', [
                        'modulo' => $modulo,
                        'modulos_asignados' => $modulos_asignados,
                        'nivel' => 0
                    ])
                @endforeach
                
            </div>

            <hr>
            <div class="text-right">
                <button type="submit" class="btn btn-primary btn_save">Guardar Cambios</button>
            </div>
        </form>
    </div>
</div>

@endsection
@section('scripts')
    @include('perfil_modulos._myjs')
@endsection