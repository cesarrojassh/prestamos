<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerfilModulos extends Model
{
    use HasFactory;
    protected $fillable = [
        'perfil_id',
        'modulo_id',
      
    ];
    protected $table      = 'perfil_modulos';
}
