<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrestamodetalleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prestamodetalle', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('prestamo_id');
            $table->date('fecha_vencimiento');
            $table->decimal('monto_cuota', 10, 2);  
            $table->integer('nro_cuota');
            $table->foreign('prestamo_id')->references('id')->on('prestamo')->onDelete('cascade');
            $table->integer('estado')->default('0');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prestamodetalle');
    }
}
