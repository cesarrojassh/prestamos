<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
     protected $fillable = [
        'numdoc',
        'tipodoc',
        'nom',
        'direccion',
        'telefono',
    ];
    protected $table      = 'cliente';
    protected $primaryKey = 'id';
}
