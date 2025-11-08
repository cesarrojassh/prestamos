<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerfilModulosTable extends Migration
{
    public function up()
    {
        Schema::create('perfil_modulos', function (Blueprint $table) {
            // Columnas principales
            $table->unsignedBigInteger('perfil_id');
            $table->unsignedBigInteger('modulo_id');

            // Timestamps
            $table->timestamps();

            // --- Claves foráneas ---
            $table->foreign('perfil_id')
                ->references('id')
                ->on('perfiles')
                ->onDelete('cascade');

            $table->foreign('modulo_id')
                ->references('id')
                ->on('modulos')
                ->onDelete('cascade');

            // --- Clave primaria compuesta ---
            $table->primary(['perfil_id', 'modulo_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('perfil_modulos');
    }
}
