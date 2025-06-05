<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashClosureTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_closure', function (Blueprint $table) {
            $table->id();
            $table->string('total_general', 255);
            $table->string('total_efectivo_entregar', 255);
            $table->text('formas_pago')->nullable();
            $table->string('inputs_adicionales', 2000)->nullable();
            $table->integer('vendedor')->nullable();
            $table->dateTime('fecha_cierre')->nullable();
            $table->string('estado', 50)->default('pendiente');
            $table->text('observaciones')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cash_closure');
    }
}
