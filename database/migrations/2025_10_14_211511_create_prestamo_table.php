<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrestamoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prestamo', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('cliente_id');
            $table->integer('idusuario');
            $table->decimal('monto', 10, 2);
            $table->decimal('interes', 5, 2);
            $table->integer('cuotas');
            $table->string('forma_pago');
            $table->string('moneda');
            $table->date('fecha_emision');
            $table->decimal('interes_total', 10, 2);
            $table->decimal('monto_total', 10, 2);
            $table->decimal('valor_cuota', 10, 2);
            $table->string('estado')->default('activo');
        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prestamo');
    }
}
