<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modulos extends Model
{
    use HasFactory;
     protected $fillable = [
        'modulo_nombre',
        'modulo_padre',
        'ruta',
        'icono',
        'orden',
        'estado'
    ];
    protected $table      = 'modulos';
    protected $primaryKey = 'id';
    public function hijos()
    {
        // Le decimos a Laravel que este modelo tiene muchos 'Modulos' (hijos)
        // y que la columna que los une es 'modulo_padre'.
        // También los ordenamos por la columna 'orden'.
        return $this->hasMany(Modulos::class, 'modulo_padre')
                    ->orderBy('orden', 'asc');
    }
    public function perfiles()
    {
        return $this->belongsToMany(Perfiles::class, 'perfil_modulos', 'modulo_id', 'perfil_id');
    }
}
