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
        Schema::create('registro_dattececon_am', function (Blueprint $table) {
            $table->id();
            $table->float('prodprom_x_mes');
            $table->enum('prodpromx_mes_peso', ['Kilogramo', 'Tonelada']);
            $table->float('prodprom_mes_talla');
            $table->string('ciclocultivoultimo_anio');
            $table->string('ciclocult_ultanio_mes');
            $table->string('capturacosecha_anio');
            $table->enum('capturacos_anio_peso', ['Kilogramo', 'Tonelada']);
            $table->float('captcosanio_mortalidad');
            $table->float('destino_autoconsimo');
            $table->float('destino_comercializacio');
            $table->float('destino_otro');
            $table->boolean('tipo_mercado_local')->default(false);
            $table->boolean('tipo_mercado_estatal')->default(false);
            $table->boolean('tipo_mercado_regional')->default(false);
            $table->boolean('tipo_mercado_otro')->default(false);
            $table->boolean('fresco_entero')->default(false);
            $table->decimal('fresco_entero_preckilo', 2,8);
            $table->boolean('evicerado')->default(false);
            $table->decimal('evicerado_preciokilo', 2,8);
            $table->boolean('enhielado')->default(false);
            $table->decimal('enhielado_preciokilo', 2,8);
            $table->boolean('otro')->default(false);
            $table->decimal('otro_preciokilo');
            $table->float('fuenfinanza_programa');
            $table->float('fuentefianza_anio');
            $table->float('costogasto_anualprod');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registro_dattececon_am');
    }
};
