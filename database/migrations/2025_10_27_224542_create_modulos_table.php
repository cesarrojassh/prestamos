<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModulosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modulos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('modulo_nombre', 55);
            $table->tinyInteger('modulo_padre');
            $table->string('ruta', 255);
            $table->string('icono', 255);
            $table->string('orden', 255);
            $table->tinyInteger('estado')->default(1);


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('modulos');
    }
}
