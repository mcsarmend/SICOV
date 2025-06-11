<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendance', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->onDelete('cascade'); // Relación con el cliente
            $table->timestamp('check_in')->useCurrent(); // Fecha y hora de registro
            $table->string('package_type')->nullable(); // Tipo de paquete (ej: "1_clases_638")
            $table->integer('classes_remaining')->nullable(); // Clases restantes después de este registro
            $table->integer('type')->nullable(); // Clases restantes después de este registro

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendance');
    }
}
