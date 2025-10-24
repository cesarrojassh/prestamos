<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    use HasFactory;
     protected $fillable = [
        'nombres',
        'usuario',
        'password',
        'idperfil',
        'estado',
       
    ];
    protected $table      = 'user';
    protected $primarykey = 'id';
}
