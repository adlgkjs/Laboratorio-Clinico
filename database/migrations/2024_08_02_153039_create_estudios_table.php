<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('estudios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBiginteger('unidad_negocio_id');            
            $table->string('codigo');
            $table->string('nombre');
            $table->string('sinonimo')->nullable();
            $table->string('tipo_muestra')->nullable();
            $table->string('metodologia')->nullable();
            $table->string('contenedor')->nullable();
            $table->string('indicaciones_paciente')->nullable();
            $table->string('condiciones_envio')->nullable();
            $table->string('estabilidad_muestra')->nullable();
            $table->string('interferencias')->nullable();
            $table->string('indicaciones_muestra')->nullable();
            $table->string('tiempo_entrega')->nullable();
            $table->string('dias_proceso')->nullable();
            $table->decimal('precio', 8, 2);
            $table->foreign('unidad_negocio_id')->references('id')->on('unidad_negocio'); //Para definir clave foranea
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estudios');
    }
};
