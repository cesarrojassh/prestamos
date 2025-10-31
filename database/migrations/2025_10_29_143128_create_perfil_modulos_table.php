<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerfilModulosTable extends Migration
{
    public function up()
    {
        Schema::create('perfil_modulos', function (Blueprint $table) {
            // No necesitamos un 'id' autoincremental
            // $table->id(); 

            // Columna para el Perfil
            $table->unsignedBigInteger('perfil_id');
            // Columna para el Modulo
            $table->unsignedBigInteger('modulo_id');

            // --- Definir las Claves Foráneas ---

            // Conecta 'perfil_id' con la tabla 'perfiles'
            $table->foreign('perfil_id')
                  ->references('id')
                  ->on('perfiles')
                  ->onDelete('cascade'); // Si se borra un perfil, se borra la asignación

            // Conecta 'modulo_id' con la tabla 'modulos'
            $table->foreign('modulo_id')
                  ->references('id')
                  ->on('modulos')
                  ->onDelete('cascade'); // Si se borra un módulo, se borra la asignación

            // --- Definir la Clave Primaria ---
            // Esto evita duplicados (ej. no se puede asignar el mismo módulo 2 veces al mismo perfil)
            $table->primary(['perfil_id', 'modulo_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('perfil_modulos');
    }
}