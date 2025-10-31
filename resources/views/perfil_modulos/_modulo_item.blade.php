{{-- Este 'div' es para la indentación (el sangrado) --}}
<div style="padding-left: {{ $nivel * 25 }}px;">
    
    <div class="form-check">
        <input 
            class="form-check-input" 
            type="checkbox" 
            name="modulos[]"  {{-- El "[]" es crucial para que se envíe como array --}}
            value="{{ $modulo->id }}" 
            id="modulo_{{ $modulo->id }}"
            
            {{-- Marcamos 'checked' si el ID está en el array --}}
            {{ in_array($modulo->id, $modulos_asignados) ? 'checked' : '' }}
        >
        
        <label class="form-check-label" for="modulo_{{ $modulo->id }}">
            <i class="{{ $modulo->icono }}"></i>
            <strong>{{ $modulo->modulo_nombre }}</strong>
        </label>
    </div>

</div>

{{-- 
  AQUÍ LA RECURSIÓN:
  Si este módulo tiene hijos (gracias a la relación 'hijos' que cargamos 
  en el controlador), vuelve a incluir este mismo archivo por cada hijo.
--}}
@if($modulo->hijos->isNotEmpty())
    @foreach($modulo->hijos as $hijo)
        @include('perfil_modulos._modulo_item', [
            'modulo' => $hijo,
            'modulos_asignados' => $modulos_asignados,
            'nivel' => $nivel + 1  {{-- Aumentamos el nivel para más indentación --}}
        ])
    @endforeach
@endif