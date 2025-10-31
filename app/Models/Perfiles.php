<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perfiles extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'estado',
      
    ];
    protected $table      = 'perfiles';
    protected $primaryKey = 'id';
    public function modulos()
    {
       return $this->belongsToMany(Modulos::class, 'perfil_modulos', 'perfil_id', 'modulo_id');
    }
}
