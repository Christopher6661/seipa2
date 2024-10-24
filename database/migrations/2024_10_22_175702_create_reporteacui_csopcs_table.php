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
        Schema::create('reporteacui_csopcs', function (Blueprint $table) {
            $table->id();
            $table->string('dia');
            $table->string('mes');
            $table->string('anio');
            $table->string('especie');
            $table->float('volumen_prodkg', 8, 2);
            $table->float('talla_promedio', 8, 2);
            $table->string('destino_produccion');
            $table->float('valor_estimado_cap', 8, 2);
            $table->string('siembra_dias');
            $table->string('siembra_mes');
            $table->string('siembra_anio');
            $table->string('unidad_receptora');
            $table->string('siembra_especie');
            $table->string('numero_organismos');
            $table->string('estadio');
            $table->string('pais');
            $table->string('estado');
            $table->string('municipio');
            $table->string('localidad');
            $table->string('unidad_procedencia');
            $table->string('certificado_sanitario');
            $table->string('guia_pesca');
            $table->float('valor_lote', 8, 2);
            $table->string('metodo_traslado');
            $table->string('criasemilla_dia');
            $table->string('criasemilla_mes');
            $table->string('criasemilla_anio');
            $table->string('num_organismosem');
            $table->date('periodo_prod_ini');
            $table->date('periodo_prod_fin');
            $table->string('estadio_salida');
            $table->string('talla_salida');
            $table->string('destino_prod');
            $table->float('valor_produccion', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reporteacui_csopcs');
    }
};
