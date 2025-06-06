<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->integer('idcliente')->nullable();
            $table->decimal('monto', 10, 2)->nullable();
            $table->string('concepto', 255)->nullable();
            $table->date('fecha_pago')->nullable();
            $table->string('metodo_pago', 100)->nullable();
            $table->string('idusuario', 100)->nullable();
            $table->string('observaciones', 255)->nullable();
            $table->string('mes_correspondiente', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
