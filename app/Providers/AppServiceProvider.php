<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth; // Puedes dejar este 'use' o quitarlo
use App\Models\Modulos;
use DB;

class AppServiceProvider extends ServiceProvider
{
    // ... (la función register)

    public function boot()
{
    View::composer('*', function ($view) {

        if (session()->has('id') && session()->has('idperfil')) {

            $idperfil = session('idperfil');
            $modulos_ids = DB::table('perfil_modulos')
                             ->where('perfil_id', $idperfil)
                             ->pluck('modulo_id')
                             ->toArray();

            
            $menu_modulos = Modulos::whereIn('id', $modulos_ids)
                                   ->where(function($query){
                                       $query->where('modulo_padre', 0)
                                             ->orWhereNull('modulo_padre');
                                   })
                                   ->with(['hijos' => function($q) use ($modulos_ids) {
                                        $q->whereIn('id', $modulos_ids)
                                          ->orderBy('orden', 'asc');
                                   }])
                                   ->orderBy('orden', 'asc')
                                   ->get();

            $view->with('menu_modulos', $menu_modulos);
        }
    });
}
}