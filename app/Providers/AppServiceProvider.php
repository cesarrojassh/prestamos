<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth; // Puedes dejar este 'use' o quitarlo
use App\Models\Modulos;

class AppServiceProvider extends ServiceProvider
{
    // ... (la función register)

    public function boot()
    {
        View::composer('*', function ($view) {
            
            // ESTE ES EL CAMBIO
            // Preguntamos si la variable 'id' existe en la sesión
            if (session()->has('id')) { 
                
                $menu_modulos = Modulos::where('modulo_padre', 0) 
                                    ->orWhereNull('modulo_padre')
                                    ->with('hijos') 
                                    ->orderBy('orden', 'asc')
                                    ->get();

                $view->with('menu_modulos', $menu_modulos);
            }
        });
    }
}