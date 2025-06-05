<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100)->nullable();
            $table->string('telefono', 100)->nullable();
            $table->boolean('gimnasio')->default(false);
            $table->boolean('alberca')->default(false);
            $table->string('observaciones',255);
            $table->string('paquete_alberca', 100)->nullable();
            $table->string('horario_alberca', 100)->nullable();
            $table->string('tipo', 100)->nullable();
            $table->string('idusuario', 100)->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clients');
    }
}
