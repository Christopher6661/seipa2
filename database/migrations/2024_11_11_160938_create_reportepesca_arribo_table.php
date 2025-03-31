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
        Schema::create('reportepesca_arribo', function (Blueprint $table) {
            $table->id();
            $table->string('dia');
            $table->string('mes');
            $table->string('anio');
            $table->string('especie');
            $table->float('volumen_prodkg');
            $table->float('talla_promedio');
            $table->string('zona_captura');
            $table->float('valor_estimado_cap');
            $table->string('embarcacion');
            $table->string('arte_pesca');
            $table->string('metodo_traslado');
            $table->enum('pesca_incidental', ['Sí', 'No']);
            $table->enum('quien_hizo_reporte', ['Representante', 'Socio']);
            $table->string('nombre_hizo_rep');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reportepesca_arribo');
    }
};
